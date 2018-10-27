<?php
    
	defined ('_JEXEC') or die ('Restricted access');
	
	//error_reporting(0); 
    $controller = JRequest::getVar('view','event' );
    $task = JRequest::getVar('task','' );
	if(!defined('DS')){
   define('DS',DIRECTORY_SEPARATOR);
}

		if($controller=="about")
	{
	JToolBarHelper::title(   JText::_( 'About us' ) ); 
	require_once (JPATH_COMPONENT.DS.'readme.html');
	require_once (JPATH_COMPONENT.DS.'controller.php');
	}
	else {
   
    
    require_once (JPATH_COMPONENT.DS.'controller.php');
    require_once (JPATH_COMPONENT.DS.'controllers'.DS.$controller.'.php');

    $classname  = $controller.'controller';

    $controller = new $classname( array('default_task' => 'display') );

    $controller->execute( JRequest::getVar('task' ));
	    
    $controller->redirect();
    }
?>