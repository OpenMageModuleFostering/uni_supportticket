<?php

class Uni_Supportticket_Block_Adminhtml_Supportticketreplywithticketid extends Mage_Adminhtml_Block_Widget_Grid_Container {

    /**
     * Set custom labels and headers
     *
     */
    public function __construct() {

        $this->_controller = "adminhtml_supportticketreplywithticketid";
        $this->_blockGroup = "supportticket";
        $this->_headerText = Mage::helper("supportticket")->__("Supportticket Reply Manager");
        parent::__construct();
        $this->_removeButton('add');
    }

}
