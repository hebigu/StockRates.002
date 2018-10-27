<?php	
/**
* @package   JE Event Calendar
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
* Visit : http://www.joomlaextensions.co.in/
**/ 

defined ('_JEXEC') or die ('restricted access');
JHTML::_('behavior.tooltip');
$uri =& JURI::getInstance();
$url= $uri->root();
$mainframe	= JFactory::getApplication();
JHTML::_('behavior.calendar');
$document = &JFactory::getDocument();
$my =& JFactory::getUser();
$month = JRequest::getVar('month',date("m"),'request','string');
$year = JRequest::getVar('year',date("Y"),'request','string');
$model = $this->getModel ( 'event' );
$month1=date('d');
$model->dateNow($month,$year);
$option = JRequest::getVar('option','','request','string');

?> 
 <script type="text/javascript">
 	jQuery.noConflict();
			$(document).ready(function(){
				//Examples of how to assign the ColorBox event to elements
				
				$(".example7").colorbox({width:"80%", height:"80%", iframe:true});
				
				
				//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>
<script language="javascript">

function showPrevMonth()
{

	document.jeform.mon.value="" + "<?php echo $month?>";
	document.jeform.yr.value="" + "<?php echo $year?>";
	if(document.jeform.mon.value == "")
	{
		getMonthYear();
	}
	m = eval(document.jeform.mon.value + "-" + 1);
  y = document.jeform.yr.value;
	if(m < 1)
	{
		m = 12;
		y = eval(y + "-" + 1);
	}
	//window.location.href="view_calendar.php?month=" + m + "&year=" + y;
	
	document.jeform.month.value=m;
	document.jeform.year.value=y;
	document.jeform.submit();
}
function showNextMonth()
{
	b=document.jeform.mon.value="" + "<?php echo $month?>";
	//alert(b);
	document.jeform.yr.value="" + "<?php echo $year?>";
	if(document.jeform.mon.value == "")
	{
		getMonthYear();
	}
	m = eval(document.jeform.mon.value + "+" + 1);

  y = document.jeform.yr.value;
	if(m > 12)
	{
		m = 1;
		y = eval(y + "+" + 1);
	}
	//window.location.href="view_calendar.php?month=" + m + "&year=" + y;
		document.jeform.month.value=m;
	document.jeform.year.value=y;
	document.jeform.submit();
}
function getMonthYear()
{
		cdate = new Date();
		
		mvalue = cdate.getMonth();
		yvalue = cdate.getYear();
		document.jeform.mon.value = mvalue;
		document.jeform.yr.value = yvalue;
}
function getYear1()
{
		cdate = new Date();
		
		//mvalue = cdate.getMonth();
		yvalue = cdate.getYear();
		alert(yvalue);
		//document.jeform.mon.value = mvalue;
		document.jeform.yr.value = yvalue;
}
var i=0;
function showNextYear()
{
	b=document.jeform.yr.value="" + "<?php echo $year?>";
	y = eval(b + "+" + 1);
	document.getElementById('year').value=y;
	
	if(document.jeform.yr.value == "")
	{
		getYear1();
	}

	document.jeform.submit();
}
function showPreYear()
{
	b=document.jeform.yr.value="" + "<?php echo $year?>";
	y = eval(b + "-" + 1);
	document.getElementById('year').value=y;
	if(document.jeform.yr.value == "")
	{
		getYear1();
	}
	
	document.jeform.submit();
}

</script>

<form action="<?php echo JRoute::_("index.php?option=".$option."&view=event");?>"  method="post" name="jeform" id="jeform" >
 <input type="hidden" name="mon"  value="<?php echo $month?>"><input type="hidden" name="yr" value="<?php echo $year?>">
<input type="hidden" name="month" id="month" value="<?php echo $month?>" />
<input type="hidden" name="year" id="year" value="<?php echo $year?>" />
<input type="hidden" name="Itemid" id="Itemid" value="<?php echo $Itemid?>" />
<?php
$model->showThisMonth();
?></form>
