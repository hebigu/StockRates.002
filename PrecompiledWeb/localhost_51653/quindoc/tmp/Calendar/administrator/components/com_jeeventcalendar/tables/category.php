s<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class Tableevent extends JTable
{
	var $id= null;
	var $ename = null;
	var $edesc = null;
	var $published = null;
	
	
	
		
	function Tablecategory(& $db) 
	{
	  $this->_table_prefix = '#__jevent_';
			
		parent::__construct($this->_table_prefix.'cal_category', 'id', $db);
	}

	function bind($array, $ignore = '')
	{
		if (key_exists( 'params', $array ) && is_array( $array['params'] )) {
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = $registry->toString();
		}

		return parent::bind($array, $ignore);
	}
	
}
?>
