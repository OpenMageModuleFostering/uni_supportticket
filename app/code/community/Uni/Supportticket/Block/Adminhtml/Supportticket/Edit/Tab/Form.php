<?php

class Uni_Supportticket_Block_Adminhtml_Supportticket_Edit_Tab_Form extends Mage_Adminhtml_Block_Widget_Form {

    protected function _prepareForm() {

        $form = new Varien_Data_Form();
        $this->setForm($form);
        $fieldset = $form->addFieldset("supportticket_form", array("legend" => Mage::helper("supportticket")->__("Ticket Details")));

        $fieldset->addField("is_admin", "hidden", array(
            "label" => Mage::helper("supportticket")->__("Is Admin"),
            "name" => 'is_admin1'
        ));
        if ($this->getRequest()->getActionName() == 'new') {
            $fieldset->addField("user_name", "text", array(
                "label" => Mage::helper("supportticket")->__("Customer Name"),
                "class" => "required-entry",
                "required" => true,
                "name" => "user_name",
            ));
        } else {
            $fieldset->addField("user_name", "text", array(
                "label" => Mage::helper("supportticket")->__("Customer Name"),
                "class" => "required-entry",
                "required" => true,
                "name" => "user_name",
                'readonly' => TRUE,
            ));
        }
        $fieldset->addField("ticket_id", "hidden", array(
            "label" => Mage::helper("supportticket")->__("Ticket ID"),
            "name" => "ticket_id",
        ));
        if ($this->getRequest()->getActionName() == 'new') {
            $fieldset->addField("user_email", "text", array(
                "label" => Mage::helper("supportticket")->__("Customer Email"),
                "class" => "required-entry validate-email",
                "required" => true,
                "name" => "user_email",
            ));
        } else {
            $fieldset->addField("user_email", "text", array(
                "label" => Mage::helper("supportticket")->__("Customer Email"),
                "class" => "required-entry validate-email",
                "required" => true,
                "name" => "user_email",
                'readonly' => TRUE,
            ));
        }

        $fieldset->addField('department', 'select', array(
            'label' => Mage::helper('supportticket')->__('Department'),
            'values' => Uni_Supportticket_Block_Adminhtml_Supportticket_Grid::getValueArray3(),
            'name' => 'department',
            "class" => "required-entry",
            "required" => true,
            'readonly' => TRUE,
        ));
        $fieldset->addField('ticket_priority', 'select', array(
            'label' => Mage::helper('supportticket')->__('Ticket Priority'),
            'values' => Uni_Supportticket_Block_Adminhtml_Supportticket_Grid::getValueArray4(),
            'name' => 'ticket_priority',
            "class" => "required-entry",
            "required" => true,
        ));
        $fieldset->addField("ticket_subject", "text", array(
            "label" => Mage::helper("supportticket")->__("Ticket Subject"),
            "class" => "required-entry",
            "required" => true,
            "name" => "ticket_subject",
        ));

        $fieldset->addField("ticket_message", "textarea", array(
            "label" => Mage::helper("supportticket")->__("Ticket Message"),
            "class" => "required-entry",
            "required" => true,
            "name" => "ticket_message",
        ));

        if ($this->getRequest()->getActionName() == 'new') {
            $fieldset->addField("create_ticket_attachment", "file", array(
                "label" => Mage::helper("supportticket")->__("Ticket Attachment"),
                "name" => "create_ticket_attachment",
                "note" => "maximum file upload size is 10MB",
            ));
        } else {

            $fieldset->addField("ticket_attachment", "file", array(
                "label" => Mage::helper("supportticket")->__("Ticket Attachment"),
                "name" => "ticket_attachment",
                "note" => "maximum file upload size is 10MB",
            ));
        }

        $fieldset->addField("reply_count", "hidden", array(
            "label" => Mage::helper("supportticket")->__("Reply Count"),
            "name" => "reply_count",
        ));

        $fieldset->addField('ticket_status', 'select', array(
            'label' => Mage::helper('supportticket')->__('Ticket Status'),
            'values' => Uni_Supportticket_Block_Adminhtml_Supportticket_Grid::getValueArray11(),
            'name' => 'ticket_status',
            "class" => "required-entry",
            "required" => true,
        ));

        if ($this->getRequest()->getActionName() !== 'new') {
            $fieldset->addField("ticket_replies", "textarea", array(
                "label" => Mage::helper("supportticket")->__("Replies"),
                "name" => "ticket_repliess",
                "class" => "required-entry",
                "required" => true,
            ));
        }

        if ($this->getParamValues()) {
            $form->setValues($this->getParamValues());
        } elseif (Mage::getSingleton("adminhtml/session")->getSupportticketData()) {
            $form->setValues(Mage::getSingleton("adminhtml/session")->getSupportticketData());

            Mage::getSingleton("adminhtml/session")->setSupportticketData(null);
        } elseif (Mage::registry("supportticket_data")) {
            $data = Mage::registry("supportticket_data")->getData();
            $data['is_admin'] = 1;
            $form->setValues($data);
        }
        return parent::_prepareForm();
    }

    public function getParamValues() {
        $data = array();
        $data['user_email'] = $this->getRequest()->getParam('email');
        $data['user_name'] = $this->getRequest()->getParam('name');
        if (isset($data['user_email']) && $data['user_email'] && isset($data['user_name']) && $data['user_name']) {
            return $data;
        } else {
            return NULL;
        }
    }

}
