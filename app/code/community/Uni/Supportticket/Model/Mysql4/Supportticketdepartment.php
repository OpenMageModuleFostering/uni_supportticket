<?php
class Uni_Supportticket_Model_Mysql4_Supportticketdepartment extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("supportticket/supportticketdepartment", "entity_id");
    }
}