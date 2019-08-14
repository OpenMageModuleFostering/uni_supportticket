<?php
class Uni_Supportticket_Block_Adminhtml_Supportticketpriority_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("supportticketpriority_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("supportticket")->__("New Ticket Priority Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("supportticket")->__("Priority Information"),
				"title" => Mage::helper("supportticket")->__("Priority Information"),
				"content" => $this->getLayout()->createBlock("supportticket/adminhtml_supportticketpriority_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
