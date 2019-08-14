<?php

class Uni_Supportticket_Block_Adminhtml_Supportticketdepartment_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId("supportticketdepartmentGrid");
        $this->setDefaultSort("entity_id");
        $this->setDefaultDir("ASC");
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel("supportticket/supportticketdepartment")->getCollection();
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
            "header" => Mage::helper("supportticket")->__("Department Title"),
            "index" => "title",
        ));

        $this->addColumn('is_system', array(
            'header' => Mage::helper('supportticket')->__('Is System'),
            'index' => 'is_system',
            'type' => 'options',
            'options' => array('1' => 'Yes', '0' => 'No')
        ));

        $this->addColumn('dep_status', array(
            'header' => Mage::helper('supportticket')->__('Status'),
            'index' => 'dep_status',
            'type' => 'options',
            'options' => Uni_Supportticket_Block_Adminhtml_Supportticketdepartment_Grid::getOptionArray2(),
        ));

        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

        return parent::_prepareColumns();
    }

    public function getRowUrl($row) {
        return $this->getUrl("*/*/edit", array("id" => $row->getId()));
    }   
    
    protected function _prepareMassaction() {
        $this->setMassactionIdField('entity_id');
        $this->getMassactionBlock()->setFormFieldName('entity_ids');
        $this->getMassactionBlock()->setUseSelectAll(true);
        $this->getMassactionBlock()->addItem('status', array(
            'label' => Mage::helper('supportticket')->__('Change status'),
            'url' => $this->getUrl('*/adminhtml_supportticketdepartment/massStatus'),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('supportticket')->__('Status'),
                    'values' => Uni_Supportticket_Block_Adminhtml_Supportticketdepartment_Grid::getOptionArray2(),
                )
            )
        ));
        return $this;
    }

    static public function getOptionArray2() {
        $data_array = array();
        $data_array[0] = 'Enable';
        $data_array[1] = 'Disable';
        return($data_array);
    }

    static public function getOptionArray3() {
        $data_array = array();
        $data_array[0] = 'No';
        $data_array[1] = 'Yes';
        return($data_array);
    }

    static public function getValueArray2() {
        $data_array = array();
        foreach (Uni_Supportticket_Block_Adminhtml_Supportticketdepartment_Grid::getOptionArray2() as $k => $v) {
            $data_array[] = array('value' => $k, 'label' => $v);
        }
        return($data_array);
    }

    static public function getValueArray3() {
        $data_array = array();
        foreach (Uni_Supportticket_Block_Adminhtml_Supportticketdepartment_Grid::getOptionArray3() as $k => $v) {
            $data_array[] = array('value' => $k, 'label' => $v);
        }
        return($data_array);
    }

}
