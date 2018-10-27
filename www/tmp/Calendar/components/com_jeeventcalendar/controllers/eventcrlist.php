<?php
 /**

* @package   JE Ajax Event Calendar

* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.

* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php

* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com

* Visit : http://www.joomlaextensions.co.in/

**/ 

defined ('_JEXEC') or die ('Restricted access');

 jimport( 'joomla.application.component.controller' );
 
class eventcrlistController extends JControllerForm 
{
	function __construct( $default = array())
	{
		parent::__construct( $default );
		$this->_table_prefix = '#__jevent_';
	}	
	function cancel()
	{
		$this->setRedirect( 'index.php' );
	}
	function display() {
		$user = clone(JFactory::getUser());
		// ============================= Check wether user login or not ============================================ //		
		if($user->id!='' )
			parent::display();
		else {
			$msg = JText::_ ( 'PLEASE_LOGIN_TO_VIEW_THIS_PAGE' );
			$this->setRedirect ( 'index.php?option=com_user&view=login', $msg );
		}
		// ========================================================================================================= //
	}
	
	function delete($cid = array())
	{
		$cids = JRequest::getVar ( 'cid', array (0 ), '', 'array' );
		$db= & JFactory :: getDBO();
		$option = JRequest::getVar('option','','','string');
		
		$query = 'DELETE FROM '.$this->_table_prefix.'event WHERE id IN ( '.$cids[0].' )';
		$db->setQuery($query);
		$db->query();
	// ================================ Delete the Record from the dynemic field ===================================== // 	
		$query1 = 'DELETE FROM '.$this->_table_prefix.'fields_data WHERE hid IN ( '.$cids[0].' )';
		$db->setQuery($query1);
		$db->query();
	// ============================================================================================================== //	
		$msg=JText::_( 'EVENT_DELETED_SUCCESSFULLY' );
		$this->setRedirect ( 'index.php?option=' . $option . '&view=eventcrlist', $msg );
		
	}
}	

?>