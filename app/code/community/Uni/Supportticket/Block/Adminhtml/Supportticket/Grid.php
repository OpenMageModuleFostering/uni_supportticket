<?php

class Uni_Supportticket_Block_Adminhtml_Supportticket_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId("supportticketGrid");
        $this->setDefaultSort("entity_id");
        $this->setDefaultDir("DESC");
        $this->setSaveParametersInSession(true);
    }

    public function initForm() {

        return $this;
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel("supportticket/supportticket")->getCollection();
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
        $this->addColumn("entity_id", array(
            "header" => Mage::helper("supportticket")->__("ID"),
            "align" => "right",
            "width" => "50px",
            "type" => "number",
            "index" => "entity_id",
        ));

        $this->addColumn("ticket_id", array(
            "header" => Mage::helper("supportticket")->__("Ticket Id"),
            "index" => "ticket_id",
        ));
        $this->addColumn("user_name", array(
            "header" => Mage::helper("supportticket")->__("User Name"),
            "index" => "user_name",
        ));
        $this->addColumn('department', array(
            'header' => Mage::helper('supportticket')->__('Department'),
            'index' => 'department',
            'type' => 'options',
            'options' => Uni_Supportticket_Block_Adminhtml_Supportticket_Grid::getOptionArray3(),
        ));

        $this->addColumn('ticket_priority', array(
            'header' => Mage::helper('supportticket')->__('Ticket Priority'),
            'index' => 'ticket_priority',
            'type' => 'options',
//            'options' => Uni_Supportticket_Block_Adminhtml_Supportticket_Grid::getOptionArray4(),
            'renderer' => new Uni_Supportticket_Block_Adminhtml_Supportticket_Grid_Renderer_Collisiontype(),
        ));

        $this->addColumn("ticket_subject", array(
            "header" => Mage::helper("supportticket")->__("Ticket Subject"),
            "index" => "ticket_subject",
        ));
        
        $this->addColumn('update_time', array(
            'header' => Mage::helper('supportticket')->__('Update Time'),
            'index' => 'update_time',
            'type' => 'datetime',
        ));
        $this->addColumn("reply_count", array(
            "header" => Mage::helper("supportticket")->__("Reply Count"),
            "index" => "reply_count",
        ));
        $this->addColumn('ticket_status', array(
            'header' => Mage::helper('supportticket')->__('Ticket Status'),
            'index' => 'ticket_status',
            'type' => 'options',
//            'options' => Uni_Supportticket_Block_Adminhtml_Supportticket_Grid::getOptionArray11(),
            'renderer' => new Uni_Supportticket_Block_Adminhtml_Supportticket_Grid_Renderer_State(),
        ));

        $this->addColumn('create_time', array(
            'header' => Mage::helper('supportticket')->__('Create Time'),
            'index' => 'create_time',
            'type' => 'datetime',
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        

        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl("*/*/edit", array("id" => $row->getId(), "ticket_id" => $row->getTicketId()));
    }

    protected function _prepareMassaction() {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('entity_ids');
        $this->getMassactionBlock()->setUseSelectAll(true);
        $this->getMassactionBlock()->addItem('remove_supportticket', array(
            'label' => Mage::helper('supportticket')->__('Remove Supportticket'),
            'url' => $this->getUrl('*/adminhtml_supportticket/massRemove'),
            'confirm' => Mage::helper('supportticket')->__('Are you sure?')
        ));
        return $this;
    }

    static public function getOptionArray3() {
        $data_array = Mage::helper('supportticket')->getAdminTicketDepartments();
        return($data_array);
    }

    static public function getValueArray3() {
        $data_array = array();
        foreach (Uni_Supportticket_Block_Adminhtml_Supportticket_Grid::getOptionArray3() as $k => $v) {
            $data_array[] = array('value' => $k, 'label' => $v);
        }
        return($data_array);
    }

    static public function getOptionArray4() {
        $data_array = Mage::helper('supportticket')->getAdminTicketPrioritys();
        return($data_array);
    }

    static public function getValueArray4() {
        $data_array = array();
        foreach (Uni_Supportticket_Block_Adminhtml_Supportticket_Grid::getOptionArray4() as $k => $v) {
            $data_array[] = array('value' => $k, 'label' => $v);
        }
        return($data_array);
    }

    static public function getOptionArray11() {
        $data_array = Mage::helper('supportticket')->getAdminTicketStatuses();
        return($data_array);
    }

    static public function getValueArray11() {
        $data_array = array();
        foreach (Uni_Supportticket_Block_Adminhtml_Supportticket_Grid::getOptionArray11() as $k => $v) {
            $data_array[] = array('value' => $k, 'label' => $v);
        }
        return($data_array);
    }

}
