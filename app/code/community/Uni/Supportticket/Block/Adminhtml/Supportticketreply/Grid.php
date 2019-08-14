<?php

class Uni_Supportticket_Block_Adminhtml_Supportticketreply_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId("supportticketreplyGrid");
        $this->setDefaultSort("entity_id");
        $this->setDefaultDir("DESC");
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel("supportticket/supportticketreply")->getCollection();
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
//				$this->addColumn("ticket_attachment", array(
//				"header" => Mage::helper("supportticket")->__("Ticket Attachment"),
//				"index" => "ticket_attachment",
//				));
        $this->addColumn("reply_time", array(
            "header" => Mage::helper("supportticket")->__("Reply Time"),
            "index" => "reply_time",
            "type" => "datetime"
        ));
        $this->addColumn("ticket_replies", array(
            "header" => Mage::helper("supportticket")->__("Ticket Replies"),
            "index" => "ticket_replies",
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

        return parent::_prepareColumns();
    }

//    public function getRowUrl($row) {
//        return $this->getUrl("*/*/edit", array("id" => $row->getId()));
//    }

//    protected function _prepareMassaction() {
//        $this->setMassactionIdField('entity_id');
//        $this->getMassactionBlock()->setFormFieldName('entity_ids');
//        $this->getMassactionBlock()->setUseSelectAll(true);
//        $this->getMassactionBlock()->addItem('remove_supportticketreply', array(
//            'label' => Mage::helper('supportticket')->__('Remove Supportticketreply'),
//            'url' => $this->getUrl('*/adminhtml_supportticketreply/massRemove'),
//            'confirm' => Mage::helper('supportticket')->__('Are you sure?')
//        ));
//        return $this;
//    }

}
