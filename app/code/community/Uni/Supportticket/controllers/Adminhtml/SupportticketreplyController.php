<?php

class Uni_Supportticket_Adminhtml_SupportticketreplyController extends Mage_Adminhtml_Controller_Action {
/**
     * Set active menu and Breadcrumb
     * @return \Uni_Supportticket_Adminhtml_SupportticketreplyController
     */
    protected function _initAction() {
        $this->loadLayout()->_setActiveMenu("supportticket/supportticketreply")->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticketreply  Manager"), Mage::helper("adminhtml")->__("Supportticketreply Manager"));
        return $this;
    }

    
    /**
     * Display grid for generated ticket reply
     */
    public function indexAction() {
        $this->_title($this->__("Supportticket"));
        $this->_title($this->__("Manager Supportticketreply"));

        $this->_initAction();
        $this->renderLayout();
    }
    
    
     /**
     * Rendering layout for ticket edit action
     */

    public function editAction() {
        $this->_title($this->__("Supportticket"));
        $this->_title($this->__("Supportticketreply"));
        $this->_title($this->__("Edit Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("supportticket/supportticketreply")->load($id);
        if ($model->getId()) {
            Mage::register("supportticketreply_data", $model);
            $this->loadLayout();
            $this->_setActiveMenu("supportticket/supportticketreply");
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticketreply Manager"), Mage::helper("adminhtml")->__("Supportticketreply Manager"));
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticketreply Description"), Mage::helper("adminhtml")->__("Supportticketreply Description"));
            $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock("supportticket/adminhtml_supportticketreply_edit"))->_addLeft($this->getLayout()->createBlock("supportticket/adminhtml_supportticketreply_edit_tabs"));
//					$this->_addContent($this->getLayout()->createBlock("supportticket/adminhtml_supportticketreply_edit"));
            $this->renderLayout();
        } else {
            Mage::getSingleton("adminhtml/session")->addError(Mage::helper("supportticket")->__("Item does not exist."));
            $this->_redirect("*/*/");
        }
    }
    
     /**
     * Renders layout for new ticket priority
     */

    public function newAction() {

        $this->_title($this->__("Supportticket"));
        $this->_title($this->__("Supportticketreply"));
        $this->_title($this->__("New Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("supportticket/supportticketreply")->load($id);

        $data = Mage::getSingleton("adminhtml/session")->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register("supportticketreply_data", $model);

        $this->loadLayout();
        $this->_setActiveMenu("supportticket/supportticketreply");

        $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticketreply Manager"), Mage::helper("adminhtml")->__("Supportticketreply Manager"));
        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticketreply Description"), Mage::helper("adminhtml")->__("Supportticketreply Description"));


        $this->_addContent($this->getLayout()->createBlock("supportticket/adminhtml_supportticketreply_edit"));
//		$this->_addContent($this->getLayout()->createBlock("supportticket/adminhtml_supportticketreply_edit"))->_addLeft($this->getLayout()->createBlock("supportticket/adminhtml_supportticketreply_edit_tabs"));

        $this->renderLayout()   ;
    }

    /**
     * Save new ticket priority
     */
    
    public function saveAction() {

        $post_data = $this->getRequest()->getPost();
        
//        Zend_Debug::dump($post_data);exit;
        
        if ($post_data) {

            try {


                $model = Mage::getModel("supportticket/supportticketreply")
                        ->addData($post_data)
                        ->setId($this->getRequest()->getParam("id"))
                        ->save();

                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Supportticketreply was successfully saved"));
                Mage::getSingleton("adminhtml/session")->setSupportticketreplyData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirect("*/*/");
                return;
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                Mage::getSingleton("adminhtml/session")->setSupportticketreplyData($this->getRequest()->getPost());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
                return;
            }
        }
        $this->_redirect("*/*/");
    }

    
     /**
     * delete the ticket priority
     */
    
    public function deleteAction() {
        if ($this->getRequest()->getParam("id") > 0) {
            try {
                $model = Mage::getModel("supportticket/supportticketreply");
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
     * Export order grid to CSV format
     */
    public function exportCsvAction() {
        $fileName = 'supportticketreply.csv';
        $grid = $this->getLayout()->createBlock('supportticket/adminhtml_supportticketreply_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction() {
        $fileName = 'supportticketreply.xml';
        $grid = $this->getLayout()->createBlock('supportticket/adminhtml_supportticketreply_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

}
