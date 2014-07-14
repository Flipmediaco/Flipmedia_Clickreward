<?php
class Flipmedia_Clickreward_Model_Mysql4_Rule extends Mage_Core_Model_Mysql4_Abstract
{
    protected function _construct()
    {
        $this->_init('flipmedia_clickreward/rule','id');
    }
    
    public function loadByToken($token){ 
        $table = $this->getMainTable(); 
        $where = $this->_getReadAdapter()->quoteInto("rule_token = ?", $token); 
        $select = $this->_getReadAdapter()->select()->from($table,array('id'))->where($where); 
        $id = $this->_getReadAdapter()->fetchOne($select); 
        return $id; 
    } 
    
}