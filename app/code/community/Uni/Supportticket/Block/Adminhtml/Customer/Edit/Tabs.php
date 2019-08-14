<?php

class Uni_Supportticket_Block_Adminhtml_Customer_Edit_Tabs extends Mage_Adminhtml_Block_Customer_Edit_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId('customer_info_tabs');
        $this->setDestElementId('edit_form');
        $this->setTitle(Mage::helper('customer')->__('Customer Information'));
    }

    protected function _beforeToHtml() {
    
        $this->addTab('supportticket', array(
            'label' => Mage::helper('supportticket')->__('Customer Support Ticket'),
            'content' => $this->getLayout()->createBlock('supportticket/adminhtml_supportticket_customergrid')->initForm()->toHtml(),
            'active' => Mage::registry('supportticket_data')
        ));

        $this->_updateActiveTab();
        Varien_Profiler::stop('customer/tabs');
        return parent::_beforeToHtml();
    }

}
