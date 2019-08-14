<?php
class Uni_Supportticket_Adminhtml_SupportticketbackendController extends Mage_Adminhtml_Controller_Action
{
	public function indexAction()
    {
       $this->loadLayout();
	   $this->_title($this->__("Support Ticket"));
	   $this->renderLayout();
    }
}