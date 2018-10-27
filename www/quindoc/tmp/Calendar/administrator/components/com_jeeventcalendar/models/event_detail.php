<?php
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');


class event_detailModelevent_detail extends JModelLegacy
{
	var $_id = null;
	var $_data = null;
	var $_region = null;
	var $_table_prefix = null;
	var $_copydata	=	null;

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
			 $query = 'SELECT * FROM '.$this->_table_prefix.'event WHERE id = '. $this->_id;
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
			$detail->id					= 0;
			$detail->title				= null;
			$detail->category			= 0;
			$detail->usr				= null;
			$detail->desc				= null;
			$detail->start_date			= null;
			$detail->end_date			= null;
			$detail->published			= 1;
			$detail->bgcolor			= null;
			$detail->txtcolor			= null;
		
			$this->_data		 				= $detail;
			return (boolean) $this->_data;
		}
		return true;
	}
  	function store($data)
	{ 
		
		$row =& $this->getTable('event');
		
		
		 
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

	function delete($cid = array())
	{
		if (count( $cid ))
		{
			$cids = implode( ',', $cid );
			
			$query = 'DELETE FROM '.$this->_table_prefix.'event WHERE id IN ( '.$cids.' )';
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
			
			$query = 'UPDATE '.$this->_table_prefix.'event'
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
	/*function copy($cid = array()){
				
		if (count( $cid ))
		{
			$cids = implode( ',', $cid );
			
			$query = 'SELECT * FROM '.$this->_table_prefix.'textlibrary WHERE textlibrary_id IN ( '.$cids.' )';
			$this->_db->setQuery( $query );
			$this->_copydata = $this->_db->loadObjectList();
		}
		foreach ($this->_copydata as $cdata){
			
			$post['textlibrary_id'] = 0;
			$post['text_name'] = 'Copy Of '.$cdata->text_name;
			$post['text_desc'] = $cdata->text_desc;
			$post['text_field'] = $cdata->text_field;
			$post['country'] = $cdata->country;
			$post['published'] = $cdata->published;
						
			textlibrary_detailModeltextlibrary_detail::store($post);	
		}
		
		return true;
		
	}*/
	function getFormdata()
	{
		$query = "SELECT id as value, ename as text FROM  ".$this->_table_prefix."cal_category ";
		$this->_formdata = $this->_getList( $query );
		
		return $this->_formdata;
	}
	function getUsers()
	{
		$query = "SELECT id as value,name as text FROM  #__users";
		$this->_formdata = $this->_getList( $query );
		
		return $this->_formdata;
	}
	function getUdata()
	{
	    $cid = JRequest::getVar ( 'cid');
		$db= & JFactory :: getDBO();
		$query = "SELECT usr FROM ".$this->_table_prefix."event where id=".$cid[0];
		$db->setQuery($query);
		$db->loadObjectlist();
		return $db->loadObject();
	}
		
}

?>
