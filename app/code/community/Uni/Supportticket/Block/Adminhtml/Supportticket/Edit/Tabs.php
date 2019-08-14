<?php

class Uni_Supportticket_Block_Adminhtml_Supportticket_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs {

    public function __construct() {
        parent::__construct();
        $this->setId("supportticket_tabs");
        $this->setDestElementId("edit_form");
        $this->setTitle(Mage::helper("supportticket")->__("Support Ticket"));
    }

    protected function _beforeToHtml() {
        $this->addTab("form_section", array(
            "label" => Mage::helper("supportticket")->__("Support Ticket Information"),
            "title" => Mage::helper("supportticket")->__("Support Ticket Information"),
            "content" => $this->getLayout()->createBlock("supportticket/adminhtml_supportticket_edit_tab_form")->toHtml(),
        ));
        $this->addTab("form_section1", array(
            "label" => Mage::helper("supportticket")->__("View Threads"),
            "title" => Mage::helper("supportticket")->__("View Threads"),
            "content" => $this->getLayout()->createBlock("supportticket/adminhtml_supportticketreplywithticketid")->toHtml(),
        ));
        return parent::_beforeToHtml();
    }

}
