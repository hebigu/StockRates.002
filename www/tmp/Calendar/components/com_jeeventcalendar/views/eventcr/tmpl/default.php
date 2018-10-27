<?php 
/**
* @package   JE Event Calendar
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
* Visit : http://www.joomlaextensions.co.in/
**/

defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.calendar');

 $mainframe	= JFactory::getApplication();
$option = JRequest::getVar('option','','request','string');
$filter = JRequest::getVar('filter'); 
$uri =& JURI::getInstance();
$url= $uri->root();
$db=& JFactory::getDBO();
$model12 = $this->getModel ( 'eventcr' );
$greq=$model12->iscreate();
		
if($greq->iscreate==0)
{
	$msg=JText::_( 'NOT_AUTHORIZED_TO_ADD_EVENT' );
	$return	= 'index.php?option=com_jeeventcalendar';
	$mainframe->redirect( $return,$msg);
}

?>


<script language="javascript" src="">
</script>
<h4><?php echo JText::_('CREATE_EVENT');?></h4>
<form action="index.php" method="post" name="adminForm" enctype="multipart/form-data" onsubmit="return validatefrm(adminForm)" >
<table class="admintable" border="0" cellpadding="5" cellspacing="0" width="100%" >
	<tr>
		<td align="right"><label for="name"><label for="name"><?php echo JText::_('EVENT_TITLE');?> </label></td>
		<td><input type="text" name="frname" id="frname" /></td>
	</tr>
	<tr>
		<td align="right"><label for="name"><?php echo JText::_('CATEGORY');?> </label></td>
		<td><?php echo $this->lists['formdata']; ?> </td>
	</tr>
	<tr>
		<td align="right" valign="top"><label for="name"><?php echo JText::_('DESCRIPTION');?> </label></td>
		<td><?php $editor =& JFactory::getEditor(); ?><?php echo $editor->display("desc",'',400,300,'100','20','0'); ?></td>
	</tr>
	<tr>
		<td width="100" align="right">
			<label for="name"><?php echo JText::_( 'START_DATE' ); ?></label>
		</td>
		<td>
      		<input type="text" name="start_date" id="start_date" value=""/>
			<img class="calendar" src="templates/system/images/calendar.png" alt="calendar" id="intro_date_img" />
			<script type="text/javascript">
				Calendar.setup(
				  {
					inputField  : "start_date",         // ID of the input field
					ifFormat    : "%Y-%m-%d",    // the date format
					button      : "intro_date_img"       // ID of the button
				  }
				);
			</script>
		</td>
   	</tr>
	<tr>
		<td width="100" align="right">
			<label for="name"><?php echo JText::_( 'END_DATE' ); ?></label>
		</td>
		<td>
      		<input type="text" name="end_date" id="end_date" value=""/>
			<img class="calendar" src="templates/system/images/calendar.png" alt="calendar" id="intro_date_img1" />
			<script type="text/javascript">
				Calendar.setup(
				  {
					inputField  : "end_date",         // ID of the input field
					ifFormat    : "%Y-%m-%d",    // the date format
					button      : "intro_date_img1"       // ID of the button
				  }
				);
			</script>
		</td>
   </tr>
   <tr>
			<td width="100" align="right" class="key" valign="top">
				<label for="name"><?php echo JText::_( 'Background Color' ); ?>:</label>
			</td>
			<td>
				<input type="text" name="bgcolor" maxlength="250" id="colorpickerField1" value="" /> 
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key" valign="top" >
				<label for="name"><?php echo JText::_( 'Text Color' ); ?>:</label>
			</td>
			<td>
				<input type="text" maxlength="250" name="txtcolor" id="colorpickerField2" value="" /> 
			</td>
		</tr>
   <tr>
		<td align="right">&nbsp;</td>
		<td><input type="submit" name="submit" value="Submit" /> </td>
	</tr>
   </table>


 <input type="hidden" name="view" value="eventcr" />
 <input type="hidden" name="task" value="save" />
 <input type="hidden" name="option" value="<?php echo $option;?>" />
</form>

