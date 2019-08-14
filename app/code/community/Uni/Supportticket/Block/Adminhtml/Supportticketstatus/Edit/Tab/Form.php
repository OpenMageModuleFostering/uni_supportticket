<?php

class Uni_Supportticket_Block_Adminhtml_Supportticketstatus_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

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

        if (Mage::registry("supportticketstatus_data") && Mage::registry("supportticketstatus_data")->getIsSystem()>0 ){
            $fieldset->addField('ticket_status', 'select', array(
                'label' => Mage::helper('supportticket')->__('Ticket Status'),
                'values' => Uni_Supportticket_Block_Adminhtml_Supportticketstatus_Grid::getValueArray23(),
                'name' => 'ticket_status',
                "class" => "required-entry",
                'disabled' => 'disabled',
                "required" => true,
            ));
        } else {
            $fieldset->addField('ticket_status', 'select', array(
                'label' => Mage::helper('supportticket')->__('Ticket Status'),
                'values' => Uni_Supportticket_Block_Adminhtml_Supportticketstatus_Grid::getValueArray23(),
                'name' => 'ticket_status',
                "class" => "required-entry",
                "required" => true,
                'note'=>'System Status cannot be disabled or deleted'
            ));
        }

        if (Mage::getSingleton("adminhtml/session")->getSupportticketstatusData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getSupportticketstatusData());
            Mage::getSingleton("adminhtml/session")->setSupportticketstatusData(null);
        } elseif (Mage::registry("supportticketstatus_data")) {
            $form->setValues(Mage::registry("supportticketstatus_data")->getData());
        }
        return parent::_prepareForm();
    }

}
