<?php

class Uni_Supportticket_Block_Adminhtml_Supportticketreply extends Mage_Adminhtml_Block_Widget_Grid_Container {

    /**
     * Set custom labels and headers
     *
     */
    public function __construct() {

        $this->_controller = "adminhtml_supportticketreply";
        $this->_blockGroup = "supportticket";
        $this->_headerText = Mage::helper("supportticket")->__("Supportticket Reply Manager");
        $this->_addButtonLabel = Mage::helper("supportticket")->__("Add New Item");
        parent::__construct();
        $this->_removeButton('add');
    }

}
