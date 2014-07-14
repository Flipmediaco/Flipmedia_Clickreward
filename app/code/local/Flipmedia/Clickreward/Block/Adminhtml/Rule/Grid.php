<?php
class Flipmedia_Clickreward_Block_Adminhtml_Rule_Grid extends Mage_Adminhtml_Block_Widget_Grid
{
    public function __construct()
    {
        parent::__construct();         
        $this->setDefaultSort('id');
        $this->setId('flipmedia_clickreward_rule_grid');
        $this->setDefaultDir('asc');
        $this->setSaveParametersInSession(true);
    }
     
    protected function _getCollectionClass()
    {
        return 'flipmedia_clickreward/rule_collection';
    }
     
    protected function _prepareCollection()
    {
        // Get and set our collection for the grid
        $collection = Mage::getResourceModel($this->_getCollectionClass());
        $this->setCollection($collection);
         
        return parent::_prepareCollection();
    }

    protected function _prepareColumns()
    {

        $this->addColumn('id',
            array(
                'header' => $this->__('id'),
                'align'  =>'right',
                'width'  => '50px',
                'index'  => 'id',
            ));

        $this->addColumn('rule_name',
            array(
                'header' => $this->__('Rule Name'),
                'align'  =>'left',
                'index'  => 'rule_name',
            ));

        $this->addColumn('rule_token',
            array(
                'header' => $this->__('Rule Token'),
                'align'  =>'left',
                'index'  => 'rule_token',
            ));

		$this->addColumn('rule_from_date',
			array(
				'header' => $this->__('Date Start'),
				'align' => 'left',
				'width' => '120px',
				'type' => 'date',
				'default' => '--',
				'index' => 'rule_from_date'));
		
		$this->addColumn('rule_to_date', 
			array(
				'header' => $this->__('Date Expire'),
				'align' => 'left',
				'width' => '120px',
				'type' => 'date',
				'default' => '--',
				'index' => 'rule_to_date'));

        $this->addColumn('point_amount',
            array(
                'header'  => $this->__('Point amount'),
                'align'   => 'left',
                'width'   => '80px',
                'index'   => 'point_amount',
            ));
            

        if (!Mage::app()->isSingleStoreMode())
            $this->addColumn('store_id', array(
                'header'        => $this->__('Store'),
                'index'         => 'store_id',
                'type'          => 'store',
                'store_all'     => true,
                'store_view'    => true,
                'sortable'      => false,
                'filter_condition_callback' => array($this, '_filterStoreCondition'),
            ));
            
        $this->addColumn('is_active',
            array(
                'header'  => $this->__('Status'),
                'align'   => 'left',
                'width'   => '80px',
                'index'   => 'is_active',
                'type'    => 'options',
                'options' => Mage::getModel('flipmedia_clickreward/source_rule_status')->toOptionArray()
            ));
                        
		$this->addColumn('link',
			array(
				'header'    =>  $this->__('Link'),
				'width'     => '100',
				'type'      => 'text',
				'filter'    => false,
				'sortable'  => false,
				'is_system' => true,
				'renderer'  => 'Flipmedia_Clickreward_Block_Adminhtml_Renderer_Link',
			));
            
        $this->addColumn('action',
            array(
                'header'    =>  $this->__('Action'),
                'width'     => '100',
                'type'      => 'action',
                'getter'    => 'getId',
                'actions'   => array(
                    array(
                        'caption'   => $this->__('Edit'),
                        'url'       => array('base'=> '*/*/edit'),
                        'field'     => 'id'
                    )
                ),
                'filter'    => false,
                'sortable'  => false,
                'index'     => 'action',
                'is_system' => true,
            ));

        return parent::_prepareColumns();
    }
    
    protected function _prepareMassaction()
    {
        $this->setMassactionIdField('id');
        $this->getMassactionBlock()->setFormFieldName('flipmedia_clickreward');
        
        $this->getMassactionBlock()->addItem('delete',
            array(
                'label'   => $this->__('Delete'),
                'url'     => $this->getUrl('*/*/massDelete'),
                'confirm' => $this->__('Are you sure?')
            ));
        
        $this->getMassactionBlock()->addItem('status',
            array(
                'label'=> $this->__('Change status'),
                'url'  => $this->getUrl('*/*/massStatus', array('_current'=>true)),
                'additional' => array(
                    'visibility' => array(
                        'name'   => 'status',
                        'type'   => 'select',
                        'class'  => 'required-entry',
                        'label'  => $this->__('Status'),
                        'values' => Mage::getModel('flipmedia_clickreward/source_rule_status')->toOptionArray()
                    )
                )
            )
        );
        return $this;
    } 

    public function getRowUrl($row)
    {
        // This is where our row data will link to
        return $this->getUrl('*/*/edit', array('id' => $row->getId()));
    }
    
    protected function _filterStoreCondition($collection, $column)
    {
        if (!$value = $column->getFilter()->getValue()) return;
        $collection->getSelect()->where('find_in_set(?, store_id)', $value);
    }
}