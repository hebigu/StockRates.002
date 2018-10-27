<?php

defined('_JEXEC') or die('Restricted access');

JHTML::_('behavior.tooltip');
JHTMLBehavior::modal();
$uri =& JURI::getInstance();
$url= $uri->root();
$editor =& JFactory::getEditor();
JHTML::_('behavior.calendar');
$model = $this->getModel ( 'event_detail' );

if($cid = JRequest::getVar ( 'cid')!=0)
{
$usr=$model->getUdata();
$user_id=explode('`',$usr->usr);
	
}

/*print_r($user_id);exit;*/
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
<form action="<?php echo JRoute::_($this->request_url) ?>" method="post" name="adminForm" id="adminForm">
<div class="col50">
	<fieldset class="adminform">
		<legend><?php echo JText::_( 'DETAILS' ); ?></legend>

		<table class="admintable">
		
		<tr>
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'EVENT_TITLE' ); ?>:
				</label>
			</td>
			<td>
				<input class="text_area" type="text" name="title" id="title" size="32" maxlength="250" value="<?php echo $this->detail->title;?>" />				
			</td>
		</tr>
			<tr>
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'CATEGORY' ); ?>:
				</label>
			</td>
			<td>
			<?php echo $this->lists['formdata']; ?> 				
			</td>
		</tr>
	
			<tr>
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'USERSELECT' );?>:
				</label>
			</td>
			<td>
					<select id="user" name="usr[]" multiple="multiple" size="6">
					<?php if($user_id[0]==0){?>
					<option value="0" selected="selected">ALL</option><?php }else
					{?>
					<option value="0">ALL</option><?php } ?>
		<?php $r=$this->usr;
	
			for($i=0;$i<count($r);$i++){if (in_array($r[$i]->value, $user_id)) {?>
			<option value="<?php echo $r[$i]->value;?>" selected="selected"><?php echo $r[$i]->text; ?></option><?php }else{?>
		<option value="<?php echo $r[$i]->value;?>"><?php echo $r[$i]->text; ?></option><?php } }?>
		</select>				
			</td>
		</tr>
		
		
	<tr>
			<td width="100" align="right" class="key" valign="top">
				<label for="name">
					<?php echo JText::_( 'START_DATE' ); ?>:
				</label>
			</td>
			
			<td>
      <input type="text" name="start_date" id="start_date" value="<?php echo $this->detail->start_date; ?>"/>
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
			<td width="100" align="right" class="key" valign="top">
				<label for="name">
					<?php echo JText::_( 'END_DATE' ); ?>:
				</label>
			</td>
			
			<td>
      <input type="text" name="end_date" id="end_date" value="<?php echo $this->detail->end_date; ?>"/>
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
   
		
				<tr valign="top">
			<td width="100" align="right" class="key">
				<label for="name">
					<?php echo JText::_( 'EVENT_DESCRIPTION' ); ?>:
				</label>
			</td>
			<td>
				<?php $editor =& JFactory::getEditor(); ?>
			<?php echo $editor->display("desc",$this->detail->desc,600,500,'100','20','0');	?>				
			</td>
		</tr>

		<tr>
			<td width="100" align="right" class="key" valign="top">
				<label for="name">
					<?php echo JText::_( 'BACKGROUND_COLOR' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" name="bgcolor" size="32" maxlength="250" id="colorpickerField1" value="<?php echo $this->detail->bgcolor;?>" /> 
			</td>
		</tr>
		<tr>
			<td width="100" align="right" class="key" valign="top" >
				<label for="name">
					<?php echo JText::_( 'TEXT_COLOR' ); ?>:
				</label>
			</td>
			<td>
				<input type="text" size="32" maxlength="250" name="txtcolor" id="colorpickerField2" value="<?php echo $this->detail->txtcolor;?>" /> 
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
<input type="hidden" name="view" value="event_detail" />
</form>