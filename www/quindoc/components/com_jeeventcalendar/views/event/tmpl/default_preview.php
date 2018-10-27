<?php	
/**
* @package   JE Event Calendar
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
* Visit : http://www.joomlaextensions.co.in/
**/ 

defined ('_JEXEC') or die ('restricted access');
$uri =& JURI::getInstance();
$url= $uri->root();
$document = &JFactory::getDocument();
$my =& JFactory::getUser();
$month = JRequest::getVar('month',date("m"),'request','string');
$year = JRequest::getVar('year',date("Y"),'request','string');
$event_id	= JRequest::getVar('event_id','','request','string');
$model = $this->getModel ( 'event' );
$data=$model->event_desc($event_id);
$option = JRequest::getVar('option','','request','string');
$document->addStyleSheet ( 'components/'.$option.'/assets/css/style.css' ); 
$document->addStyleSheet ( 'components/'.$option.'/assets/css/lightbox.css' );
$document->addScript('components/'.$option.'/assets/js/jquery.min.js' );
$document->addScript('components/'.$option.'/assets/js/jquery.colorbox.js' );
$document->addScript('components/'.$option.'/assets/js/lightbox.js' );

?>  

	
<table width="100%"  cellpadding="10" cellspacing="10" id="one-column-emphasis" >
<colgroup>
    	<col class="oce-first" />
</colgroup>
<tr valign="top">
    <th width="27%"  ><?php echo JText::_( 'CATEGORY' );?></th>
    <td width="73%"><?php echo $data[0]->category;?></td>
</tr>
<tr valign="top">
     <th ><?php echo JText::_( 'EVENT_TITLE' );?></th>
    <td><?php echo $data[0]->title;?></td>
</tr>
<tr valign="top">
    <th width="27%"  ><?php echo JText::_( 'EVENT_START_DATE' );?></th>
    <td width="73%"><?php echo $data[0]->start_date;?></td>
</tr>
<tr valign="top">
    <th  ><?php echo JText::_( 'EVENT_END_DATE' );?></th>
    <td><?php echo $data[0]->end_date;?></td>
</tr>
<tr valign="top">
	<th  ><?php echo JText::_( 'EVENT_DESC' );?></th>
	<td ><?php echo $data[0]->desc;?></td>
</tr>
</table>
<?php //exit; ?>