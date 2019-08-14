<?php

class Uni_Supportticket_Block_Adminhtml_Supportticketreply_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {

        parent::__construct();
        $this->_objectId = "entity_id";
        $this->_blockGroup = "supportticket";
        $this->_controller = "adminhtml_supportticketreply";
        $this->_updateButton("save", "label", Mage::helper("supportticket")->__("Save Item"));
        $this->_updateButton("delete", "label", Mage::helper("supportticket")->__("Delete Item"));

        $this->_addButton("saveandcontinue", array(
            "label" => Mage::helper("supportticket")->__("Save And Continue Edit"),
            "onclick" => "saveAndContinueEdit()",
            "class" => "save",
                ), -100);



        $this->_formScripts[] = "

							function saveAndContinueEdit(){
								editForm.submit($('edit_form').action+'back/edit/');
							}
						";
    }

    public function getHeaderText() {
        if (Mage::registry("supportticketreply_data") && Mage::registry("supportticketreply_data")->getId()) {

            return Mage::helper("supportticket")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("supportticketreply_data")->getId()));
        } else {

            return Mage::helper("supportticket")->__("Add Item");
        }
    }

}
