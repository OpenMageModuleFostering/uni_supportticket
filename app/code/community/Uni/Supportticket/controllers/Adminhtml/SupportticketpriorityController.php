<?php

class Uni_Supportticket_Adminhtml_SupportticketpriorityController extends Mage_Adminhtml_Controller_Action {

     /**
     * Set active menu and Breadcrumb
     * @return \Uni_Supportticket_Adminhtml_SupportticketpriorityController
     */
    
    
    protected function _initAction() {
        $this->loadLayout()->_setActiveMenu("supportticket/supportticketpriority")->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticketpriority  Manager"), Mage::helper("adminhtml")->__("Supportticketpriority Manager"));
        return $this;
    }

    
     /**
     * Display grid for generated ticket priorities
     */
    
    public function indexAction() {
        $this->_title($this->__("Supportticket"));
        $this->_title($this->__("Manager Supportticketpriority"));

        $this->_initAction();
        $this->renderLayout();
    }

     /**
     * Rendering layout for ticket edit action
     */
    
    public function editAction() {
        $this->_title($this->__("Supportticket"));
        $this->_title($this->__("Supportticketpriority"));
        $this->_title($this->__("Edit Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("supportticket/supportticketpriority")->load($id);
        if ($model->getId()) {
            Mage::register("supportticketpriority_data", $model);
            $this->loadLayout();
            $this->_setActiveMenu("supportticket/supportticketpriority");
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticketpriority Manager"), Mage::helper("adminhtml")->__("Supportticketpriority Manager"));
            $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticketpriority Description"), Mage::helper("adminhtml")->__("Supportticketpriority Description"));
            $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);
            $this->_addContent($this->getLayout()->createBlock("supportticket/adminhtml_supportticketpriority_edit"))->_addLeft($this->getLayout()->createBlock("supportticket/adminhtml_supportticketpriority_edit_tabs"));
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
        $this->_title($this->__("Supportticketpriority"));
        $this->_title($this->__("New Item"));

        $id = $this->getRequest()->getParam("id");
        $model = Mage::getModel("supportticket/supportticketpriority")->load($id);

        $data = Mage::getSingleton("adminhtml/session")->getFormData(true);
        if (!empty($data)) {
            $model->setData($data);
        }

        Mage::register("supportticketpriority_data", $model);

        $this->loadLayout();
        $this->_setActiveMenu("supportticket/supportticketpriority");

        $this->getLayout()->getBlock("head")->setCanLoadExtJs(true);

        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticketpriority Manager"), Mage::helper("adminhtml")->__("Supportticketpriority Manager"));
        $this->_addBreadcrumb(Mage::helper("adminhtml")->__("Supportticketpriority Description"), Mage::helper("adminhtml")->__("Supportticketpriority Description"));


        $this->_addContent($this->getLayout()->createBlock("supportticket/adminhtml_supportticketpriority_edit"))->_addLeft($this->getLayout()->createBlock("supportticket/adminhtml_supportticketpriority_edit_tabs"));

        $this->renderLayout();
    }

    
    /**
     * Save new ticket priority
     */
    public function saveAction() {

        $post_data = $this->getRequest()->getPost();


        if ($post_data) {

            try {



                $model = Mage::getModel("supportticket/supportticketpriority")
                        ->addData($post_data)
                        ->setId($this->getRequest()->getParam("id"))
                        ->save();

                Mage::getSingleton("adminhtml/session")->addSuccess(Mage::helper("adminhtml")->__("Supportticketpriority was successfully saved"));
                Mage::getSingleton("adminhtml/session")->setSupportticketpriorityData(false);

                if ($this->getRequest()->getParam("back")) {
                    $this->_redirect("*/*/edit", array("id" => $model->getId()));
                    return;
                }
                $this->_redirect("*/*/");
                return;
            } catch (Exception $e) {
                Mage::getSingleton("adminhtml/session")->addError($e->getMessage());
                Mage::getSingleton("adminhtml/session")->setSupportticketpriorityData($this->getRequest()->getPost());
                $this->_redirect("*/*/edit", array("id" => $this->getRequest()->getParam("id")));
                return;
            }
        }
        $this->_redirect("*/*/");
    }

    
    /**
     * Delete ticket priority
     */
    
    public function deleteAction() {
        if ($this->getRequest()->getParam("id") > 0) {
            try {
                $model = Mage::getModel("supportticket/supportticketpriority");
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
     *  Change status of ticket priority
     */
    
    
    public function massStatusAction() {
        $_count1 = 0;
        $_count2 = 0;
        $_params = $this->getRequest()->getParam('entity_ids', array());
        if (!is_array($_params)) {
            Mage::getSingleton('adminhtml/session')->addError($this->__('Please Choose an Item to Change Status'));
        } else {
            try {
                $_stMdoel = Mage::getSingleton('supportticket/supportticketpriority');
                foreach ($_params as $ids) {
                    $_stMdoel->load($ids);
                    if ($_stMdoel['is_system'] == 1) {
                        $_count1++;
                    } else {
                        $_stMdoel->load($ids)
                                ->setTicketPriority($this->getRequest()->getParam('status'))
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
        $fileName = 'supportticketpriority.csv';
        $grid = $this->getLayout()->createBlock('supportticket/adminhtml_supportticketpriority_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getCsvFile());
    }

    /**
     *  Export order grid to Excel XML format
     */
    public function exportExcelAction() {
        $fileName = 'supportticketpriority.xml';
        $grid = $this->getLayout()->createBlock('supportticket/adminhtml_supportticketpriority_grid');
        $this->_prepareDownloadResponse($fileName, $grid->getExcelFile($fileName));
    }

}
