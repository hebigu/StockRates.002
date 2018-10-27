<?php
/**
* @package   JE Form Creation 
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class Tablecategory_detail extends JTable
{
	var $id = null;
	var $ename = null;
	var $edesc = null;
	var $published = null;
		
	
	
	function Tablecategory_detail(& $db) 
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
