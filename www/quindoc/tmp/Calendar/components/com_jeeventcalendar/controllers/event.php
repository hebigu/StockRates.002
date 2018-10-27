<?php
/*
* @package   JE Event Calendar
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
* Visit : http://www.joomlaextensions.co.in/
**/ 

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.controller' );

class eventController extends JControllerForm  
{ 
	function __construct( $default = array())
	{
		parent::__construct( $default );
	}	

	function cancel()
	{
		$option = JRequest::getVar('option','','request','string');
		$this->setRedirect ( 'index.php?option=' . $option  );
		return true;
	}
 
	function display() {
		parent::display();
	}
}