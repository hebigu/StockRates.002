<?php

/**
* @package   JE Event Calendar
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
* Visit : http://www.joomlaextensions.co.in/
**/

defined ('_JEXEC') or die ('Restricted access');

jimport( 'joomla.application.component.controller' );
 
class eventcrController extends JControllerForm 
{
	function __construct( $default = array())
	{
		parent::__construct( $default );
	}
		
	function cancel()
	{
		$this->setRedirect( 'index.php' );
	}
	
	function display() {
		$user = clone(JFactory::getuser());
		if($user->id!=0)
			parent::display();
		else {
			 $mainframe	= JFactory::getApplication();
			$Itemid = JRequest::getVar('Itemid','','request','int');
			$option = JRequest::getVar('option','','request','string');
			$msg = JText::_('Please login to view this page');
			$mainframe->redirect ( 'index.php?option=' . $option . '&view=event&Itemid='.$Itemid,$msg);
		}
	}
	
	function save()
	{
		 $mainframe	= JFactory::getApplication();
		$user = clone(JFactory::getuser());
		$db= & JFactory :: getDBO();
		$post = JRequest::get ( 'post' );
		$option = JRequest::getVar('option','','request','string'); 
		$sql="SELECT autopub FROM  #__jevent_event_configration";
		$db->setQuery($sql);
		$row_data=$db->loadObject();
		if($row_data->autopub==1)
			$pub=1;
		else
			$pub=0;
			
		$userid = $user->id;	
				
	 	$sql="insert into #__jevent_event values('','".$post['frname']."',".$post['category'].",'".$userid."','".$post['desc']."','".$post['start_date']."','".$post['end_date']."',".$pub.",'".$post['bgcolor']."','".$post['txtcolor']."')";
		$db->setQuery($sql);
		$db->query();
		$msg=JText::_( 'SUCCESSFULY_SUBMITED' );
		$return	= 'index.php?option=com_jeeventcalendar';
		$mainframe->redirect( $return,$msg);
	}
	
	
		
}

?>
