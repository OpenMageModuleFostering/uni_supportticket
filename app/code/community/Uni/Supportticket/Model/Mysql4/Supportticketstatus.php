<?php
class Uni_Supportticket_Model_Mysql4_Supportticketstatus extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init("supportticket/supportticketstatus", "entity_id");
    }
}