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





class categoryViewcategory extends JViewLegacy 

{ 

      
   	function display ($tpl=null)

   	{ 
	
		 $mainframe	= JFactory::getApplication();
		$document = & JFactory::getDocument();
		$document->setTitle( JText::_('CATEGORY') );
		JToolBarHelper::title(   JText::_( 'CATEGORY_MANAGEMENT' ));
		
		$post = JRequest::get ( 'post' );
   		
		$option	= JRequest::getVar('option', 'com_jeeventcalendar');
		$event_id	= JRequest::getVar('event_id','');
	$lists			= & $this->get( 'Data');
	
		JToolBarHelper::addNew();
 		JToolBarHelper::editList();
		JToolBarHelper::deleteList();		
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
	$pagination = & $this->get( 'Pagination' );
		$this->assignRef('lists',	$lists);
		 $this->assignRef('pagination',	$pagination);
				parent::display($tpl);

  	}

}