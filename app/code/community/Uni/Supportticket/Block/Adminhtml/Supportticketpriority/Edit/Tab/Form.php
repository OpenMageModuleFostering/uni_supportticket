<?php

class Uni_Supportticket_Block_Adminhtml_Supportticketpriority_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("supportticket_form", array("legend" => Mage::helper("supportticket")->__("General information")));

        $fieldset->addField("title", "text", array(
            "label" => Mage::helper("supportticket")->__("Title"),
            "class" => "required-entry",
            "required" => true,
            "name" => "title",
        ));

        $fieldset->addField("font_color", "text", array(
            "label" => Mage::helper("supportticket")->__("Font Color"),
            "class" => "required-entry",
            "required" => true,
            "name" => "font_color",
        ));

        $fieldset->addField("background_color", "text", array(
            "label" => Mage::helper("supportticket")->__("Background Color"),
//            "class" => "required-entry",
//            "required" => true,
            "name" => "background_color",
        ));

       if (Mage::registry("supportticketpriority_data") && Mage::registry("supportticketpriority_data")->getIsSystem()>0 ) {
        $fieldset->addField('ticket_priority', 'select', array(
            'label' => Mage::helper('supportticket')->__('Status'),
            'values' => Uni_Supportticket_Block_Adminhtml_Supportticketpriority_Grid::getValueArray28(),
            'name' => 'ticket_priority',
            "class" => "required-entry",
            'disabled' => 'disabled',
            "required" => true,
            'note'=>'System Priority cannot be disabled or deleted'
        ));}
        else{
           $fieldset->addField('ticket_priority', 'select', array(
            'label' => Mage::helper('supportticket')->__('Status'),
            'values' => Uni_Supportticket_Block_Adminhtml_Supportticketpriority_Grid::getValueArray28(),
            'name' => 'ticket_priority',
            "class" => "required-entry",
            "required" => true,
        )); 
        }

        if (Mage::getSingleton("adminhtml/session")->getSupportticketpriorityData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getSupportticketpriorityData());
            Mage::getSingleton("adminhtml/session")->setSupportticketpriorityData(null);
        } elseif (Mage::registry("supportticketpriority_data")) {
            $form->setValues(Mage::registry("supportticketpriority_data")->getData());
        }
        return parent::_prepareForm();
    }

}
