<?php
class Flipmedia_Clickreward_Model_Source_Rules
{
    public function toOptionArray() {
    	// options
    	$options = array(	'value' => '',
    						'label'	=> 'Please Select');

    	// Load reward model
    	$model = Mage::getModel('flipmedia_clickreward/rule');
    	// Get all
    	$rules = $model->getCollection();
    	// add rules to options
    	foreach ($rules as $rule) {
    		$options[] = array('value' => 	$rule['id'],
    							'label' =>	$rule['rule_name'] . " - " . Mage::app()->getStore($rule['store_id'])->getName());
    	
    	}
    	
		// return options
    	return $options;
    }
}


