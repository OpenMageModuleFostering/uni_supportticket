<?php

class Uni_Supportticket_Adminhtml_SupportticketController extends Mage_Adminhtml_Controller_Action {

    /**
     * Set active menu and Breadcrumb
     * @return \Uni_Supportticket_Adminhtml_SupportticketController
     */
    protected function _initAction() {
        $this->loadLayout()->_setActiveMenu("supportticket/supportticket")->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticket  Manager"), Mage::helper("adminhtml")->__("Supportticket Manager"));
        return $this;
    }

    /**
     * Display grid for generated tickets
     */
    public function indexAction() {
        $this->_title($this->__("Supportticket"));
        $this->_title($this->__("Manager Support Ticket"));

        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Rendering layout for ticket edit action
     */
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
            $this->renderLayout();
        } else {
            Mage::getSingleton("adminhtml/session")->addError(Mage::helper("supportticket")->__("Item does not exist."));
            $this->_redirect("*/*/");
        }
    }

    /**
     * Renders layout for new ticket
     */
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
        $this->renderLayout();
    }

    /**
     * Save new TicketTicket
     * 
     */
    public function saveAction() {
        $post_data = $this->getRequest()->getPost();
     
        $_helper = Mage::helper('supportticket');
        if (isset($post_data['ticket_repliess']) && $post_data['ticket_repliess']) {
            $post_data['ticket_replies'] = $post_data['ticket_repliess'];
        }
        if (isset($post_data['is_admin1']) && $post_data['is_admin1']) {
            $post_data['is_admin'] = $post_data['is_admin1'];
        }
        /**
         * if attachment is for new ticket
         */
        if (isset($_FILES['create_ticket_attachment']['name']) and (file_exists($_FILES['create_ticket_attachment']['tmp_name'])) and isset($_FILES['create_ticket_attachment']['size'])) {
            try {
                $_fileSizeCreate = $_FILES['create_ticket_attachment']['size'];
                $_flag = 0;
                if ($_fileSizeCreate > 10485760) {
                    $_flag = 1;
                    throw new Exception();
                }
                $uploader = new Varien_File_Uploader('create_ticket_attachment');
                $uploader->setAllowRenameFiles(false);
                $uploader->setFilesDispersion(false);
                $filename = "File-" . time() . $_FILES['create_ticket_attachment']['name'];
                $filename = str_replace(' ', '-', $filename);
                $path = Mage::getBaseDir('media') . DS . 'supportticket' . DS;
                if (!is_dir($path)) {
                    mkdir($path, 0777, true);
                }
                $uploader->save($path, $filename);
                $newFilename = $uploader->getUploadedFileName();
                $post_data['create_ticket_attachment'] = $filename;
            } catch (Exception $e) {
                if ($_flag == 1) {
                    Mage::getSingleton('core/session')->addError(Mage::helper('supportticket')->__('Maximum file size allowed is 10MB'));
                }
                $error = true;
                Mage::getSingleton('core/session')->addError(Mage::helper('supportticket')->__('Uploaded File format not allowed'));
                $this->_redirectReferer();
                return;
            }
        }
        /**
         * if attachment done for editing the ticket
         */ elseif (isset($_FILES['ticket_attachment']['name']) and (file_exists($_FILES['ticket_attachment']['tmp_name'])) and isset($_FILES['ticket_attachment']['size'])) {
            try {
                $_flag2 = 0;
                $_fileSizeEdit = $_FILES['ticket_attachment']['size'];
                if ($_fileSizeEdit > 10485760) {
                    $_flag2 = 1;
                    throw new Exception();
                }
                $uploader = new Varien_File_Uploader('ticket_attachment');
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
                if ($_flag2 == 1) {
                    Mage::getSingleton('core/session')->addError(Mage::helper('supportticket')->__('Maximum file size allowed is 10MB'));
                }
                $error = true;
                Mage::getSingleton('core/session')->addError(Mage::helper('supportticket')->__('Uploaded File format not allowed'));
                $this->_redirectReferer('supportticket');
                return;
            }
        }

        if ($post_data) {
            try {
                $id = $this->getRequest()->getParam("id");
                $code = Mage::getBlockSingleton('supportticket/index')->generateCode(6);
                $date = date('m/d/Y h:i:s a', time());
                $model = Mage::getModel("supportticket/supportticket")
                        ->addData($post_data);
                /**
                 * if ticket reply has been done
                 */
                if (isset($post_data['ticket_replies']) && $post_data['ticket_replies']) {
                    $model1 = Mage::getModel("supportticket/supportticketreply")
                            ->addData($post_data);
                    $model1->setTicketReplies($post_data['ticket_replies'])
                            ->setReplyTime($date)
                            ->save();
                    if ($post_data['reply_count'] !== null) {
                        $repCount = $post_data['reply_count'];
                    }
                    if (!$id) {
                        $model->setTicketId($code)
                                ->setCreateTime($date);
                    }
                    $model->setUpdateTime($date)
                            ->setId($this->getRequest()->getParam("id"))
                            ->setReplyCount(++$repCount)
                            ->save();
                    $emailTemplate = Mage::getModel('core/email_template')->loadDefault('supportticketreply_email_email_template');
                    $adminEmail = Mage::getStoreConfig('support_ticket_ultimate/general_email_settings/supervisor_email');
                    $adminName = Mage::getStoreConfig('support_ticket_ultimate/general_email_settings/supervisor_name');
                    if (isset($_FILES['ticket_attachment']['name']) && $_FILES['ticket_attachment']['name']) {
                        $attachmentFilePath = Mage::getBaseDir('media') . DS . 'supportticket' . DS . $post_data['ticket_attachment'];
                        if (file_exists($attachmentFilePath)) {
                            $fileContents = file_get_contents($attachmentFilePath);
                            $attachment = $emailTemplate->getMail()->createAttachment($fileContents);
                            $attachment->filename = $filename;
                        }
                    }
                    $emailTemplateVariables = array(
                        'ticketid' => $post_data['ticket_id'],
                        'name' => $post_data['user_name'],
                        'reply' => $post_data['ticket_replies'],
                    );
                    try {
                        $emailTemplate->setSenderName($adminName);
                        $emailTemplate->setSenderEmail($adminEmail);
                        $emailTemplate->send($post_data['user_email'], $adminName, $emailTemplateVariables);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
                }
//                reply code ends
                else {
                    if (!$id) {
                        $model->setTicketId($code)
                                ->setCreateTime($date);
                    }
                    $model->setUpdateTime($date)
                            ->setId($this->getRequest()->getParam("id"))
                            ->save();
                    $emailTemplate = Mage::getModel('core/email_template')->loadDefault('supportticket_email_email_template');
                    if (isset($_FILES['create_ticket_attachment']['name']) && $_FILES['create_ticket_attachment']['name']) {
                        $attachmentFilePath = Mage::getBaseDir('media') . DS . 'supportticket' . DS . $post_data['create_ticket_attachment'];
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
                        $emailTemplate->send($post_data['user_email'], $post_data['user_name'], $emailTemplateVariables);
                    } catch (Exception $e) {
                        echo $e->getMessage();
                    }
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

    /**
     * deletes the ticket
     */
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

    /**
     * mass removal action 
     */
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
//    

}
