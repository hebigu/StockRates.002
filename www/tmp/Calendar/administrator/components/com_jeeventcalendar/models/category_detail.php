<?php
/**
* @package   JE Form Creation 
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');


class category_detailModelcategory_detail extends JModelLegacy
{
	var $_id = null;
	var $_data = null;
	var $_table_prefix = null;
	var $_fielddata = null;
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
			$query = 'SELECT * FROM '.$this->_table_prefix.'cal_category  WHERE id = '. $this->_id;
			$this->_db->setQuery($query);
			$this->_data = $this->_db->loadObject();
			return (boolean) $this->_data;
		}
		return true;
	}
	/*function field_data()
	{
		 
			$query = 'SELECT * FROM '.$this->_table_prefix.'fields_value  WHERE field_id = '. $this->_id;
			$this->_db->setQuery( $query );
			 $this->_fielddata = $this->_db->loadObjectList();
			return $this->_fielddata;		 
	}
	*/
	
	function _initData()
	{
		if (empty($this->_data))
		{
			$detail = new stdClass();
			$detail->id				= 0;
			$detail->ename			= null;
			$detail->edesc				= null;
			$detail->published				= null;
			$this->_data		 			= $detail;
			return (boolean) $this->_data;
		}
		return true;
	}
  	function store($data)
	{
		$row =& $this->getTable();
		
		if (!$row->bind($data)) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}
		if (!$row->store()) {
			$this->setError($this->_db->getErrorMsg());
			return false;
		}

		return $row;
	}
	
	/*function field_delete($id,$field)
	{
		$id = implode( ',', $id );
		$query = 'DELETE FROM '.$this->_table_prefix.'fields_value WHERE '.$field.' IN ( '.$id.' )';
		
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
	}*/
	
	function delete($cid = array())
	{
		if (count( $cid ))
		{
			$cids = implode( ',', $cid );
			
			$query = 'DELETE FROM '.$this->_table_prefix.'cal_category WHERE id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			if(!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
	}

	function publish($cid = array(), $publish = 1)
	{		
		if (count( $cid ))
		{
			$cids = implode( ',', $cid );
			
			$query = 'UPDATE '.$this->_table_prefix.'cal_category'
				. ' SET published = ' . intval( $publish )
				. ' WHERE id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			if (!$this->_db->query()) {
				$this->setError($this->_db->getErrorMsg());
				return false;
			}
		}

		return true;
	}
	 
	
		
}

?>
