<?php
class Flipmedia_Clickreward_Model_Mysql4_Track extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('flipmedia_clickreward/track','id');
    }
    
    public function loadTrackByIds($rule_id,$customer_id) {
        $table =	$this->getMainTable(); 
        $where =	$this->_getReadAdapter()->quoteInto("rule_id = ? AND ", $rule_id) . 
        			$this->_getReadAdapter()->quoteInto("customer_id = ?", $customer_id);
        $select =	$this->_getReadAdapter()->select()->from($table,array('id'))->where($where); 
        $id = 		$this->_getReadAdapter()->fetchOne($select); 
        return $id;
    } 
}