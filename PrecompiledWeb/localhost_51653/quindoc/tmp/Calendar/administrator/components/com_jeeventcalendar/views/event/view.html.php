<?php

defined( '_JEXEC' ) or die( 'Restricted access' );


jimport( 'joomla.application.component.view' );
 
class eventViewevent extends JViewLegacy 
{
	function __construct( $config = array())
	{
		 parent::__construct( $config );
	}
    
	function display($tpl = null)
	{	
		global $context;        
		$mainframe	= JFactory::getApplication();$document = & JFactory::getDocument();
		$document->setTitle( JText::_('EVENT') );
   		 
   		JToolBarHelper::title(   JText::_( 'EVENT_MANAGMENT' ) );   		
   		
 		JToolBarHelper::addNew();
 		JToolBarHelper::editList();
		JToolBarHelper::deleteList();		
		JToolBarHelper::publishList();
		JToolBarHelper::unpublishList();
	   	
	   	
		$uri	=& JFactory::getURI();
		
		$filter_order     = $mainframe->getUserStateFromRequest( $context.'filter_order',      'filter_order', 	  'event_id' );
		$filter_order_Dir = $mainframe->getUserStateFromRequest( $context.'filter_order_Dir',  'filter_order_Dir', '' );
		
		$event = $mainframe->getUserStateFromRequest( $context.'event','event',0 );

		$lists['order'] 		= $filter_order;  
		$lists['order_Dir'] = $filter_order_Dir;
		$event			= & $this->get( 'Data');
		$total			= & $this->get( 'Total');
		$pagination = & $this->get( 'Pagination' );
	
	 	
	
     $this->assignRef('lists',		$lists);    
  	$this->assignRef('event',		$event); 		
    $this->assignRef('pagination',	$pagination);
    $this->assignRef('request_url',	$uri->toString());    	
    	parent::display($tpl);
  }
}
?>
