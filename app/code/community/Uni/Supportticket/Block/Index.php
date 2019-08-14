<?php

class Uni_Supportticket_Block_Index extends Mage_Core_Block_Template {

    
    /*
     * get form action
     */
    public function getFormAction() {
        return $this->getUrl('supportticket/supportticket/save');
    }

    /*
     * generate random ticket ids for backend and frontend
     */
    public function generateCode($l, $c = 'ABCDEFGHIJKLMNOPQRSTUVXYZ1234567890') {
        for ($s = '', $cl = strlen($c) - 1, $i = 0; $i < $l; $s .= $c[mt_rand(0, $cl)], ++$i)
            ;
        return $s;
    }

}
