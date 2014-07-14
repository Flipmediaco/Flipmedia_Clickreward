<?php
class Flipmedia_Clickreward_Helper_Data extends Mage_Core_Helper_Abstract
{

	public function feedbackToRewards($feedbackTxt,$type = 'notice') {
		// If success
		if ($type == 'success') {
			Mage::getSingleton('core/session')->addSuccess($feedbackTxt);	
		// If error
		} elseif ($type == 'error') {
			Mage::getSingleton('core/session')->addError($feedbackTxt);	
		// notice
		} else {
			Mage::getSingleton('core/session')->addNotice($feedbackTxt);	
		}
		
		// If customer is not logged in
		if (!Mage::getSingleton('customer/session')->isLoggedIn()) {
			// Set Back URL to session			
			Mage::getSingleton('customer/session')->setBeforeAuthUrl(Mage::helper("core/url")->getCurrentUrl());
    		// Redirect to login
        	Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('customer/account/login'));
        	return;
		}
    	
    	// Redirect to rewards
        Mage::app()->getFrontController()->getResponse()->setRedirect(Mage::getUrl('rewards/customer'));       
        return;
	}
}    