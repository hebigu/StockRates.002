<?php
/**
* @package   JE Mediaplayer 
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/
defined('_JEXEC') or die('Restricted access');
JHTML::_('behavior.tooltip');

$uri =& JURI::getInstance();
$url= $uri->root();
//jimport('joomla.html.pane');
$option = JRequest::getVar('option');
//$dest_song = JPATH_ROOT.DS.'components/'.$option.'/assets/songs/';
/*$dest_images = JPATH_ROOT.DS.'components/'.$option.'/assets/images/';
$dest_xml = JPATH_ROOT.DS.'components/'.$option.'/assets/xml/';

$permit_song=substr(sprintf('%o', fileperms($dest_song)), -4);

$permit_images=substr(sprintf('%o', fileperms($dest_images)), -4);
$permit_xml=substr(sprintf('%o', fileperms($dest_xml)), -4);*/

?> 
<script language="javascript" type="text/javascript">
	Joomla.submitform =function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
	
		if (form.title.value == ""){
			alert( "<?php echo JText::_( 'Please enter the title', true ); ?>" );
		} else {
			submitform( pressbutton );
		}
	}
</script>

<form action="<?php echo JRoute::_($this->request_url) ?>" method="post" name="adminForm" id="adminForm" enctype="multipart/form-data">



<div class="col50">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'DETAILS' ); ?></legend>

		<table class="admintable">
		
		<tr>
			<td width="100" align="right" class="key" style="display:none;">
				<label for="name">
					<?php echo JText::_( 'PATTERN' ); ?>:
				</label>
			</td>
			<td style="display:none;">
				 <?php echo $this->lists['pattern']; ?>
			</td>

		</tr>
		
		
		 <tr>
			<td width="100" align="right" class="key" >
				<label for="name">
					<?php echo JText::_( 'ADDFROMFRONT' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->lists['iscreate']; ?>
			</td>

		</tr>
		<tr>
			<td width="100" align="right" class="key" >
				<label for="name">
					<?php echo JText::_( 'EVENT_TITLE' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" name="title" id="title" value="<?php  echo $this->lists['title']; ?>" />
			</td></tr>
			<tr>
			<td width="100" align="right" class="key" >
				<label for="name">
					<?php echo JText::_( 'YEARCOLOR' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" name="head1" id="colorpickerField1" value="<?php  echo $this->lists['head1']; ?>" />
			</td></tr>
			<tr>
			<td width="100" align="right" class="key" >
				<label for="name">
					<?php echo JText::_( 'MONTHCOLOR' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" name="head2" id="colorpickerField1" value="<?php  echo $this->lists['head2']; ?>" />
			</td></tr>
			<tr>
			<td width="100" align="right" class="key" >
				<label for="name">
					<?php echo JText::_( 'DAYCOLOR' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" name="head3" id="colorpickerField1" value="<?php  echo $this->lists['head3']; ?>" />
			</td></tr>
			<tr>
			<td width="100" align="right" class="key" >
				<label for="name">
					<?php echo JText::_( 'CALBODYCOLOR' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" name="head4" id="colorpickerField1" value="<?php  echo $this->lists['head4']; ?>" />
			</td>

		</tr >
		 <tr>
			<td width="100" align="right" class="key" >
				<label for="name">
					<?php echo JText::_( 'AUTOPUBLISH' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->lists['autopub']; ?>
			</td>

		</tr>
		 
	</table>
	</fieldset>
	 
</div>

<div class="clr"></div>
<input type="hidden" name="id" value="<?php echo $this->detail->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="event_configration" />
</form>