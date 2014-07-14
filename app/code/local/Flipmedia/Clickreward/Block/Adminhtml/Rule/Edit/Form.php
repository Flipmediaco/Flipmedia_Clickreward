<?php
class Flipmedia_Clickreward_Block_Adminhtml_Rule_Edit_Form extends Mage_Adminhtml_Block_Widget_Form
{
    /**
     * Init class
     */
    public function __construct()
    {  
        parent::__construct();
     
        $this->setId('flipmedia_clickreward_rule_form');
        $this->setTitle(Mage::helper('checkout')->__('Rule Information'));
    }  
     
    /**
     * Setup form fields for inserts/updates
     *
     * return Mage_Adminhtml_Block_Widget_Form
     */
    protected function _prepareForm()
    {  
        $model = Mage::registry('flipmedia_clickreward');
        
        $form = new Varien_Data_Form(array(
            'id'        => 'edit_form',
            'action'    => $this->getUrl('*/*/save', array('id' => $this->getRequest()->getParam('id'))),
            'method'    => 'post'
        ));
     
        $fieldset = $form->addFieldset('base_fieldset', array(
            'legend'    => Mage::helper('checkout')->__('Rule Information'),
            'class'     => 'fieldset-wide',
        ));
     
        if ($model->getId()) {
            $fieldset->addField('id', 'hidden', array(
                'name' => 'id',
            ));
            
        	$fieldset->addField('rule_token', 'hidden', array(
        						'name' => 'rule_token',
        	));
        }  
     
        $fieldset->addField('rule_name', 'text', array(
            				'name'      => 'rule_name',
            				'label'     => Mage::helper('checkout')->__('Rule Name'),
            				'title'     => Mage::helper('checkout')->__('Rule Name'),
            				'class'     => 'required-entry',
            				'required'  => true,
        ));
        
        $fieldset->addField('rule_desc', 'text', array(
            				'name'      => 'rule_desc',
            				'label'     => Mage::helper('checkout')->__('Rule Comment'),
            				'title'     => Mage::helper('checkout')->__('Rule Comment'),
            				'class'     => 'required-entry',
            				'required'  => true,
            				'after_element_html' => "<small>" . Mage::helper('checkout')->__('Comment that appears on customers reward balance') . "</small>"
        ));
        

        
		$dateFormatIso = Mage::app()->getLocale()->getDateFormat(Mage_Core_Model_Locale::FORMAT_TYPE_MEDIUM);
        
		$fieldset->addField('rule_from_date', 'date', array(
							'name' => 'rule_from_date',
							'label' => $this->__('Start Date'),
							'title' => $this->__('Start Date'),
							'class' => 'validate-date',
							'image' => $this->getSkinUrl('images/grid-cal.gif'),
							'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
							'format' => $dateFormatIso));
							
		$fieldset->addField('rule_to_date', 'date', array(
							'name' => 'rule_to_date',
							'label' => $this->__('Expire Date'),
							'title' => $this->__('Expire Date'),
							'class' => 'validate-date',
							'image' => $this->getSkinUrl('images/grid-cal.gif'),
							'input_format' => Varien_Date::DATE_INTERNAL_FORMAT,
							'format' => $dateFormatIso));
        
        $fieldset->addField('point_amount', 'text', array(
            'name'      => 'point_amount',
            'label'     => Mage::helper('checkout')->__('Point amount'),
            'title'     => Mage::helper('checkout')->__('Point amount'),
          	'class'     => 'required-entry validate-greater-than-zero',
            'required'  => true,
            'after_element_html' => "<small>" . Mage::helper('checkout')->__('Number of Reward points to be awarded for the click') . "</small>"
        ));

        if (!Mage::app()->isSingleStoreMode())
			$fieldset->addField('store_id', 'select', array(
          						'name'      => 'store_id',
          						'label'     => Mage::helper('checkout')->__('Store'),
					            'title'     => Mage::helper('checkout')->__('Store'),
          						'class'     => 'required-entry',
          						'required'  => true,
          						'values'	=> Mage::getSingleton('adminhtml/system_store')->getStoreValuesForForm(true,false)
          	));
          	
		$fieldset->addField('is_active', 'select', array(
          					'name'      => 'is_active',
          					'label'     => Mage::helper('checkout')->__('Status'),
          					'title'     => Mage::helper('checkout')->__('Status'),		
							'class'     => 'required-entry',
							'required'  => true,
							'name'      => 'is_active',
							'values' => Mage::getModel('flipmedia_clickreward/source_rule_status')->toOptionArray()
		));

        $form->setValues($model->getData());
        $form->setUseContainer(true);
        $this->setForm($form);
     
        return parent::_prepareForm();
    }  
}
