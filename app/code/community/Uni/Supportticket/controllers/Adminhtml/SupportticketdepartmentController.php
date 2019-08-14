<?php

class Uni_Supportticket_Adminhtml_SupportticketdepartmentController extends Mage_Adminhtml_Controller_Action {

   /**
     * Set active menu and Breadcrumb
     * @return \Uni_Supportticket_Adminhtml_SupportticketdepartmentController
     */
    
    protected function _initAction() {
        $this->loadLayout()->_setActiveMenu("supportticket/supportticketdepartment")->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticketdepartment  Manager"), Mage::helper("adminhtml")->__("Supportticketdepartment Manager"));
        return $this;
    }

    /**
     * Display grid for generated ticket departments
     */
    
    public function indexAction() {
        $this->_title($this->__("Support Ticket - Department"));
        $this->_initAction();
        $this->renderLayout();
    }

    /**
     * Rendering layout for ticket department edit action
     */
    
    public function editAction() {
        $this->_title($this->__("Supportticket"));
        $this->_title($this->__("Supportticket department"));
        $this->_title($this->__("Edit Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("supportticket/supportticketdepartment")->load($id);
        if ($model->getId()) {
            Mage::register("supportticketdepartment_data", $model);
            $this->loadLayout();
            $this->_setActiveMenu("supportticket/supportticketdepartment");
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticketdepartment Manager"), Mage::helper("adminhtml")->__("Supportticketdepartment Manager"));
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticketdepartment Description"), Mage::helper("adminhtml")->__("Supportticketdepartment Description"));
            $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock("supportticket/adminhtml_supportticketdepartment_edit"))->_addLeft($this->getLayout()->createBlock("supportticket/adminhtml_supportticketdepartment_edit_tabs"));
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
        $this->_title($this->__("Supportticket Department"));
        $this->_title($this->__("New Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("supportticket/supportticketdepartment")->load($id);

        $data = Mage::getSingleton("adminhtml/session")->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register("supportticketdepartment_data", $model);

        $this->loadLayout();
        $this->_setActiveMenu("supportticket/supportticketdepartment");

        $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticketdepartment Manager"), Mage::helper("adminhtml")->__("Supportticketdepartment Manager"));
        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticketdepartment Description"), Mage::helper("adminhtml")->__("Supportticketdepartment Description"));


        $this->_addContent($this->getLayout()->createBlock("supportticket/adminhtml_supportticketdepartment_edit"))->_addLeft($this->getLayout()->createBlock("supportticket/adminhtml_supportticketdepartment_edit_tabs"));

        $this->renderLayout();
    }

    
     /**
     * Save new ticket departments
     */
    
    public function saveAction() {

        $post_data = $this->getRequest()->getPost();


        if ($post_data) {

            try {



                $model = Mage::getModel("supportticket/supportticketdepartment")
                        ->addData($post_data)
                        ->setId($this->getRequest()->getParam("id"))
                        ->save();

                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Department was successfully saved"));
                Mage::getSingleton("adminhtml/session")->setSupportticketdepartmentData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirect("*/*/");
                return;
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                Mage::getSingleton("adminhtml/session")->setSupportticketdepartmentData($this->getRequest()->getPost());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
                return;
            }
        }
        $this->_redirect("*/*/");
    }

    
     /**
     * Delete ticket departments
     */
    
    
    public function deleteAction() {
        if ($this->getRequest()->getParam("id") > 0) {
            try {
                $model = Mage::getModel("supportticket/supportticketdepartment");
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
     * Change the status to enable or disable
     */
    
    

    public function massStatusAction() {
        $_count1 = 0;
        $_count2 = 0;
        $_params = $this->getRequest()->getParam('entity_ids', array());
        if (!is_array($_params)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please Choose an Item to Change Status'));
        } else {
            try {
                $_stMdoel = Mage::getSingleton('supportticket/supportticketdepartment');
                foreach ($_params as $ids) {
                    $_stMdoel->load($ids);
                    if ($_stMdoel['is_system'] == 1) {
                        $_count1++;
                    } else {
                        $_stMdoel->load($ids)
                                ->setDepStatus($this->getRequest()->getParam('status'))
                                ->save();
                        $_count2++;
                    }
                }
                if ($_count1 > 0) {
                    Mage::getSingleton('adminhtml/session')->addError($this->__("Total " . $_count1 . " records have not been updated. The system statuses can’t be disabled"));
                    if ($_count2 > 0) {
                        $this->_getSession()->addSuccess(
                                $this->__('Total ' . $_count2 . ' records successfully updated')
                        );
                    }
                } elseif ($_count2 > 0) {
                    $this->_getSession()->addSuccess(
                            $this->__('Total ' . $_count2 . ' records successfully updated')
                    );
                } else {
                    $this->_getSession()->addSuccess(
                            $this->__('Total ' . $_count1 + $_count2 . ' records successfully updated')
                    );
                }
            } catch (Exception $ex) {
                $this->_getSession()->addError($ex->getMessage());
            }
        }
        $this->_redirect('*/*/index');
    }

    /**
     * Export order grid to CSV format
     */
    public function exportCsvAction() {
        $fileName = 'supportticketdepartment.csv';
        $grid = $this->getLayout()->createBlock('supportticket/adminhtml_supportticketdepartment_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction() {
        $fileName = 'supportticketdepartment.xml';
        $grid = $this->getLayout()->createBlock('supportticket/adminhtml_supportticketdepartment_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

}
