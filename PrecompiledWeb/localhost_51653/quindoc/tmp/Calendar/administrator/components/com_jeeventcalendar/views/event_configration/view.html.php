<?php
/**
* @package   JE Mediaplayer 
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport( 'joomla.application.component.view' );


class event_configrationViewevent_configration extends JViewLegacy 
{
	function display($tpl = null)
	{		
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

		$db = jFactory::getDBO();
		
		JToolBarHelper::title(   JText::_( 'EVENT_CONFIGRATION_DETAIL' ));
		
		$option = JRequest::getVar('option','','request','string');
		
		$document = & JFactory::getDocument();
		
		$document->setTitle( JText::_('EVENT_CONFIGRATION_DETAIL') );
		
	 	$uri =& JFactory::getURI();
		
		$this->setLayout('default');

		$lists = array();

		$detail	=& $this->get('data'); 

		$isNew = ($detail->id < 1);

		$text = $isNew ? JText::_( 'NEW' ) : JText::_( 'EDIT' );
		
	//	JToolBarHelper::title(   JText::_( 'category' ).': <small><small>[ ' . $text.' ]</small></small>'  );
		
		JToolBarHelper::save();
		
		if ($isNew)  {
			JToolBarHelper::cancel();
		} else {
		
			JToolBarHelper::cancel( 'cancel', 'Close' );
		}
		
		$pattern = array();
		$pattern[]   = JHTML::_('select.option', '0"selected"',JText::_('SELECT'));
		$pattern[]   = JHTML::_('select.option', 'pattern1', JText::_('PATTERN_1'));
		$pattern[]   = JHTML::_('select.option', 'pattern2', JText::_('PATTERN_2'));
		$pattern[]   = JHTML::_('select.option', 'pattern3', JText::_('PATTERN_3'));
		$pattern[]   = JHTML::_('select.option', 'pattern4', JText::_('PATTERN_4'));
		$pattern[]   = JHTML::_('select.option', 'pattern5', JText::_('PATTERN_5'));
		
		 
 		$lists['pattern'] = JHTML::_('select.genericlist',$pattern,'pattern','class="inputbox" size="1"','value','text',$detail->pattern);
		$auto_op1 = array();
		$auto_op1[]   	= JHTML::_('select.option', '1',JText::_('YES'));
		$auto_op1[]   	= JHTML::_('select.option', '0', JText::_('NO'));
		$lists['iscreate'] = JHTML::_('select.genericlist',$auto_op1,'iscreate','class="inputbox" size="1" ','value','text' ,$detail->iscreate); 
		 $lists['title'] = $detail->title;
		 $lists['head1'] = $detail->head1;
		 $lists['head2'] = $detail->head2;
		 $lists['head3'] = $detail->head3;
		 $lists['head4'] = $detail->head4;
		  $auto_op = array();
		$auto_op[]   	= JHTML::_('select.option', '1',JText::_('YES'));
		$auto_op[]   	= JHTML::_('select.option', '0', JText::_('NO'));
		$lists['autopub'] = JHTML::_('select.genericlist',$auto_op,'autopub','class="inputbox" size="1" ','value','text' ,$detail->autopub); 
		$this->assignRef('lists',		$lists);
		$this->assignRef('detail',		$detail);
		$this->assignRef('request_url',	$uri->toString());

		parent::display($tpl);
	}
}
?>