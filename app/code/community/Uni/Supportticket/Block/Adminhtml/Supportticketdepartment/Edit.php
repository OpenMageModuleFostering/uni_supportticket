<?php

class Uni_Supportticket_Block_Adminhtml_Supportticketdepartment_Edit extends Mage_Adminhtml_Block_Widget_Form_Container {

    public function __construct() {

        parent::__construct();
        $this->_objectId = "entity_id";
        $this->_blockGroup = "supportticket";
        $this->_controller = "adminhtml_supportticketdepartment";
        if(Mage::registry("supportticketdepartment_data") && Mage::registry("supportticketdepartment_data")->getIsSystem()>0)
        {
        $this->_updateButton("delete", "disabled", Mage::helper("supportticket")->__("disabled"));
        }
        $this->_updateButton("save", "label", Mage::helper("supportticket")->__("Save Item"));
        $this->_updateButton("delete", "label", Mage::helper("supportticket")->__("Delete"));

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
        if (Mage::registry("supportticketdepartment_data") && Mage::registry("supportticketdepartment_data")->getId()) {

            return Mage::helper("supportticket")->__("Edit Item '%s'", $this->htmlEscape(Mage::registry("supportticketdepartment_data")->getTitle()));
        } else {

            return Mage::helper("supportticket")->__("Add Department");
        }
    }

}
