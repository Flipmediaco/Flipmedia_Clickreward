<?php
class Flipmedia_Clickreward_Model_Rule extends Mage_Core_Model_Abstract
{
    protected function _construct()
    {
        $this->_init('flipmedia_clickreward/rule');
    }

    public function loadByToken($token) {
        $id = $this->getResource()->loadByToken($token); 
        $this->load($id); 
    }
}