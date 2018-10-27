<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');


class categoryModelcategory extends JModelLegacy
{
	var $_data = null;
	var $_total = null;
	var $_pagination = null;
	var $_table_prefix = null;
	function __construct()
	{
		parent::__construct();


		global $context;        
		$mainframe	= JFactory::getApplication();$context='category';
	  	$this->_table_prefix = '#__jevent_';			
		$limit			= $mainframe->getUserStateFromRequest( $context.'limit', 'limit', $mainframe->getCfg('list_limit'), 0);
		$limitstart = $mainframe->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0 );
		
		$event     = $mainframe->getUserStateFromRequest( $context.'category','category',0);
		$filter     = $mainframe->getUserStateFromRequest( $context.'filter','filter',0);
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
		$this->setState('category', $event);
		$this->setState('filter', $filter);

	}
	function getData()
	{		
		if (empty($this->_data))
		{
		 $query = $this->_buildQuery();
			$this->_data = $this->_getList($query, $this->getState('limitstart'), $this->getState('limit'));
		}

		return $this->_data;
}
	function getTotal()
	{
		if (empty($this->_total))
		{
			$query = $this->_buildQuery();
			$this->_total = $this->_getListCount($query);
		}

		return $this->_total;
	}
	function getPagination()
	{
		if (empty($this->_pagination))
		{
			jimport('joomla.html.pagination');
			$this->_pagination = new JPagination( $this->getTotal(), $this->getState('limitstart'), $this->getState('limit') );
		}
 $this->_pagination;
		return $this->_pagination;
	}
  	
	function _buildQuery()
	{
		$where = "";    
	    
	    
	    
		$orderby	= $this->_buildContentOrderBy();
		
	 $query = ' SELECT * '
			. ' FROM '.$this->_table_prefix.'cal_category WHERE 1=1 '; 

		return $query;
	}
	
	function _buildContentOrderBy()
	{
		global $context;        
		$mainframe	= JFactory::getApplication();$filter_order     = $mainframe->getUserStateFromRequest( $context.'filter_order',      'filter_order', 	  'id' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',  'filter_order_Dir', '' );		
					
		$orderby 	= ' ORDER BY '.$filter_order.' '.$filter_order_Dir;			
		 		
		return $orderby;
	}

}	

