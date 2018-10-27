<?php
/**
* @package   JE Section Finder 
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/
defined( '_JEXEC' ) or die( 'Restricted access' );


jimport( 'joomla.application.component.view' );
 
class homeViewhome extends JViewLegacy 
{
	function __construct( $config = array())
	{
		 parent::__construct( $config );
	}
    
	function display($tpl = null)
	{	
		
		global $context;        
		$mainframe	= JFactory::getApplication();$document = & JFactory::getDocument();
		$document->setTitle( JText::_('Home') );
   		 
   		JToolBarHelper::title(   JText::_( 'HOME_MANAGEMENT' ) );   		
   			jimport('joomla.html.pane');
		
   		//$pane   	= & JPane::getInstance('sliders');
   		
 		//JToolBarHelper::addNewX();
// 		JToolBarHelper::editListX();
//		JToolBarHelper::deleteList();		
//		JToolBarHelper::publishList();
//		JToolBarHelper::unpublishList();
	   
	   	
		$uri	=& JFactory::getURI();
		
	   
		
		
		
		
	//$this->assignRef('pane'			, $pane);
    $this->assignRef('lists',		$lists);    
  	  		
		
    $this->assignRef('request_url',	$uri->toString());    	
    	parent::display($tpl);
  }
  function quickiconButton( $link, $image, $text, $modal = 0 )
	{
		//initialise variables
		$lang 		= & JFactory::getLanguage();
  		?>

		<div style="float:<?php echo ($lang->isRTL()) ? 'right' : 'left'; ?>;">
			<div class="icon">
				<?php
				if ($modal == 1) {
					JHTML::_('behavior.modal');
				?>
					<a href="<?php echo $link.'&amp;tmpl=component'; ?>" style="cursor:pointer" class="modal" rel="{handler: 'iframe', size: {x: 650, y: 400}}">
				<?php
				} else {
				?>
					<a href="<?php echo $link; ?>">
				<?php
				}

					echo JHTML::_('image', 'components/com_jeeventcalendar/assets/icon/'.$image, $text );
				?>
					<span><?php echo $text; ?></span>
				</a>
			</div>
		</div>
		<?php
	}
}
?>
