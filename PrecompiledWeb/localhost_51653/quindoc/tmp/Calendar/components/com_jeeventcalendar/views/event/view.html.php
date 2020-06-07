<?php
/**
* @package   JE Event Calendar
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
* Visit : http://www.joomlaextensions.co.in/
**/ 

defined('_JEXEC') or die ('restricted access');
jimport('joomla.application.component.view');
class eventViewevent extends JViewLegacy
{ 
	function display ($tpl=null)
	{ 
		$post = JRequest::get ( 'post' );
		 $mainframe	= JFactory::getApplication();
		$option	= JRequest::getVar('option', 'com_jeeventcalendar','request','string');
		$event_id	= JRequest::getVar('event_id','','request','int');
		
		
		if($event_id!="")
		{
			$tpl="preview"; 
		}
		 
		$this->assignRef('lists',	$lists);
		parent::display($tpl);

  	}

}