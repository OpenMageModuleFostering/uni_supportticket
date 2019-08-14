<?php

class Uni_Supportticket_Block_Adminhtml_Supportticketreply_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("supportticket_form", array("legend" => Mage::helper("supportticket")->__("Item information")));

        $fieldset->addField("ticket_id", "text", array(
            "label" => Mage::helper("supportticket")->__("Ticket Id"),
            "name" => "ticket_id",
        ));

        $fieldset->addField("user_name", "text", array(
            "label" => Mage::helper("supportticket")->__("User Name"),
            "name" => "user_name",
        ));

        $fieldset->addField("ticket_attachment", "text", array(
            "label" => Mage::helper("supportticket")->__("Ticket Attachment"),
            "name" => "ticket_attachment",
        ));

        $fieldset->addField("ticket_replies", "text", array(
            "label" => Mage::helper("supportticket")->__("Ticket Replies"),
            "name" => "ticket_replies",
        ));


        if (Mage::getSingleton("adminhtml/session")->getSupportticketreplyData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getSupportticketreplyData());
            Mage::getSingleton("adminhtml/session")->setSupportticketreplyData(null);
        } elseif (Mage::registry("supportticketreply_data")) {
            $form->setValues(Mage::registry("supportticketreply_data")->getData());
        }
        return parent::_prepareForm();
    }

}
