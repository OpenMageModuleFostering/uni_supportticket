<?php

class Uni_Supportticket_Block_Adminhtml_Supportticketdepartment_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("supportticket_form", array("legend" => Mage::helper("supportticket")->__("Department Details")));

        $fieldset->addField("title", "text", array(
            "label" => Mage::helper("supportticket")->__("Title"),
            "class" => "required-entry",
            "required" => true,
            "name" => "title",
        ));

        if (Mage::registry("supportticketdepartment_data") && Mage::registry("supportticketdepartment_data")->getIsSystem()>0 ) {
            $fieldset->addField('dep_status', 'select', array(
                'label' => Mage::helper('supportticket')->__('Status'),
                'values' => Uni_Supportticket_Block_Adminhtml_Supportticketdepartment_Grid::getValueArray2(),
                'name' => 'dep_status',
                "class" => "required-entry",
                'disabled' => 'disabled',
                "required" => true,
                'note'=>'System Department cannot be disabled or deleted'
            ));
        } else {
            $fieldset->addField('dep_status', 'select', array(
                'label' => Mage::helper('supportticket')->__('Status'),
                'values' => Uni_Supportticket_Block_Adminhtml_Supportticketdepartment_Grid::getValueArray2(),
                'name' => 'dep_status',
                "class" => "required-entry",
                "required" => true,
            ));
        }


        if (Mage::getSingleton("adminhtml/session")->getSupportticketdepartmentData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getSupportticketdepartmentData());
            Mage::getSingleton("adminhtml/session")->setSupportticketdepartmentData(null);
        } elseif (Mage::registry("supportticketdepartment_data")) {
            $form->setValues(Mage::registry("supportticketdepartment_data")->getData());
        }
        return parent::_prepareForm();
    }

}
