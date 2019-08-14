<?php
class Uni_Supportticket_Block_Adminhtml_Supportticket_Grid_Renderer_State extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract
{
    public function render(Varien_Object $row) {
        $value =  $row->getTicketStatus();
        $collection = Mage::getModel("supportticket/supportticketstatus");
        $title = $collection->load($value)->getTitle();
        $color = $collection->load($value)->getFontColor();
           $color1 = $collection->load($value)->getBackgroundColor();
        return '<span style="color:'.$color.'; background-color:'.$color1.'"><b>'.$title.'</b></span>';
    }
}
?>

