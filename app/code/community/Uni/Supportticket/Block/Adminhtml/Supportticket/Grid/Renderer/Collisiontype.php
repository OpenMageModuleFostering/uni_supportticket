<?php

class Uni_Supportticket_Block_Adminhtml_Supportticket_Grid_Renderer_Collisiontype extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {

    public function render(Varien_Object $row) {
        $value = $row->getTicketPriority();
        $collection = Mage::getModel("supportticket/supportticketpriority");
        $title = $collection->load($value)->getTitle();
        $color = $collection->load($value)->getFontColor();
        $color1 = $collection->load($value)->getBackgroundColor();
        return '<span style="color:' .$color . '; background-color:' .$color1 . '"><b>' . $title . '</b></span>';
    }

}
?>

