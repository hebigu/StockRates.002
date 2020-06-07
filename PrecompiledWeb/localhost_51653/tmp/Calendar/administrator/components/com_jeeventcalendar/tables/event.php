s<?php

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class Tableevent extends JTable
{
	var $id= null;
	var $title = null;
	var $category = null;
	var $usr = null;
	var $desc = null;
	var $start_date = null;
	var $end_date = null;
	var $published = null;
	var $bgcolor = null;
	var $txtcolor = null;
	
	
		
	function Tableevent(& $db) 
	{
	  $this->_table_prefix = '#__jevent_';
			
		parent::__construct($this->_table_prefix.'event', 'id', $db);
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
