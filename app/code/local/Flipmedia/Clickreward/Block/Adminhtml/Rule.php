<?php
class Flipmedia_Clickreward_Block_Adminhtml_Rule extends Mage_Adminhtml_Block_Widget_Grid_Container
{
    public function __construct()
    {
        $this->_blockGroup = 'flipmedia_clickreward';
        $this->_controller = 'adminhtml_rule';
        $this->_headerText = $this->__('List Reward Click Rules');
         
        parent::__construct();
    }
}