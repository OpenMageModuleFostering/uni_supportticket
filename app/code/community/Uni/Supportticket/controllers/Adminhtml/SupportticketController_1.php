<?php

class Uni_Supportticket_Adminhtml_SupportticketController extends Mage_Adminhtml_Controller_Action {

    protected function _initAction() {
        $this->loadLayout()->_setActiveMenu("supportticket/supportticket")->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticket  Manager"), Mage::helper("adminhtml")->__("Supportticket Manager"));
        return $this;
    }

    public function indexAction() {
        $this->_title($this->__("Supportticket"));
        $this->_title($this->__("Manager Support Ticket"));

        $this->_initAction();
        $this->renderLayout();
    }

    public function editAction() {
        $this->_title($this->__("Supportticket"));
        $this->_title($this->__("Supportticket"));
        $this->_title($this->__("Edit Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("supportticket/supportticket")->load($id);
        if ($model->getId()) {
            Mage::register("supportticket_data", $model);
            $this->loadLayout();
            $this->_setActiveMenu("supportticket/supportticket");
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticket Manager"), Mage::helper("adminhtml")->__("Supportticket Manager"));
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticket Description"), Mage::helper("adminhtml")->__("Supportticket Description"));
            $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock("supportticket/adminhtml_supportticket_edit"))->_addLeft($this->getLayout()->createBlock("supportticket/adminhtml_supportticket_edit_tabs"));
//					$this->_addContent($this->getLayout()->createBlock("supportticket/adminhtml_supportticket_edit"));
            $this->renderLayout();
        } else {
            Mage::getSingleton("adminhtml/session")->addError(Mage::helper("supportticket")->__("Item does not exist."));
            $this->_redirect("*/*/");
        }
    }

    public function newAction() {


        $this->_title($this->__("Supportticket"));
        $this->_title($this->__("Supportticket"));
        $this->_title($this->__("New Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("supportticket/supportticket")->load($id);

        $data = Mage::getSingleton("adminhtml/session")->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register("supportticket_data", $model);

        $this->loadLayout();
        $this->_setActiveMenu("supportticket/supportticket");

        $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticket Manager"), Mage::helper("adminhtml")->__("Supportticket Manager"));
        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticket Description"), Mage::helper("adminhtml")->__("Supportticket Description"));


        $this->_addContent($this->getLayout()->createBlock("supportticket/adminhtml_supportticket_edit"))->_addLeft($this->getLayout()->createBlock("supportticket/adminhtml_supportticket_edit_tabs"));
//        $this->_addContent($this->getLayout()->createBlock("supportticket/adminhtml_supportticket_edit"));

        $this->renderLayout();
    }

    public function saveAction() {
        $post_data = $this->getRequest()->getPost();
        $_helper = Mage::helper('supportticket');
        if (isset($post_data['ticket_repliess']) && $post_data['ticket_repliess']) {
            $post_data['ticket_replies'] = $post_data['ticket_repliess'];
        }
        if (isset($post_data['is_admin1']) && $post_data['is_admin1']) {
            $post_data['is_admin'] = $post_data['is_admin1'];
        }
        if (isset($_FILES['ticket_attachment']['name']) and (file_exists($_FILES['ticket_attachment']['tmp_name']))) {
            try {
                $uploader = new Varien_File_Uploader('ticket_attachment');
//                        $uploader->setAllowedExtensions(array('doc', 'docx', 'pdf', 'jpg', 'jpeg', 'png', 'bmp', 'gif'));
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                $filename = "File-" . time() . $_FILES['ticket_attachment']['name'];
                $filename = str_replace(' ', '-', $filename);
                $path = Mage::getBaseDir('media') . DS . 'supportticket' . DS;
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                $uploader->save($path, $filename);
                $newFilename = $uploader->getUploadedFileName();
                $post_data['ticket_attachment'] = $filename;
            } catch (Exception $e) {
                $error = true;
                Mage::getSingleton('core/session')->addError(Mage::helper('supportticket')->__('Uploaded File format not allowed'));
                $this->_redirect('supportticket');
                return;
            }
        }
        
        if ($post_data) {
//            zend_debug::dump($post_data);exit;
            try {
                $id = $this->getRequest()->getParam("id");
                $code = Mage::getBlockSingleton('supportticket/index')->generateCode(6);
                $date = date('m/d/Y h:i:s a', time());
                $model = Mage::getModel("supportticket/supportticket")
                        ->addData($post_data);
                if (isset($post_data['ticket_replies']) && $post_data['ticket_replies']) {
                    $model1 = Mage::getModel("supportticket/supportticketreply")
                            ->addData($post_data);
                    $model1->setTicketReplies($post_data['ticket_replies'])
                            ->setReplyTime($date)
                            ->save();
                    $emailTemplate = Mage::getModel('core/email_template')->loadDefault('supportticketreply_email_email_template');

                    $adminEmail = Mage::getStoreConfig('support_ticket_ultimate/general_email_settings/supervisor_email');
                    $adminName = Mage::getStoreConfig('support_ticket_ultimate/general_email_settings/supervisor_name');
                    $emailTemplateVariables = array(
//                        'userid' => $post_data['user_id'],
                        'ticketid' => $post_data['ticket_id'],
                        'name' => $post_data['user_name'],
                        'reply' => $post_data['ticket_replies'],
                    );
                    try {
                        $emailTemplate->setSenderName($adminName);
                        $emailTemplate->setSenderEmail($adminEmail);
                        $emailTemplate->send($adminEmail, $adminName, $emailTemplateVariables);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }

                if (!$id) {
                    $model->setTicketId($code)
                            ->setCreateTime($date);
                }
                if ($post_data['reply_count'] !== null) {
                    $repCount = $post_data['reply_count'];
                }
                $model->setUpdateTime($date)
                        ->setId($this->getRequest()->getParam("id"))
                        ->setReplyCount(++$repCount)
                        ->save();
                $emailTemplate = Mage::getModel('core/email_template')->loadDefault('supportticket_email_email_template');

                $attachmentFilePath = Mage::getBaseDir('media') . DS . 'supportticket' . DS . $filename;

                if ($_FILES['ticket_attachment']['name']) {
                    if (file_exists($attachmentFilePath)) {
                        $fileContents = file_get_contents($attachmentFilePath);
                        $attachment = $emailTemplate->getMail()->createAttachment($fileContents);
                        $attachment->filename = $filename;
                    }
                }
                $priorities = $_helper->getAdminTicketPrioritys();
                $departments = $_helper->getAdminTicketDepartments();
                foreach ($priorities as $key => $value) {
                    if ($key == $post_data['ticket_priority']) {
                        $post_data['ticket_priority'] = $value;
                    }
                }
                foreach ($departments as $key => $value) {
                    if ($key == $post_data['department']) {
                        $post_data['ticket_department'] = $value;
                    }
                }
                $adminEmail = Mage::getStoreConfig('support_ticket_ultimate/general_email_settings/supervisor_email');
                $adminName = Mage::getStoreConfig('support_ticket_ultimate/general_email_settings/supervisor_name');
                $emailTemplateVariables = array(
//                    'userid' => $post_data['user_id'],
                    'ticketid' => isset($post_data['ticket_id']) ? $post_data['ticket_id'] : $code,
                    'name' => $post_data['user_name'],
                    'email' => $post_data['user_email'],
                    'ticketmsg' => $post_data['ticket_message'],
                    'ticketsub' => $post_data['ticket_subject'],
                    'ticketprio' => $post_data['ticket_priority'],
                    'ticketdept' => $post_data['ticket_department']
                );
                
                try {
                    $emailTemplate->setSenderName($adminName);
                    $emailTemplate->setSenderEmail($adminEmail);
                    $emailTemplate->send($post_data['user_email'],$post_data['user_name'], $emailTemplateVariables);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }

                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Support Ticket was successfully saved"));
                Mage::getSingleton("adminhtml/session")->setSupportticketData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirect("*/*/");
                return;
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                Mage::getSingleton("adminhtml/session")->setSupportticketData($this->getRequest()->getPost());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
                return;
            }
        }
        $this->_redirect("*/*/");
    }

    public function deleteAction() {
        if ($this->getRequest()->getParam("id") > 0) {
            try {
                $model = Mage::getModel("supportticket/supportticket");
                $model->setId($this->getRequest()->getParam("id"))->delete();
                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item was successfully deleted"));
                $this->_redirect("*/*/");
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
            }
        }
        $this->_redirect("*/*/");
    }

    public function massRemoveAction() {
        try {
            $ids = $this->getRequest()->getPost('entity_ids', array());
            foreach ($ids as $id) {
                $model = Mage::getModel("supportticket/supportticket");
                $model->setId($id)->delete();
            }
            Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Item(s) was successfully removed"));
        } catch (Exception $e) {
            Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
        }
        $this->_redirect('*/*/');
    }

    /**
     * Export order grid to CSV format
     */
    public function exportCsvAction() {
        $fileName = 'supportticket.csv';
        $grid = $this->getLayout()->createBlock('supportticket/adminhtml_supportticket_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction() {
        $fileName = 'supportticket.xml';
        $grid = $this->getLayout()->createBlock('supportticket/adminhtml_supportticket_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

}
