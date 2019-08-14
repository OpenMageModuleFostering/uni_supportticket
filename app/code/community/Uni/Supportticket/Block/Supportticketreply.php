<?php

class Uni_Supportticket_Block_Supportticketreply extends Mage_Core_Block_Template {

    /*
     * 
     */
    public function __construct() {
        parent::__construct();
        $datasets = Mage::getModel('supportticket/supportticketreply')->getCollection();
        $this->setDatasets($datasets);
    }

    /*
     * 
     */
    protected function _prepareLayout() {
        parent::_prepareLayout();
        $customerData = Mage::getSingleton('customer/session')->getCustomer();
        $tick = $this->getCurrentTicketId($this->getRequest()->getParam('id'));
        $pager = $this->getLayout()->createBlock('page/html_pager')->setCollection($this->getDatasets()->addFieldToFilter('ticket_id', $tick));
        $this->setChild('pager', $pager);
        $this->getDatasets()->load();
        return $this;
    }

    /*
     * 
     */
    public function getPagerHtml() {
        return $this->getChildHtml('pager');
    }

    /*
     * take params $id return current ticket id on reply page frontend
     */
    public function getCurrentTicketId($id) {
        $model = mage::getModel('supportticket/supportticket')->load($id);
        return $model->getTicketId();
    }

}
