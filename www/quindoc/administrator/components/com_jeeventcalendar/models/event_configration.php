<?php
/**
* @package   JE Mediaplayer 
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

 jimport('joomla.filesystem.file');

class event_configrationModelevent_configration extends JModelLegacy
{
	var $_id = null;
	var $_data = null;
	var $_table_prefix = null;

	function __construct()
	{
		parent::__construct();

		$this->_table_prefix = '#__jevent_';		
	  
		$array = JRequest::getVar('cid',  0, '', 'array');
		
		$this->setId((int)$array[0]);
		
	}
	function setId($id)
	{
		$this->_id		= $id;
		$this->_data	= null;
	}

	function &getData()
	{
		if ($this->_loadData())
		{
			
		}else  $this->_initData();

	   	return $this->_data;
	}
	
	function _loadData()
	{
		if (empty($this->_data))
		{
			$query = 'SELECT * FROM '.$this->_table_prefix.'event_configration WHERE id = 1 ';
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}

	
	function _initData()
	{
		if (empty($this->_data))
		{
			$detail = new stdClass();
			$detail->id			= 0;
			//$detail->player_width			= 0;
//			$detail->player_height	= 0;
//			$detail->thumb_width		= 0;
			$detail->pattern	= null;
			 $detail->iscreate	= null;
			 $detail->title	= null;
			 $detail->head1	= null;
			 $detail->head2	= null;
			 $detail->head3	= null;
			 $detail->head4	= null;
			 $detail->autopub	= null;
			$this->_data		 		= $detail;
			
			return (boolean) $this->_data;
		}
		
		return true;
	}
  	function store($data)
	{	
 
		$row =& $this->getTable();
		
		
		$option = JRequest::getVar('option');
		 
			 
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		 
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return true;
	}

 
 
}
?>