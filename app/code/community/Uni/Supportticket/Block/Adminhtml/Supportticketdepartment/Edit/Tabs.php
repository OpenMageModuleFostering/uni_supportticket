<?php
class Uni_Supportticket_Block_Adminhtml_Supportticketdepartment_Edit_Tabs extends Mage_Adminhtml_Block_Widget_Tabs
{
		public function __construct()
		{
				parent::__construct();
				$this->setId("supportticketdepartment_tabs");
				$this->setDestElementId("edit_form");
				$this->setTitle(Mage::helper("supportticket")->__("Department"));
		}
		protected function _beforeToHtml()
		{
				$this->addTab("form_section", array(
				"label" => Mage::helper("supportticket")->__("Department information"),
				"title" => Mage::helper("supportticket")->__("Item Information"),
				"content" => $this->getLayout()->createBlock("supportticket/adminhtml_supportticketdepartment_edit_tab_form")->toHtml(),
				));
				return parent::_beforeToHtml();
		}

}
