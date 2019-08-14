<?php
class Uni_Supportticket_IndexController extends Mage_Core_Controller_Front_Action{

/**
     * Display support ticket block on frontend
     */    
    public function IndexAction() {
        if (Mage::getSingleton('customer/session')->isLoggedIn() == 1){
	  $this->loadLayout();   
	  $this->getLayout()->getBlock("head")->setTitle($this->__("Support Ticket"));
	        $breadcrumbs = $this->getLayout()->getBlock("breadcrumbs");
      $breadcrumbs->addCrumb("home", array(
                "label" => $this->__("Home Page"),
                "title" => $this->__("Home Page"),
                "link"  => Mage::getBaseUrl()
		   ));

      $breadcrumbs->addCrumb("support ticket", array(
                "label" => $this->__("Support Ticket"),
                "title" => $this->__("Support Ticket")
		   ));

      $this->renderLayout(); 
        }
        else {
            $this->_redirect();
        }
	  
    }
}