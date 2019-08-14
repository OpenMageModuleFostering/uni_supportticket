<?php

class Uni_Supportticket_Block_Adminhtml_Supportticket_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {

        parent::__construct();
        $this->_objectId = "entity_id";
        $this->_blockGroup = "supportticket";
        $this->_controller = "adminhtml_supportticket";
        $this->_updateButton("save", "label", Mage::helper("supportticket")->__("Save"));
        $this->_updateButton("delete", "label", Mage::helper("supportticket")->__("Delete"));

    }

    public function getHeaderText() {
        if (Mage::registry("supportticket_data") && Mage::registry("supportticket_data")->getId()) {

            return Mage::helper("supportticket")->__("Edit Ticket ID : '%s'", $this->htmlEscape(Mage::registry("supportticket_data")->getTicketId()));
        } else {

            return Mage::helper("supportticket")->__("New Support Ticket");
        }
    }

}
