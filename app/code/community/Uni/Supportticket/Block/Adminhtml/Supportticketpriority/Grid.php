<?php

class Uni_Supportticket_Block_Adminhtml_Supportticketpriority_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId("supportticketpriorityGrid");
        $this->setDefaultSort("entity_id");
        $this->setDefaultDir("ASC");
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel("supportticket/supportticketpriority")->getCollection();
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

        $this->addColumn("title", array(
            "header" => Mage::helper("supportticket")->__("Title"),
            "index" => "title",
        ));
        $this->addColumn("font_color", array(
            "header" => Mage::helper("supportticket")->__("Font Color"),
            "index" => "font_color",
        ));
        $this->addColumn("background_color", array(
            "header" => Mage::helper("supportticket")->__("Background Color"),
            "index" => "background_color",
        ));
         $this->addColumn('is_system', array(
            'header' => Mage::helper('supportticket')->__('Is System'),
            'index' => 'is_system',
            'type' => 'options',
            'options' => array('1'=>'Yes','0'=>'No')
        ));
        $this->addColumn('ticket_priority', array(
            'header' => Mage::helper('supportticket')->__('Status'),
            'index' => 'ticket_priority',
            'type' => 'options',
            'options' => Uni_Supportticket_Block_Adminhtml_Supportticketpriority_Grid::getOptionArray28(),
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl("*/*/edit", array("id" => $row->getId()));
    }

//    protected function _prepareMassaction() {
//        $this->setMassactionIdField('entity_id');
//        $this->getMassactionBlock()->setFormFieldName('entity_ids');
//        $this->getMassactionBlock()->setUseSelectAll(true);
//        $this->getMassactionBlock()->addItem('remove_supportticketpriority', array(
//            'label' => Mage::helper('supportticket')->__('Change Status'),
//            'url' => $this->getUrl('*/adminhtml_supportticketpriority/massStatus'),
//            'confirm' => Mage::helper('supportticket')->__('Are you sure?')
//        ));
//        return $this;
//    }

    
    protected function _prepareMassaction() {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('entity_ids');
        $this->getMassactionBlock()->setUseSelectAll(true);
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('supportticket')->__('Change status'),
            'url' => $this->getUrl('*/adminhtml_supportticketpriority/massStatus'),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('supportticket')->__('Status'),
                    'values' => Uni_Supportticket_Block_Adminhtml_Supportticketpriority_Grid::getOptionArray28(),
                )
            )
        ));
        return $this;
    }
    
    
    static public function getOptionArray28() {
        $data_array = array();
        $data_array[0] = 'Disable';
        $data_array[1] = 'Enable';
        return($data_array);
    }

    static public function getValueArray28() {
        $data_array = array();
        foreach (Uni_Supportticket_Block_Adminhtml_Supportticketdepartment_Grid::getOptionArray2() as $k => $v) {
            $data_array[] = array('value' => $k, 'label' => $v);
        }
        return($data_array);
    }

}
