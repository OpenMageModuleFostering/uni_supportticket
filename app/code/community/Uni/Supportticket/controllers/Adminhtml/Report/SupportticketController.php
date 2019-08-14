<?php
class Uni_Supportticket_Adminhtml_Report_SupportticketController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {
        $this->_title($this->__('Reports'))
             ->_title($this->__('Supportticket Report'));

        $this->loadLayout()
            ->_setActiveMenu('supportticket/supportticket')
            ->_addBreadcrumb(Mage::helper('reports')->__('Supportticket Report'),
                Mage::helper('reports')->__('Supportticket Report'))
            ->_addContent($this->getLayout()->createBlock('supportticket/adminhtml_report_supportticket'))
            ->renderLayout();
    }


    public function exportSupportticketCsvAction()
    {
        $fileName   = 'supportticket_report.csv';
        $content    = $this->getLayout()->createBlock('supportticket/adminhtml_report_supportticket_grid')
            ->getCsv();
        $this->_prepareDownloadResponse($fileName, $content);
    }
    public function exportSupportticketExcelAction()
    {
        $fileName   = 'supportticket_report.xml';
        $content    = $this->getLayout()->createBlock('supportticket/adminhtml_report_supportticket_grid')
            ->getExcel($fileName);
        $this->_prepareDownloadResponse($fileName, $content);
    }

}