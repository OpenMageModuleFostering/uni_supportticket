<?php
class Uni_Supportticket_Model_Mysql4_Supportticketpriority extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("supportticket/supportticketpriority", "entity_id");
    }
}