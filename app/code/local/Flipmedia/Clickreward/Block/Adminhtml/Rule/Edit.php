<?php
class Flipmedia_Clickreward_Block_Adminhtml_Rule_Edit extends Mage_Adminhtml_Block_Widget_Form_Container
{
    /**
     * Init class
     */
    public function __construct()
    {  
        $this->_blockGroup = 'flipmedia_clickreward';
        $this->_controller = 'adminhtml_rule';
     
        parent::__construct();
     
        $this->_updateButton('save', 'label', $this->__('Save Rule'));
        $this->_updateButton('delete', 'label', $this->__('Delete Rule'));
    }  
     
    /**
     * Get Header text
     *
     * @return string
     */
    public function getHeaderText()
    {  
        if (Mage::registry('flipmedia_clickreward')->getId()) {
            return $this->__('Edit Rule');
        }  
        else {
            return $this->__('New Rule');
        }  
    }  
}