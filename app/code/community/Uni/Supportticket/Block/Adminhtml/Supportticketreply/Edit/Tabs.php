<?php
class Uni_Supportticket_Block_Adminhtml_Supportticketreply_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("supportticketreply_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("supportticket")->__("Item Information"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("supportticket")->__("Item Information"),
				"title" => Mage::helper("supportticket")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("supportticket/adminhtml_supportticketreply_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
