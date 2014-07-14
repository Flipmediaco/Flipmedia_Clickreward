<?php
class Flipmedia_Clickreward_Block_Adminhtml_Renderer_Link extends Mage_Adminhtml_Block_Widget_Grid_Column_Renderer_Abstract {
	
	// Render Link
	public function render(Varien_Object $row) {
		// Create url to Flipmedia_Clickreward_IndexController
    	$url = Mage::getUrl('click/index/reward', array(
							'token'			=> $row->getRuleToken(),
							'_nosid'		=> true,
    						'_secure' 		=> true,
    						'_store' 		=> $row->getStoreId(),
    						'_store_to_url' => false,
    						));
    	    	
    	// Return Link
    	return	sprintf("<a href=\"#\" onclick=\"window.prompt('Copy to clipboard: Ctrl+C, Enter','%s'); return false;\">%s</a>", $url, Mage::helper('checkout')->__('Copy Link')) . "<br/>" . 
    			sprintf("<a href=\"%s\" target=\"_blank\">%s</a>", $url, Mage::helper('checkout')->__('Test Link'));
  }  
}