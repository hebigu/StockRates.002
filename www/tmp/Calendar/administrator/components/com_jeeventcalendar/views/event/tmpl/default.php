<?php defined('_JEXEC') or die('Restricted access');
 
$option = JRequest::getVar('option');
$filter = JRequest::getVar('filter'); 
?>
<script language="javascript" type="text/javascript">

Joomla.submitform =function submitform(pressbutton){
var form = document.adminForm;
   if (pressbutton)
    {form.task.value=pressbutton;}
     
	 if ((pressbutton=='add')||(pressbutton=='edit')||(pressbutton=='publish')||(pressbutton=='unpublish')
	 ||(pressbutton=='remove')|| (pressbutton=='copy') )
	 {		 
	  form.view.value="event_detail";
	 }
	try {
		form.onsubmit();
		}
	catch(e){}
	
	form.submit();
}
function submitform(pressbutton){
		var form = document.adminForm;
		if (pressbutton)
		{form.task.value=pressbutton;}
		if ((pressbutton=='publish')||(pressbutton=='unpublish')||(pressbutton=='saveorder'))
		{		 
		form.view.value="event_detail";
	 }
	try {
		form.onsubmit();
		}
	catch(e){}
	form.submit();
	}
</script>
<form action="<?php echo 'index.php?option='.$option; ?>" method="post" name="adminForm" id="adminForm" >
<div id="editcell">
 
	<table class="adminlist">
	<thead>
		<tr>
			<th width="5%">
				<?php echo JText::_( 'NUM' ); ?>
			</th>
			<th width="5%" class="title">
				<input type="checkbox" name="toggle" value="" onclick="checkAll(<?php echo count( $this->event ); ?>);" />
			</th >
					 
			<th width="50%">
				<?php echo JHTML::_('grid.sort','EVENT_TITLE', 'title', $this->lists['order_Dir'], $this->lists['order']); ?>
			</th>
			
			<!--<th width="5%" nowrap="nowrap">
				<?php //echo JHTML::_('grid.sort', 'PUBLISHED', 'published', $this->lists['order_Dir'], $this->lists['order'] ); ?>	
			</th>-->
			<th width="5%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort', 'EVENT_ID', 'id', $this->lists['order_Dir'], $this->lists['order'] ); ?>	
			</th>
			<th width="5%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort', 'EVENT_START_DATE', 'start_date', $this->lists['order_Dir'], $this->lists['order'] ); ?>	
			</th>
			<th width="5%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort', 'EVENT_END_DATE', 'end_date', $this->lists['order_Dir'], $this->lists['order'] ); ?>	
			</th>		
			<th width="5%" nowrap="nowrap">
				<?php echo JHTML::_('grid.sort', 'PUBLISHED', 'published', $this->lists['order_Dir'], $this->lists['order'] ); ?>	
			</th>		
			
		</tr>
	</thead>
	<?php
	$k = 0;
	for ($i=0, $n=count( $this->event ); $i < $n; $i++)
	{
		$row = &$this->event[$i];
        $row->id = $row->id;
		$link 	= JRoute::_( 'index.php?option='.$option.'&view=event_detail&task=edit&cid[]='. $row->id );
		
		$published 	= JHTML::_('grid.published', $row, $i );		
		
		?>
		<tr class="<?php echo "row$k"; ?>">
			<td class="order">
				<?php echo $this->pagination->getRowOffset( $i ); ?>
			</td>
			<td class="order">
			<?php echo JHTML::_('grid.id', $i, $row->id ); ?>
			</td>
			<td align="center">
			<a href="<?php echo $link; ?>" title="<?php echo JText::_( 'EDIT_TAG' ); ?>"><?php echo $row->title; ?></a>
			</td>			
			 
					
			<td align="center">
				<?php echo $row->id; ?>
			</td>
			<td align="center">
				<?php echo $row->start_date; ?>
			</td>
			<td align="center">
				<?php echo $row->end_date; ?>
			</td>
			 <td align="center">
				<?php echo $published;?>
			</td>
		</tr>
		<?php
		$k = 1 - $k;
	}
	?>	

<tfoot>
		<td colspan="9">
			<?php echo $this->pagination->getListFooter(); ?>
		</td>
	</tfoot>
	</table>
</div>

<input type="hidden" name="view" value="event" />
<input type="hidden" name="task" value="" />
<input type="hidden" name="boxchecked" value="0" />
<input type="hidden" name="filter_order" value="<?php echo $this->lists['order']; ?>" />
<input type="hidden" name="filter_order_Dir" value="<?php echo $this->lists['order_Dir']; ?>" />
</form>
