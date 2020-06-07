<?php
/**
* @package   JE Mediaplayer 
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/
    
defined ( '_JEXEC' ) or die ( 'Restricted access' );

jimport ( 'joomla.application.component.controller' );

class event_configrationController extends JControllerForm {
	function __construct($default = array()) { 
		parent::__construct ( $default );
		$this->registerTask ( 'add', 'edit' );
	}
	function edit() 
	{
		JRequest::setVar ( 'view', 'event_configration' );
		JRequest::setVar ( 'layout', 'default' );
		JRequest::setVar ( 'hidemainmenu', 1 );
		
		$model = $this->getModel ( 'event_configration' );
		
		parent::display ();
	}
	function save() 
	{
		
		$post = JRequest::get ( 'post' );
	 
		$option = JRequest::getVar ('option');
		
		$model = $this->getModel ( 'event_configration' );
		
		if ($model->store ( $post )) {
			
			$msg = JText::_ ( 'EVENT_CONFIGRATION_DETAIL_SAVED' );
		
		} else {
			
			$msg = JText::_ ( 'ERROR_SAVING_EVENT_CONFIGRATION_DETAIL' );
		}
			 
		$this->setRedirect ( 'index.php?option=' . $option . '&view=event_configration', $msg );
	}
	 
 
	 
	function cancel() {
		
		$option = JRequest::getVar ('option');
		$msg = JText::_ ( 'EVENT_CONFIGRATION_DETAIL_EDITING_CANCELLED' );
		$this->setRedirect ( 'index.php?option='.$option.'&view=home',$msg );
	}
	 
	 
}
