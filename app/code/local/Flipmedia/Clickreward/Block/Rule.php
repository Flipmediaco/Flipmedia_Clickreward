<?php
class Flipmedia_Clickreward_Block_Rule
    extends Mage_Core_Block_Abstract
    implements Mage_Widget_Block_Interface
{

    protected function _toHtml()
    {
    	// Get widget data
    	$id		= $this->getData('id_attrib');
		$target	= $this->getData('target_attrib');
		$text	= $this->getData('text_attrib');

    	// Load reward model
    	$model = Mage::getModel('flipmedia_clickreward/rule');
    	$model->load($id);
    	
    	// If no id loaded
    	if (!$model->getId()) {
    		// return empty
			return '';
		
		// Else id is loaded
		} else {
			// Create url
    		$url = Mage::getUrl('click/index/reward', array(
								'token'			=> $model->getRuleToken(),
								'_nosid'		=> true,
    							'_secure' 		=> true,
    							'_store' 		=> $model->getStoreId(),
    							'_store_to_url' => false,
    							));
		}
		
		// Create link code
        $html = sprintf("<a href=\"%s\" target=\"%s\">%s</a>",$url,$target,$text);
        return $html;
    }

}