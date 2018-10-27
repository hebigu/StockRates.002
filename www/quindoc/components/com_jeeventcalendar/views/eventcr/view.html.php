<?php

/**
* @package   JE Event Calendar
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
* Visit : http://www.joomlaextensions.co.in/
**/

defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );
 
class eventcrVieweventcr extends JViewLegacy
{
	function __construct( $config = array())
	{
		 parent::__construct( $config );
	}
    
	function display($tpl = null)
	{
		 $mainframe	= JFactory::getApplication();
		$document = & JFactory::getDocument();
		$option = JRequest::getVar('option','','request','string');
		$params = &$mainframe->getParams();
		$document->setTitle( $params->get( 'page_title' ) );
		
		
		// ============= Color picker field ===============================================================
		$document->addScript('components/'.$option.'/assets/color_picker/js/jquery.js');
		$document->addScript('components/'.$option.'/assets/color_picker/js/colorpicker.js');
		$document->addScript('components/'.$option.'/assets/color_picker/js/eye.js');
		$document->addScript('components/'.$option.'/assets/color_picker/js/utils.js');
		$document->addScript('components/'.$option.'/assets/color_picker/js/layout.js?ver=1.0.2');
		$document->addScript('components/'.$option.'/assets/js/validation.js');
		$document->addStyleSheet('components/'.$option.'/assets/color_picker/css/colorpicker.css');
		// ================================================================================================
		
		
		$uri 		=& JFactory::getURI();
		$this->setLayout('default');
		$formdata	=& $this->get('formdata');
		$lists = array();
		$sel_formdata = array();
		$sel_formdata[0]->value="0";
		$sel_formdata[0]->text=JText::_('SELECT_FORM');
		$formdata=@array_merge($sel_formdata,$formdata);
		
		$lists['formdata'] 	= JHTML::_('select.genericlist',$formdata,  'category', 'class="inputtext" ', 'value', 'text', '');
		$this->assignRef('lists',$lists);
	

		parent::display($tpl);
	}
}
?>

