<?php

class Uni_Supportticket_Block_Adminhtml_Report_Supportticket extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_controller = 'adminhtml_report_supportticket';
		$this->_blockGroup = "supportticket";
        $this->_headerText = Mage::helper('supportticket')->__('Supportticket Report');
        parent::__construct();
        $this->_removeButton('add');
    }
}