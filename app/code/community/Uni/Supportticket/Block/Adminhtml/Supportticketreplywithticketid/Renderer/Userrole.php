<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Userrole
 *
 * @author unicode
 */
class Uni_Supportticket_Block_Adminhtml_Supportticketreplywithticketid_Renderer_Userrole extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    //put your code here
    const  IS_ADMIN = 1;

    public function render(Varien_Object $row) {
        $is_user = $row->getData('is_admin');
        Mage::log($is_user,null,'nimit.log');
        if($is_user == self::IS_ADMIN){
            return '<span style="color:red"><b>Admin</b></span>';
        }else{
            return '<span style="color:green"><b>User</b></span>';
        }
       
    }
    
}