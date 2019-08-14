<?php

class Uni_Supportticket_Block_Adminhtml_Supportticketdepartment extends Mage_Adminhtml_Block_Widget_Grid_Container {

    /**
     * Set custom labels and headers
     *
     */
    public function __construct() {

        $this->_controller = "adminhtml_supportticketdepartment";
        $this->_blockGroup = "supportticket";
        $this->_headerText = Mage::helper("supportticket")->__("Departments Manager");
        $this->_addButtonLabel = Mage::helper("supportticket")->__("Add Department");
        parent::__construct();
    }

}
