<?php
class Flipmedia_Clickreward_Adminhtml_RuleController extends Mage_Adminhtml_Controller_Action
{
    public function indexAction()
    {  
        // Let's call our initAction method which will set some basic params for each action
        $this->_initAction()
            ->renderLayout();
    }  
     
    public function newAction()
    {  
        // We just forward the new action to a blank edit form
        $this->_forward('edit');
    }  
     
    public function editAction()
    {  
        $this->_initAction();
     
        // Get id if available
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('flipmedia_clickreward/rule');
     
        if ($id) {
            // Load record
            $model->load($id);
     
            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This rule no longer exists.'));
                $this->_redirect('*/*/');
     
                return;
            }  
        }  
     
        $this->_title($model->getId() ? $model->getName() : $this->__('New Rule'));
     
        $data = Mage::getSingleton('adminhtml/session')->getRuleData(true);
        if (!empty($data)) {
            $model->setData($data);
        }  
     
        Mage::register('flipmedia_clickreward', $model);
     
        $this->_initAction()
            ->_addBreadcrumb($id ? $this->__('Edit Rule') : $this->__('New Rule'), $id ? $this->__('Edit Rule') : $this->__('New Rule'))
            ->_addContent($this->getLayout()->createBlock('flipmedia_clickreward/adminhtml_rule_edit')->setData('action', $this->getUrl('*/*/save')))
            ->renderLayout();
    }
     
    public function saveAction()
    {
        if ($postData = $this->getRequest()->getPost()) {
        	// Create Model
            $model = Mage::getSingleton('flipmedia_clickreward/rule');
 
             // If id is not true
            if (!$this->getRequest()->getParam('id')) {
            	// Create rule_token
            	$rule_token = strtoupper(uniqid());

            	// Load rule buy proposed token
		    	$model->loadByToken($rule_token);
    			// load reward rule data
    			$rule = $model->getData();
    	
    			// If rule has NO members
    			if (!count($rule)) {
    				// Set proposed rule_token to postData
    				$postData['rule_token'] = $rule_token;
    			// Else throw exception
    			} else {
        			throw new Exception('Rule Token must be unique');
    			}
            }
            
            // Set postData
            $model->setData($postData);
 
            try {
            	// Set save
                $model->save();
 
                Mage::getSingleton('adminhtml/session')->addSuccess($this->__('The rule has been saved.'));
                $this->_redirect('*/*/');
 
                return;
            }  
            catch (Mage_Core_Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('An error occurred while saving this rule.'));
            }
 
            Mage::getSingleton('adminhtml/session')->setRuleData($postData);
            $this->_redirectReferer();
        }
    }
    
	public function deleteAction() {
        if ($id = $this->getRequest()->getParam('id')) {
            try {
            	$model = Mage::getSingleton('flipmedia_clickreward/rule');
                $model->setId($id);
                $model->delete();                
                Mage::getSingleton('adminhtml/session')->addSuccess(Mage::helper('adminhtml')->__('The rule has been deleted.'));
                $this->_redirect('*/*/');
                return;
            }
            catch (Exception $e) {
                Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
                $this->_redirect('*/*/edit', array('id' => $this->getRequest()->getParam('id')));
                return;
            }
        }
        Mage::getSingleton('adminhtml/session')->addError(Mage::helper('adminhtml')->__('Unable to find the rule to delete.'));
        $this->_redirect('*/*/');
    }
    
	public function massDeleteAction() {
		$ruleIds = $this->getRequest()->getParam('flipmedia_clickreward');
		if (!is_array($ruleIds)) {
			Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Rule(s)'));
		} else {
			try {
				foreach ($ruleIds as $ruleId) {
					$model = Mage::getModel('flipmedia_clickreward/rule')->load($ruleId);
					$model->delete();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Total of %d rules(s) were successfully deleted',count($ruleIds)));
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		$this->_redirect ( '*/*/index' );
	}
	
	public function massStatusAction() {
		$ruleIds = $this->getRequest()->getParam('flipmedia_clickreward');
		$status	= $this->getRequest()->getParam('status');
		if (!is_array($ruleIds)) {
			Mage::getSingleton('adminhtml/session')->addError($this->__('Please select Rule(s)'));
		} else {
			try {
				foreach ($ruleIds as $ruleId) {
					$model = Mage::getModel('flipmedia_clickreward/rule');
					// Load rule buy id
		    		$model->load($ruleId);
    				// load reward rule data
    				$rule = $model->getData();
					// Reset status
					$rule['is_active'] = $status;
					// Set revised data
					$model->setData($rule);
					// Set save
                	$model->save();
				}
				Mage::getSingleton('adminhtml/session')->addSuccess($this->__('Total of %d rules(s) were successfully updated',count($ruleIds)));
			} catch (Exception $e) {
				Mage::getSingleton('adminhtml/session')->addError($e->getMessage());
			}
		}
		$this->_redirect ( '*/*/index' );
	}
	
    public function linkAction()
    {  
        $this->_initAction();
     
        // Get id if available
        $id  = $this->getRequest()->getParam('id');
        $model = Mage::getModel('flipmedia_clickreward/rule');
     
        if ($id) {
            // Load record
            $model->load($id);
     
            // Check if record is loaded
            if (!$model->getId()) {
                Mage::getSingleton('adminhtml/session')->addError($this->__('This rule no longer exists.'));
                $this->_redirect('*/*/');
     
                return;
            }
            
        	$this->_title($model->getId() ? $model->getName() : $this->__('Link Code'));
     

     
        	Mage::register('flipmedia_clickreward', $model);
     
        	$this->_initAction()->renderLayout();            
            
        }
    }
     
    /**
     * Initialize action
     *
     * Here, we set the breadcrumbs and the active menu
     *
     * @return Mage_Adminhtml_Controller_Action
     */
    protected function _initAction()
    {
        $this->loadLayout()
            // Make the active menu match the menu config nodes (without 'children' inbetween)
            ->_setActiveMenu('rewards/clickreward/list')
            ->_title($this->__('Rewards'))->_title($this->__('Reward Click Rules'))
            ->_addBreadcrumb($this->__('Rewards'), $this->__('Rewards'))
            ->_addBreadcrumb($this->__('Reward Click Rules'), $this->__('Reward Click Rules'));

        return $this;
    }
     
    /**
     * Check currently called action by permissions for current user
     *
     * @return bool
     */
    protected function _isAllowed()
    {
        return Mage::getSingleton('admin/session')->isAllowed('sales/flipmedia_clickreward_rule');
    }
}