<?php

class Uni_Supportticket_Block_Adminhtml_Supportticketpriority extends Mage_Adminhtml_Block_Widget_Grid_Container {

    /**
     * Set custom labels and headers
     *
     */
    public function __construct() {

        $this->_controller = "adminhtml_supportticketpriority";
        $this->_blockGroup = "supportticket";
        $this->_headerText = Mage::helper("supportticket")->__("Support Ticket Priority Manager");
        $this->_addButtonLabel = Mage::helper("supportticket")->__("Add New Priority");
        parent::__construct();
    }

}
