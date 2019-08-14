<?php

class Uni_Supportticket_SupportticketreplyController extends Mage_Core_Controller_Front_Action {

    
    
     /**
     * Display support ticket reply on frontend
     */   
    
    public function IndexAction() {

        $this->loadLayout();
        $this->getLayout()->getBlock("head")->setTitle($this->__("Supportticketreply"));
        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
        $breadcrumbs->addCrumb("home", array(
            "label" => $this->__("Home Page"),
            "title" => $this->__("Home Page"),
            "link" => Mage::getBaseUrl()
        ));

        $breadcrumbs->addCrumb("support ticket", array(
            "label" => $this->__("Supportticketreply"),
            "title" => $this->__("Supportticketreply")
        ));

        $this->renderLayout();
    }

    
    
      
     /**
     * Save support ticket reply of user
     */   
    

    public function saveAction() {
        $post_data = $this->getRequest()->getPost();
        if ($post_data) {
            try {
                $error = false;
                if (!Zend_Validate::is(trim($post_data['ticket_replies']), 'NotEmpty')) {
                    $error = true;
                }
                $filename = '';
                if (isset($_FILES['ticket_attachment']['name']) and (file_exists($_FILES['ticket_attachment']['tmp_name']))) {
                    try {
                        $uploader = new Varien_File_Uploader('ticket_attachment');
                        $uploader->setAllowedExtensions(array('doc', 'docx', 'pdf', 'jpg', 'jpeg', 'png', 'bmp', 'gif'));
                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);
                        $filename = "File-" . time() . $_FILES['ticket_attachment']['name'];
                        $filename = str_replace(' ', '-', $filename);
                        $path = Mage::getBaseDir('media') . DS . 'supportticketreply' . DS;
                        if (!is_dir($path)) {
                            mkdir($path, 0777, true);
                        }
                        $uploader->save($path, $filename);
                        $newFilename = $uploader->getUploadedFileName();
                    } catch (Exception $e) {
                        $error = true;
                        Mage::getSingleton('core/session')->addError(Mage::helper('supportticket')->__('Uploaded File format not allowed'));
                        $this->_redirect('supportticket');
                        return;
                    }
                }
                if ($error) {
                    throw new Exception();
                }

                $date = date('m/d/Y h:i:s a', time());
//for save reply count
                $supporttModel = Mage::getModel("supportticket/supportticket")->load($post_data['id']);
                $repCount = $supporttModel['reply_count'];
                $supporttModel->setReplyCount( ++$repCount);
                $supporttModel->setUpdateTime($date);
                $supporttModel->save();

                $model = Mage::getModel("supportticket/supportticketreply")
                        ->addData($post_data)
                        ->setReplyTime($date);
                if ($_FILES['ticket_attachment']['name'] == ''):
                    $model->setTicketAttachment('No Attachment Found');
                else:
                    $model->setTicketAttachment($filename);
                endif;
                $model->save();

                $emailTemplate = Mage::getModel('core/email_template')->loadDefault('supportticketreply_email_email_template');
                $attachmentFilePath = Mage::getBaseDir('media') . DS . 'supportticketreply' . DS . $filename;
                if ($_FILES['ticket_attachment']['name']) {
                    if (file_exists($attachmentFilePath)) {
                        $fileContents = file_get_contents($attachmentFilePath);
                        $attachment = $emailTemplate->getMail()->createAttachment($fileContents);
                        $attachment->filename = $filename;
                    }
                }

                $adminEmail = Mage::getStoreConfig('support_ticket_ultimate/general_email_settings/supervisor_email');
                $adminName = Mage::getStoreConfig('support_ticket_ultimate/general_email_settings/supervisor_name');
                $emailTemplateVariables = array(
                    'userid' => $post_data['user_id'],
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

                Mage::getSingleton("core/session")->addSuccess(Mage::helper("supportticket")->__("Reply was successfully Posted"));
                Mage::getSingleton("core/session")->setSupportticketData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirectReferer();
                return;
            } catch (Exception $e) {
                Mage::getSingleton("core/session")->addError($e->getMessage());
                Mage::getSingleton("core/session")->setSupportticketData($this->getRequest()->getPost());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
                return;
            }
        }
        $this->_redirect("*/*/");
    }
    
      /**
     * Download attachment on frontend
     */   
    

    public function downloadAction() {
        $entityid = $this->getRequest()->getParam('entity_id');
        $customer_data = Mage::getModel('supportticket/supportticketreply')->load($entityid)->getData();
        $filename = '';
        if ($customer_data) {
            $filename = $customer_data['ticket_attachment'];
        }
        $filepath = Mage::getBaseDir('media') . DS . 'supportticketreply' . DS . $filename;

        if (!is_file($filepath) || !is_readable($filepath)) {
            throw new Exception ( );
        }
        $this->getResponse()
                ->setHttpResponseCode(200)
                ->setHeader('Cache-Control', 'must-revalidate, post-check=0, pre-check=0', true)
                ->setHeader('Pragma', 'public', true)
                ->setHeader('Content-type', 'application/force-download')
                ->setHeader('Content-Length', filesize($filepath))
                ->setHeader('Content-Disposition', 'attachment' . '; filename=' . basename($filepath));
        $this->getResponse()->clearBody();
        $this->getResponse()->sendHeaders();
        readfile($filepath);
        exit;
    }

}
