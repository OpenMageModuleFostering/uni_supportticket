<?php

class Uni_Supportticket_Block_Adminhtml_Supportticket_Customergrid extends Mage_Adminhtml_Block_Widget_Grid {

    public function __construct() {
        parent::__construct();
        $this->setId("supportticketGrid");
        $this->setDefaultSort("last_reply_time");
        $this->setDefaultDir("DESC");
        $this->setSaveParametersInSession(true);
        $this->setFilterVisibility(false);
        $this->setFilterVisibility(false);
        
//        parent::__construct();
    }
     public function getMainButtonsHtml() {
        $html = parent::getMainButtonsHtml();
        $_id = Mage::registry('current_customer')->getId();
        $_name = Mage::registry('current_customer')->getName();
        $_email = Mage::registry('current_customer')->getEmail();
        $create_button = $this->getLayout()->createBlock('adminhtml/widget_button')
                ->setData(array(
            'label' => Mage::helper('adminhtml')->__('Create Ticket'),
            'onclick'=>"setLocation('" . $this->getUrl('supportticket/adminhtml_supportticket/new', array('id' => $_id,'name'=>$_name,'email'=>$_email)) . "')",
            'class' => 'add'
        ));
        $html .= $create_button->toHtml();
        return $html;
    }

    public function initForm() {
//        $form = new Varien_Data_Form();
//        $form->setHtmlIdPrefix('_account');
//        $form->setFieldNameSuffix('account');
//        $customer = Mage::registry('current_customer');

        /** @var $customerForm Mage_Customer_Model_Form */
//        $customerForm = Mage::getModel('customer/form');
//        $customerForm->setEntity($customer)
//            ->setFormCode('adminhtml_customer')
//            ->initDefaultValues();
//
//        $fieldset = $form->addFieldset('base_fieldset', array(
//            'legend' => Mage::helper('customer')->__('Account Information')
//        ));
//
//        $attributes = $customerForm->getAttributes();
//        foreach ($attributes as $attribute) {
//            /* @var $attribute Mage_Eav_Model_Entity_Attribute */
//            $attribute->setFrontendLabel(Mage::helper('customer')->__($attribute->getFrontend()->getLabel()));
//            $attribute->unsIsVisible();
//        }
//
//        
//        $form->setValues($customer->getData());
//        $this->setForm($form);
        return $this;
    }

    protected function _prepareCollection() {
        $_id = Mage::registry('current_customer')->getId();
        $collection = Mage::getModel("supportticket/supportticket")->getCollection();
        $collection->addFieldToFilter('user_id', $_id);
        $this->setCollection($collection);
        return parent::_prepareCollection();
    }

    protected function _prepareColumns() {
//        $this->addColumn("entity_id", array(
//            "header" => Mage::helper("supportticket")->__("ID"),
//            "align" => "right",
//            "width" => "50px",
//            "type" => "number",
//            "index" => "entity_id",
//        ));

        $this->addColumn("ticket_id", array(
            "header" => Mage::helper("supportticket")->__("ID"),
            "index" => "ticket_id",
        ));
        $this->addColumn('last_reply_time', array(
            'header' => Mage::helper('supportticket')->__('Last Reply Time'),
            'index' => 'update_time',
            'type' => 'datetime',
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
            'header' => Mage::helper('supportticket')->__('Priority'),
            'index' => 'ticket_priority',
            'type' => 'options',
//            'options' => Uni_Supportticket_Block_Adminhtml_Supportticket_Grid::getOptionArray4(),
                           'renderer'=> new Uni_Supportticket_Block_Adminhtml_Supportticket_Grid_Renderer_Collisiontype(), 

            ));

        $this->addColumn("ticket_subject", array(
            "header" => Mage::helper("supportticket")->__("Subject"),
            "index" => "ticket_subject",
        ));


        $this->addColumn("reply_count", array(
            "header" => Mage::helper("supportticket")->__("Messages"),
            "index" => "reply_count",
        ));
        $this->addColumn('ticket_status', array(
            'header' => Mage::helper('supportticket')->__('Status'),
            'index' => 'ticket_status',
            'type' => 'options',
//            'options' => Uni_Supportticket_Block_Adminhtml_Supportticket_Grid::getOptionArray11(),
                        'renderer'=> new Uni_Supportticket_Block_Adminhtml_Supportticket_Grid_Renderer_State(), 

            ));

        $this->addColumn('create_time', array(
            'header' => Mage::helper('supportticket')->__('Created'),
            'index' => 'create_time',
            'type' => 'datetime',
        ));
        $this->addExportType('*/*/exportCsv', Mage::helper('sales')->__('CSV'));
        $this->addExportType('*/*/exportExcel', Mage::helper('sales')->__('Excel'));

        return parent::_prepareColumns();
    }


//    public function getRowUrl($row) {
//        return $this->getUrl("supportticket/adminhtml_supportticket/edit", array("id" => $row->getId()));
//    }

//    protected function _prepareMassaction() {
//        $this->setMassactionIdField('entity_id');
//        $this->getMassactionBlock()->setFormFieldName('entity_ids');
//        $this->getMassactionBlock()->setUseSelectAll(true);
//        $this->getMassactionBlock()->addItem('remove_supportticket', array(
//            'label' => Mage::helper('supportticket')->__('Remove Supportticket'),
//            'url' => $this->getUrl('*/adminhtml_supportticket/massRemove'),
//            'confirm' => Mage::helper('supportticket')->__('Are you sure?')
//        ));
//        return $this;
//    }

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
