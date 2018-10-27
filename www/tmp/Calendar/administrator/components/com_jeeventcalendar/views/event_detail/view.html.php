<?php

defined( '_JEXEC' ) or die( 'Restricted access' );


jimport( 'joomla.application.component.view' );

class event_detailViewevent_detail extends JViewLegacy 
{
	function display($tpl = null)
	{
	//echo "dds";exit;
		$document = & JFactory::getDocument();
		$document->setTitle( JText::_('EVENT_DETAIL') );

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
			$formdata	=& $this->get('formdata');				
		$usr	=& $this->get('users');
	 	
		$isNew		= ($detail->id < 1);

		$text = $isNew ? JText::_( 'NEW' ) : JText::_( 'EDIT' );
		JToolBarHelper::title(   JText::_( 'event' ).': <small><small>[ ' . $text.' ]</small></small>' );
	
		 $sel_formdata = array();
		$sel_formdata[0]->value="0";
		$sel_formdata[0]->text=JText::_('SELECT_FORM');
		$formdata=@array_merge($sel_formdata,$formdata);
		JToolBarHelper::save();
		
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
		
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		 
		$options[] = JHtml::_('select.option', '0', JText::sprintf('No'));
		$options[] = JHtml::_('select.option', '1', JText::sprintf('Yes')); 
		$lists['published'] 	= JHTML::_('select.genericlist',$options,  'published', 'class="inputtext" ', 'value', 'text', $detail->published );
		$lists['formdata'] 	= JHTML::_('select.genericlist',$formdata,  'category', 'class="inputtext" ', 'value', 'text', $detail->id );
		$this->assignRef('lists',		$lists);
		//$this->assignRef('invoice',		$invoice);
		$this->assignRef('usr',		$usr);
		$this->assignRef('detail',		$detail);
		$this->assignRef('request_url',	$uri->toString());

		parent::display($tpl);
	}
	
}
?>