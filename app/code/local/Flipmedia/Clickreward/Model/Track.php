<?php
class Flipmedia_Clickreward_Model_Track extends Mage_Core_Model_Abstract 
{
    protected function _construct()
    {
        $this->_init('flipmedia_clickreward/track');
    }
    
    public function loadTrackByIds($rule_id,$customer_id) {
        $id = $this->getResource()->loadTrackByIds($rule_id,$customer_id); 
        $this->load($id); 
    }
}