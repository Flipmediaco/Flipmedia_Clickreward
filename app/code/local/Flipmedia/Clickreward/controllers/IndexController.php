<?php
class Flipmedia_Clickreward_IndexController extends Mage_Core_Controller_Front_Action {

    public function rewardAction() {
    	// If not logged in customer
    	if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
			// Show login notice
    		Mage::helper('flipmedia_clickreward')->feedbackToRewards(	'Login or Create an Account to be Rewarded your points.',
    														'notice');
        	return;
        }

		// GET REQUEST params
    	$params = $this->getRequest()->getParams();
    	
    	// Load reward model
    	$reward = Mage::getModel('flipmedia_clickreward/rule');
    	// Fetch reward using token
    	$reward->loadByToken($params['token']);
    	// reward rule data
    	$rule = $reward->getData();
    	
    	// If rule has members
    	if (count($rule)) {
    		// Check rule is_active
    		if (!$rule['is_active']) {
				// Show error not active
    			Mage::helper('flipmedia_clickreward')->feedbackToRewards(	'Reward points rule not active.',
    															'error');
        		return;  		
    		}
    		
    		// Check rule valid for this store
			//
    		// If current store is not in store_id
    		if (Mage::app()->getStore(true)->getId() != $rule['store_id']) {
				// Show error not valid for this store
    			Mage::helper('flipmedia_clickreward')->feedbackToRewards(	'Reward points rule not valid for this store.',
    															'error');
        		return;  
    		}
    		    	
    		// Check rule date validity
    		//
    		// If rule_from_date is not empty
    		if (!empty($rule['rule_from_date'])) {
    			// extract rule_from_date and convert to timestamp
    			list($from_year,$from_month,$from_day) = explode('-',$rule['rule_from_date']);
    			//
    			// If rule_to_date is not empty
    			if (!empty($rule['rule_to_date'])) {
					// extract to_date and convert to timestamp
    				list($to_year,$to_month,$to_day) = explode('-',$rule['rule_to_date']);
    			}
    			//    		
    			// If time is before rule_from_date
    			if (time() < mktime(00,00,00,$from_month,$from_day,$from_year) || 
    				(!is_null($rule['rule_to_date']) && time() > mktime(23,59,59,$to_month,$to_day,$to_year))) {
					// Show error not valid for date
    				Mage::helper('flipmedia_clickreward')->feedbackToRewards(	'Reward points rule not valid.',
    																'error');
        			return;
    			}
    		}

    		// Check rule has not been used before
    		//
    		// Load track model
    		$track = Mage::getModel('flipmedia_clickreward/track');
    		// Fetch track using id and customer id
    		$track->loadTrackByIds($rule['id'],Mage::getSingleton('customer/session')->getId());
    		// reward rule data
    		$data = $track->getData();
    		//
    		// If data is an array
    		if (isset($data['id'])) {
				// Show error not valid for date
    			Mage::helper('flipmedia_clickreward')->feedbackToRewards(	sprintf('Reward points rule "%s" already awarded, rule can only be redeemed once per customer.',$rule['rule_desc']),
    															'notice');
        		return;
    		}
    		
        	try {            
    			// Process reward point transfer
    			//
    			// Load Rewards api module
    			$transferReward = Mage::getModel('rewardsapi/api');
    			// make transfer
    			$transferReward->makeTransfer(	Mage::getSingleton('customer/session')->getId(),
    											1,
    											$rule['point_amount'],
    											$rule['rule_desc']);
    		
	    		// Record rule usage for this customer
	    		//
	    		// Load track model
    			$track = Mage::getModel('flipmedia_clickreward/track');
    			//
    			// Set Track data
    			$track->setData('rule_id',$rule['id']);
    			$track->setData('customer_id',Mage::getSingleton('customer/session')->getId());
    			$track->setData('point_amount',$rule['point_amount']);
    			$track->save();
    		
        	} catch (Exception $e) {
            	Mage::logException($e);
        	}

			// Show error not valid for date
    		Mage::helper('flipmedia_clickreward')->feedbackToRewards(	sprintf('Reward points rule "%s" awarded.',$rule['rule_desc']),
    														'success');
        	return;
		}
    }
}