<?php
class Uni_Supportticket_Block_Adminhtml_Supportticketreply_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
		protected function _prepareForm()
		{
				$form = new Varien_Data_Form(array(
				"id" => "edit_form",
				"action" => $this->getUrl("*/*/save", array("id" => $this->getRequest()->getParam("id"))),
				"method" => "post",
				"enctype" =>"multipart/form-data",
				)
				);
				$form->setUseContainer(true);
				$this->setForm($form);
				return parent::_prepareForm();
		}
}
//{
//    protected function _prepareForm()
//    {
//        $supportticketForm = new Varien_Data_Form(array(
//            'id' => 'edit_form',
//            'action' => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
//            'method' => 'post',
//        ));
//        $supportticketForm->setUseContainer(true);
//        $this->setForm($supportticketForm);
//
//        $fieldset = $supportticketForm->addFieldset('supportticket_form', array(
//            'legend'      => Mage::helper('supportticket')->__('Item Information'),
//            'class'       => 'fieldset-wide',
//            )
//        );
//
//        $fieldset->addField("ticket_id", "text", array(
//            "label" => Mage::helper("supportticket")->__("Ticket Id"),
//            "name" => "ticket_id",
//        ));
//
//        $fieldset->addField("user_name", "text", array(
//            "label" => Mage::helper("supportticket")->__("User Name"),
//            "name" => "user_name",
//        ));
//
//        $fieldset->addField("ticket_attachment", "text", array(
//            "label" => Mage::helper("supportticket")->__("Ticket Attachment"),
//            "name" => "ticket_attachment",
//        ));
//
//        $fieldset->addField("ticket_replies", "text", array(
//            "label" => Mage::helper("supportticket")->__("Ticket Replies"),
//            "name" => "ticket_replies",
//        ));
//
//
//        if ( Mage::getSingleton('adminhtml/session')->getSupportticketData() )
//        {
//          $supportticketForm -> setValues(Mage::getSingleton('adminhtml/session')->getSupportticketData());
//          Mage::getSingleton('adminhtml/session')->getSupportticketData(null);
//        } elseif ( Mage::registry('supportticket_data') ) {
//          $supportticketForm-> setValues(Mage::registry('supportticket_data')->getData());
//        }
//        return parent::_prepareForm();
//    }
//}
