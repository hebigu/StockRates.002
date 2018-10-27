<?php
	/**
	* @package   JE Event Calendar
	* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
	* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
	* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
	* Visit : http://www.joomlaextensions.co.in/
	**/ 
	defined ('_JEXEC') or die ('Restricted access');
	$controller = JRequest::getVar('view','event','request','string' );
	$userviews = array('event','eventcr');
	$flag = 0;
	if(in_array($controller,$userviews)) {
		$flag=1;
	}
		
	if($flag==1) {
		$task = JRequest::getVar('task','','request','string' );
		require_once (JPATH_COMPONENT.'/'.'controllers'.'/'.$controller.'.php');
		$classname  = $controller.'controller';
		$controller = new $classname( array('default_task' => 'display') );
		$controller->execute( JRequest::getVar('task'));
		$controller->redirect();
	}
	else
	{
		 $mainframe	= JFactory::getApplication();
		$Itemid = JRequest::getVar('Itemid','','request','int');
		$option = JRequest::getVar('option','','request','string');
		$mainframe->redirect ( 'index.php?option=' . $option . '&view=event&Itemid='.$Itemid);
	}
?>