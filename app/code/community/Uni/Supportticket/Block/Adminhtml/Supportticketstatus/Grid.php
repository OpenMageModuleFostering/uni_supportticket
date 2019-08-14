<?php

class Uni_Supportticket_Block_Adminhtml_Supportticketstatus_Grid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId("supportticketstatusGrid");
        $this->setDefaultSort("entity_id");
        $this->setDefaultDir("ASC");
        $this->setSaveParametersInSession(true);
    }

    protected function _prepareCollection() {
        $collection = Mage::getModel("supportticket/supportticketstatus")->getCollection();
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
        $this->addColumn('ticket_status', array(
            'header' => Mage::helper('supportticket')->__('Ticket Status'),
            'index' => 'ticket_status',
            'type' => 'options',
            'options' => Uni_Supportticket_Block_Adminhtml_Supportticketstatus_Grid::getOptionArray23(),
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
            'url' => $this->getUrl('*/adminhtml_supportticketstatus/massStatus'),
            'additional' => array(
                'visibility' => array(
                    'name' => 'status',
                    'type' => 'select',
                    'class' => 'required-entry',
                    'label' => Mage::helper('supportticket')->__('Status'),
                    'values' => Uni_Supportticket_Block_Adminhtml_Supportticketstatus_Grid::getOptionArray23(),
                )
            )
        ));
        return $this;
    }
    static public function getOptionArray23() {
        $data_array = array();
        $data_array[0] = 'Disable';
        $data_array[1] = 'Enable';
        return($data_array);
    }

    static public function getValueArray23() {
        $data_array = array();
        foreach (Uni_Supportticket_Block_Adminhtml_Supportticketstatus_Grid::getOptionArray23() as $k => $v) {
            $data_array[] = array('value' => $k, 'label' => $v);
        }
        return($data_array);
    }

}
