<?php
class Uni_Supportticket_Block_Adminhtml_Report_Supportticket_Grid extends Mage_Adminhtml_Block_Report_Grid
{

    public function __construct()
    {
        parent::__construct();
        $this->setId('gridSupportticketReport');
		$this->setTemplate('report/grid.phtml');
		$this->setSubReportSize(0);
    }

    protected function _prepareCollection()
    {
        parent::_prepareCollection();
        $this->getCollection()->initReport('supportticket/supportticket_collection');
    }

    protected function _prepareColumns()
    {

		        
		$this->addColumn('entity_id', array(
            'header'    => $this->__('entity_id'),
            'sortable'  => false,
            'index'     => 'entity_id'
        ));        
		$this->addColumn('ticket_id', array(
            'header'    => $this->__('ticket_id'),
            'sortable'  => false,
            'index'     => 'ticket_id'
        ));        
		$this->addColumn('user_name', array(
            'header'    => $this->__('user_name'),
            'sortable'  => false,
            'index'     => 'user_name'
        ));        
		$this->addColumn('department', array(
            'header'    => $this->__('department'),
            'sortable'  => false,
            'index'     => 'department'
        ));        
		$this->addColumn('ticket_priority', array(
            'header'    => $this->__('ticket_priority'),
            'sortable'  => false,
            'index'     => 'ticket_priority'
        ));        
		$this->addColumn('ticket_subject', array(
            'header'    => $this->__('ticket_subject'),
            'sortable'  => false,
            'index'     => 'ticket_subject'
        ));        
		$this->addColumn('ticket_message', array(
            'header'    => $this->__('ticket_message'),
            'sortable'  => false,
            'index'     => 'ticket_message'
        ));        
		$this->addColumn('ticket_attachment', array(
            'header'    => $this->__('ticket_attachment'),
            'sortable'  => false,
            'index'     => 'ticket_attachment'
        ));        
		$this->addColumn('update_time', array(
            'header'    => $this->__('update_time'),
            'sortable'  => false,
            'index'     => 'update_time'
        ));        
		$this->addColumn('create_time', array(
            'header'    => $this->__('create_time'),
            'sortable'  => false,
            'index'     => 'create_time'
        ));        
		$this->addColumn('reply_count', array(
            'header'    => $this->__('reply_count'),
            'sortable'  => false,
            'index'     => 'reply_count'
        ));        
		$this->addColumn('ticket_status', array(
            'header'    => $this->__('ticket_status'),
            'sortable'  => false,
            'index'     => 'ticket_status'
        ));

		/*

		//demo code

        $this->addColumn('county', array(
            'header'    => $this->__('County'),
            'sortable'  => false,
            'index'     => 'county'
        ));

        $this->addColumn('city', array(
            'header'    => $this->__('City'),
            'sortable'  => false,
            'index'     => 'city'
        ));

        $baseCurrencyCode = $this->getCurrentCurrencyCode();

        $this->addColumn('tax_rate', array(
            'header'    => $this->__('Tax Rate'),
            'align'     => 'right',
            'sortable'  => false,
			'index'     => 'tax_rate',
            'type'      => 'text',
        ));

        $this->addColumn('tax_collected_amount', array(
            'header'    => $this->__('Tax Collected'),
            'align'     => 'right',
            'sortable'  => false,
            'type'      => 'currency',
            'currency_code'  => $baseCurrencyCode,
            'index'     => 'tax_collected_amount',
            'total'     => 'sum',
            'renderer'  => 'adminhtml/report_grid_column_renderer_currency'
        ));

        $this->addColumn('taxed_sales_amount', array(
            'header'    => $this->__('Taxed Sales'),
            'align'     => 'right',
            'sortable'  => false,
            'type'      => 'currency',
            'currency_code'  => $baseCurrencyCode,
            'index'     => 'taxed_sales_amount',
            'total'     => 'sum',
            'renderer'  => 'adminhtml/report_grid_column_renderer_currency'
        ));

        $this->addColumn('out_of_state_sales_amount', array(
            'header'    => $this->__('Out of State Sales'),
            'align'     => 'right',
            'sortable'  => false,
            'type'      => 'currency',
            'currency_code'  => $baseCurrencyCode,
            'index'     => 'out_of_state_sales_amount',
            'total'     => 'sum',
            'renderer'  => 'adminhtml/report_grid_column_renderer_currency'
        ));

        $this->addColumn('non_taxable_sales_amount', array(
            'header'    => $this->__('Non-Taxable Sales'),
            'align'     => 'right',
            'sortable'  => false,
            'type'      => 'currency',
            'currency_code'  => $baseCurrencyCode,
            'index'     => 'non_taxable_sales_amount',
            'total'     => 'sum',
            'renderer'  => 'adminhtml/report_grid_column_renderer_currency'
        ));

        $this->addColumn('total_order_amount_amount', array(
            'header'    => $this->__('Total Order Amount'),
            'align'     => 'right',
            'sortable'  => false,
            'type'      => 'currency',
            'currency_code'  => $baseCurrencyCode,
            'index'     => 'total_order_amount_amount',
            'total'     => 'sum',
            'renderer'  => 'adminhtml/report_grid_column_renderer_currency'
        ));

		//demo code

		*/

        $this->addExportType('*/*/exportSupportticketCsv', Mage::helper('supportticket')->__('CSV'));
        $this->addExportType('*/*/exportSupportticketExcel', Mage::helper('supportticket')->__('Excel'));

        return parent::_prepareColumns();
    }

}