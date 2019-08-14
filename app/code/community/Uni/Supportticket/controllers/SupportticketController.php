<?php

class Uni_Supportticket_SupportticketController extends Mage_Core_Controller_Front_Action {

    const SET_DISABLED = 3;
    
    /**
     * Display support ticket on frontend
     */   
    
    
    public function IndexAction() {

        $this->loadLayout();
        $this->getLayout()->getBlock("head")->setTitle($this->__("Supportticket"));
        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
        $breadcrumbs->addCrumb("home", array(
            "label" => $this->__("Home Page"),
            "title" => $this->__("Home Page"),
            "link" => Mage::getBaseUrl()
        ));

        $breadcrumbs->addCrumb("support ticket", array(
            "label" => $this->__("Supportticket"),
            "title" => $this->__("Supportticket")
        ));

        $this->renderLayout();
    }
    
    
    
     /**
     * Save support ticket data 
     */   
    

    public function saveAction() {
        $post_data = $this->getRequest()->getPost();
        $_helper = Mage::helper('supportticket');

        if ($post_data) {
            try {
                $error = false;

                if (!Zend_Validate::is(trim($post_data['ticket_subject']), 'NotEmpty')) {
                    $error = true;
                }
                if (!Zend_Validate::is(trim($post_data['ticket_message']), 'NotEmpty')) {
                    $error = true;
                }
                $filename = '';
                if (isset($_FILES['attachment']['name']) and (file_exists($_FILES['attachment']['tmp_name']))) {
                    try {
                        $uploader = new Varien_File_Uploader('attachment');
                        $uploader->setAllowedExtensions(array('doc', 'docx', 'pdf', 'jpg', 'jpeg', 'png', 'bmp', 'gif'));
                        $uploader->setAllowRenameFiles(false);
                        $uploader->setFilesDispersion(false);
                        $filename = "File-" . time() . $_FILES['attachment']['name'];
                        $filename = str_replace(' ', '-', $filename);
                        $path = Mage::getBaseDir('media') . DS . 'supportticket' . DS;
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
                $model = Mage::getModel("supportticket/supportticket")
                        ->addData($post_data)
                        ->setUpdateTime($date)
                        ->setCreateTime($date)
                        ->setId($this->getRequest()->getParam("id"));
                if ($_FILES['attachment']['name'] == ''):
                    $model->setTicketAttachment('No Attachment Found');
                else:
                    $model->setTicketAttachment($newFilename);
                endif;
                $model->save();
                $emailTemplate = Mage::getModel('core/email_template')->loadDefault('supportticket_email_email_template');

                $attachmentFilePath = Mage::getBaseDir('media') . DS . 'supportticket' . DS . $filename;

                if ($_FILES['attachment']['name']) {
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
                    if ($key == $post_data['ticket_department']) {
                        $post_data['ticket_department'] = $value;
                    }
                }
                $adminEmail = Mage::getStoreConfig('support_ticket_ultimate/general_email_settings/supervisor_email');
                $adminName = Mage::getStoreConfig('support_ticket_ultimate/general_email_settings/supervisor_name');
                $emailTemplateVariables = array(
                    'userid' => $post_data['user_id'],
                    'ticketid' => $post_data['ticket_id'],
                    'name' => $post_data['user_name'],
                    'email' => $post_data['user_email'],
                    'ticketmsg' => $post_data['ticket_message'],
                    'ticketsub' => $post_data['ticket_subject'],
                    'ticketprio' => $post_data['ticket_priority'],
                    'ticketdept' => $post_data['ticket_department']
                );
                try {
                    $emailTemplate->setSenderName($post_data['user_name']);
                    $emailTemplate->setSenderEmail($post_data['user_email']);
                    $emailTemplate->send($adminEmail, $adminName, $emailTemplateVariables);
                } catch (Exception $e) {
                    echo $e->getMessage();
                }

                Mage::getSingleton("core/session")->addSuccess(Mage::helper("supportticket")->__("Support Ticket was successfully Posted"));
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
     * Close the support ticket
     */   
    
    public function closeTicketAction(){
       $ticket_id  = $this->getRequest()->getParam('id');
       $model = Mage::getModel('supportticket/supportticket')->load($ticket_id);
       $model->setTicketStatus(self::SET_DISABLED)->save();
       $this->_redirect('*/*/',array('id'=>$ticket_id));
    }

}
