<?php

defined( '_JEXEC' ) or die( 'Restricted access' );


jimport( 'joomla.application.component.view' );

class category_detailViewcategory_detail extends JViewLegacy 
{
	function display($tpl = null)
	{
		
		$document = & JFactory::getDocument();
		$document->setTitle( JText::_('CATEGORY') );
		

		$uri 		=& JFactory::getURI();
		
		$option = JRequest::getVar('option','','request','string');
		//echo 'components/'.$option.'/assets/color_picker/js/jquery.js';
		//exit;
		$document->addScript('components/'.$option.'/assets/color_picker/js/jquery.js');
		$document->addScript('components/'.$option.'/assets/color_picker/js/colorpicker.js');
		$document->addScript('components/'.$option.'/assets/color_picker/js/eye.js');
		$document->addScript('components/'.$option.'/assets/color_picker/js/utils.js');
		$document->addScript('components/'.$option.'/assets/color_picker/js/layout.js?ver=1.0.2');
		
		$document->addStyleSheet ('components/'.$option.'/assets/colorpicker/css/colorpicker.css' ); 
		
		$document->addStyleSheet('components/'.$option.'/assets/color_picker/css/colorpicker.css');
		$document->addStyleSheet('components/'.$option.'/assets/color_picker/css/layout.css');
		
		$this->setLayout('default');

		$lists = array();

		$detail	=& $this->get('data');
						

		$isNew		= ($detail->id < 1);

		$text = $isNew ? JText::_( 'NEW' ) : JText::_( 'EDIT' );
		JToolBarHelper::title(   JText::_( 'CATEGORY' ).': <small><small>[ ' . $text.' ]</small></small>' );
	
		 
		JToolBarHelper::save();
		
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
		
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		 
		$options[] = JHtml::_('select.option', '0', JText::sprintf('No'));
		$options[] = JHtml::_('select.option', '1', JText::sprintf('Yes')); 
		$lists['published'] 	= JHTML::_('select.genericlist',$options,  'published', 'class="inputtext" ', 'value', 'text', $detail->published );
		
		$this->assignRef('lists',		$lists);
		//$this->assignRef('invoice',		$invoice);
		
		$this->assignRef('detail',		$detail);
		$this->assignRef('request_url',	$uri->toString());

		parent::display($tpl);
	}
	
}
?>