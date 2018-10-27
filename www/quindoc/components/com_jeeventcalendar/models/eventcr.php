<?php

/**
* @package   JE Event Calendar
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
* Visit : http://www.joomlaextensions.co.in/
**/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class eventcrModeleventcr extends JModelLegacy
{
	var $_data = null;
	var $_total = null;
	var $_pagination = null;
	var $_table_prefix = null;
	function __construct()
	{
		parent::__construct();
		$this->_table_prefix = '#__jevent_';
	}
	
	function getFormdata()
	{
		$query = "SELECT id as value, ename as text FROM  ".$this->_table_prefix."cal_category ";
		$this->_formdata = $this->_getList( $query );
		return $this->_formdata;
	}
	function iscreate()
	{
		$db = JFactory::getDbo();
		$sql="SELECT iscreate FROM  #__jevent_event_configration";
		$db->setQuery($sql);
		$row_data=$db->loadObject();
		return $row_data;
	}
		

}	

