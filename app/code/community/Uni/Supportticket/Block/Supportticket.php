<?php

class Uni_Supportticket_Block_Supportticket extends Mage_Core_Block_Template {
    /*
     * 
     */

    public function __construct() {
        parent::__construct();
        $datasets = Mage::getModel('supportticket/supportticket')->getCollection();
        $this->setDatasets($datasets);
    }

    /*
     * 
     */

    protected function _prepareLayout() {
        parent::_prepareLayout();
        $customerData = Mage::getSingleton('customer/session')->getCustomer();
        $pager = $this->getLayout()->createBlock('page/html_pager')->setCollection($this->getDatasets()->addFieldToFilter('user_id', $customerData->getId()));
        $this->setChild('pager', $pager);
        $this->getDatasets()->load();
        return $this;
    }

    public function getPagerHtml() {
        return $this->getChildHtml('pager');
    }

    /*
     * get form action
     */

    public function getFormAction() {
        return $this->geturl('supportticket/supportticketreply/save');
    }

    /*
     * get ticket information by id
     */

    public function getTicketInfo($id) {
        return Mage::getModel('supportticket/supportticket')->load($id);
    }

}
