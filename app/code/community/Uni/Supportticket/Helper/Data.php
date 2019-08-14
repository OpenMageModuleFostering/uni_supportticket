<?php

class Uni_Supportticket_Helper_Data extends Mage_Core_Helper_Abstract {

    /*
     * to get support ticket status array
     */
    public function getTicketStatuses() {
        $_collection = Mage::getModel('supportticket/supportticketstatus')->getCollection();

        $_status = array();
        foreach ($_collection as $values) {
            if ($values['ticket_status'] == 1) {
                $_status[] = array('value' => $values['entity_id'], 'label' => $values['title']);
            }
        }
        return $_status;
    }
    
    /*
     * to get support ticket priority array
     */
    public function getTicketPrioritys() {
        $_collection = Mage::getModel('supportticket/supportticketpriority')->getCollection();
        $_priority = array();
        foreach ($_collection as $values) {
            if ($values['ticket_priority'] == 1) {
                $_priority[] = array('value' => $values['entity_id'], 'label' => $values['title']);
            }
        }
        return $_priority;
    }

    /*
     * to get support ticket department array
     */
    public function getTicketDepartments() {
        $_collection = Mage::getModel('supportticket/supportticketdepartment')->getCollection();
        $_priority = array();
        foreach ($_collection as $values) {
            if ($values['dep_status'] == 0) {
                $_priority[] = array('value' => $values['entity_id'], 'label' => $values['title']);
            }
        }
        return $_priority;
            
    }

    /*
     * to get admin end support ticket status array
     */
    public function getAdminTicketStatuses() {
        $_status = array();
        $_collection = Mage::getModel('supportticket/supportticketstatus')->getCollection();
        $_collection->addFieldToSelect('entity_id');
        $_collection->addFieldToSelect('title');
        foreach ($_collection as $key => $val) {
            $_status[$val['entity_id']] = $val['title'];
        }
        return $_status;
    }

    /*
     * to get admin end support ticket priority array
     */
    public function getAdminTicketPrioritys() {
        $_status = array();
        $_collection = Mage::getModel('supportticket/supportticketpriority')->getCollection();
        $_collection->addFieldToSelect('entity_id');
        $_collection->addFieldToSelect('title');
        foreach ($_collection as $key => $val) {
            $_status[$val['entity_id']] = $val['title'];
        }
        return $_status;
    }

    /*
     * to get admin end support ticket department array
     */
    public function getAdminTicketDepartments() {
        $_status = array();
        $_collection = Mage::getModel('supportticket/supportticketdepartment')->getCollection();
        $_collection->addFieldToSelect('entity_id');
        $_collection->addFieldToSelect('title');
        foreach ($_collection as $key => $val) {
            $_status[$val['entity_id']] = $val['title'];
        }
        return $_status;
    }

}
