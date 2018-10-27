<?php

defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
JHTMLBehavior::modal();
$uri =& JURI::getInstance();
$url= $uri->root();
$editor =& JFactory::getEditor();
JHTML::_('behavior.calendar');
$option = JRequest::getVar('option');
 
?>

<script language="javascript" type="text/javascript">
	Joomla.submitform =function submitbutton(pressbutton) {
		var form = document.adminForm;
		if (pressbutton == 'cancel') {
			submitform( pressbutton );
			return;
		}
	
			submitform( pressbutton );
		
	}
</script>
<form action="index.php" method="post" name="adminForm" id="adminForm">
<div class="col50">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'DETAILS' ); ?></legend>

		<table class="admintable">
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'CATEGORY_TITLE' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="ename" id="ename" size="32" maxlength="250" value="<?php echo $this->detail->ename;?>" />				
			</td>
		</tr>
	
	
				<tr valign="top">
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'DESCRIPTION' ); ?>:
				</label>
			</td>
			<td>
				<?php $editor =& JFactory::getEditor(); ?>
			<?php echo $editor->display("edesc",$this->detail->edesc,600,500,'100','20','0');	?>				
			</td>
		</tr>
		
		<tr>
			<td width="100" align="right" class="key" valign="top">
				<label for="name">
					<?php echo JText::_( 'PUBLISHED' ); ?>:
				</label>
			</td>
			<td>
				<?php echo $this->lists['published']; ?> 
			</td>
		</tr>

	
	</table>
	</fieldset>
</div>

 	
 
<div class="clr"></div>

<input type="hidden" name="cid[]" value="<?php echo $this->detail->id; ?>" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="view" value="category_detail" />
<input type="hidden" name="option" value="<?php echo $option;?>" />
</form>