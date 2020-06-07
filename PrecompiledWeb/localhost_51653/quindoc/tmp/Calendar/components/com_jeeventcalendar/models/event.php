<?php

 /**

* @package   JE Event Calendar

* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.

* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php

* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com

* Visit : http://www.joomlaextensions.co.in/

**/ 



defined( '_JEXEC' ) or die( 'Restricted access' );



jimport( 'joomla.application.component.model' );
 

class eventModelevent extends JModelLegacy
{

	var $_id = null;

	var $_data = null;

	var $_product = null; // product data

	var $_table_prefix = null;

	var $_template = null;
	
	var $cal = "CAL_GREGORIAN";
	var $format = "%Y%m%d";
	var $today;
	var $day;
	var $month;
	var $year;
	var $pmonth;
	var $pyear;
	var $nmonth;
	var $nyear;
	var $wday_names = array("Mon","Tue","Wed","Thu","Fri","Sat","Sun");
	
	function eventModelevent()
	{
		$this->day = "1";
		$today = "";
		$month = "";
		$year = "";
		$pmonth = "";
		$pyear = "";
		$nmonth = "";
		$nyear = "";
	}


	function dateNow($month,$year)
	{
		if(empty($month))
			$this->month = strftime("%m",time());
		else
			$this->month = $month;
		if(empty($year))
			$this->year = strftime("%Y",time());	
		else
		$this->year = $year;
		$this->today = strftime("%d",time());		
		$this->pmonth = $this->month - 1;
		$this->pyear = $this->year - 1;
		$this->nmonth = $this->month + 1;
		$this->nyear = $this->year + 1;
	}

	function daysInMonth($month,$year)
	{
		if(empty($year))
			$year = $this->dateNow("%Y");

		if(empty($month))
			$month = $this->dateNow("%m");
		
		if($month == 2)
		{
			if($this->isLeapYear($year))
			{
				return 29;
			}
			else
			{
				return 28;
			}
		}
		else if($month==4 || $month==6 || $month==9 || $month==11)
			return 30;
		else
			return 31;
	}

	function isLeapYear($year)
	{
      return (($year % 4 == 0 && $year % 100 != 0) || $year % 400 == 0); 
	}

	function dayOfWeek($month,$year) 
  { 
		if($month > 2) 
				$month -= 2; 
		else 
		{ 
				$month += 10; 
				$year--; 
		} 
		 
		$day =  ( floor((13 * $month - 1) / 5) + 
						$this->day + ($year % 100) + 
						floor(($year % 100) / 4) + 
						floor(($year / 100) / 4) - 2 * 
						floor($year / 100) + 77); 
		 
		$weekday_number = (($day - 7 * floor($day / 7))); 
		 
		return $weekday_number; 
  }

	function getWeekDay()
	{
		$week_day = $this->dayOfWeek($this->month,$this->year);
		//return $this->wday_names[$week_day];
		return $week_Day;
	}

	function showThisMonth()
	{ 
	$option = JRequest::getVar('option');
	$uri =& JURI::getInstance();
	$url= $uri->root();
	
	$document = &JFactory::getDocument();
	
	$document->addStyleSheet ( 'components/'.$option.'/assets/css/lightbox.css' );

	$document->addScript('components/'.$option.'/assets/js/jquery.min.js' );
	$document->addScript('components/'.$option.'/assets/js/jquery.colorbox.js' );
	
	
	$Itemid = JRequest::getVar('Itemid');
	
	$db= & JFactory :: getDBO();
	$sql="select * from #__jevent_event_configration where id=1 ";
	
	$db->setQuery($sql);
	
	$congfig=$db->loadObject();
	$pattern=$congfig->pattern;
	
	$title = $this->title();
$set = $this->showinfront();
	/*echo "<PRE>";
print_r($set);
	echo $set->head2;
	exit;*/
	
	$dest = $url.'components/'.$option.'/assets/images/';
	
		print '<table cellpadding="5" width="100%" cellspacing="0" >';
		print '<tr>
		 <thead>
		<tr bgcolor="#'.$set->head1.'">
        <th><img src="'.$dest.'n5.png"  onclick="showPreYear();"/></th>				 
		 <th width="100%" scope="col" colspan="5"  class="rounded-q4" align="center" >
			'.$title->title.'
		</th>
		<th align="right"><img src="'.$dest.'n4.png"  onclick="showNextYear();"/></th>
		 </thead>
		</tr>
		<tr bgcolor="#'.$set->head2.'">    	 
		<td align="right"> <img src="'.$dest.'n1.png"  onclick="showPrevMonth();"/>	</td>
		<td width="100%"  height="40" colspan="5" class="rounded-company" scope="col" align="center" >'.JText::_( 'MONTH_YEAR' ).'<b>'.$this->month ." / " .$this->year .'</b></td>
		<td align="left"> <img src="'.$dest.'n2.png"  onclick="showNextMonth();"/>	</td>
		</tr>';
		
		print '<tr> <thead>';
		
		for($i=0;$i<7;$i++)
			print '<th width="14.28%" height="40"  scope="col" align="center" style="border:solid 1px #CCCCCC;" bgcolor="#'.$set->head3.'">'. $this->wday_names[$i]. '</th>';
		print ' </thead></tr>';		
		$wday = $this->dayOfWeek($this->month,$this->year);
		$no_days = $this->daysInMonth($this->month,$this->year);
		$count = 1;
		print '<tr>';
		for($i=1;$i<=$wday;$i++)
		{
			print '<td width="14.28%" align="center" style="border:solid 1px #CCCCCC;"  bgcolor="#'.$set->head4.'">&nbsp;</td>';
			$count++;
		}
		for($i=1;$i<=$no_days;$i++)
		{
			$dt=$this->year."-".$this->month."-".$i;
			$chk=$this->check_data($dt);
			
			if($chk==true)
			{
				$edata=$this->event_data($dt);
				$event_data ="";
		  		for($j=0;$j<count($edata);$j++)
				{
			
					$event_data .="<br />";
					$link=JRoute::_($url."index.php?tmpl=component&option=".$option."&view=event&Itemid=".$Itemid."&event_id=".$edata[$j]->id);
			
					$event_data .= "<span style='padding:2px; margin:5px;'>
					<a href='".$link."' class=\"example7\" style='background-color:#".$edata[$j]->bgcolor.";color:#".$edata[$j]->txtcolor.";'>".$edata[$j]->title."</a></span><br>";
			
			//$event_data . = "<a href='".$link."' rel=\"lightbox\">".$edata[$j]->title."</a>";
				}
			}
			else
			{
				$event_data ="";
		  	}
			
				if($count > 6)
				{
					if($i == $this->today)
					{
						print '<td align="center"  bgcolor="#'.$set->head4.'" height="60"  width="14.28%" style="border:solid 1px #CCCCCC;text-align:right; vertical-align:text-top;">' . $i .'<br> '.$event_data. '</td></tr>';
					}
					else
					{
						print '<td align="center"   bgcolor="#'.$set->head4.'" height="60"  width="14.28%" style="border:solid 1px #CCCCCC;text-align:right; vertical-align:text-top;">' . $i .' <br>'.$event_data. '</td></tr>';
					}
					$count = 0;
				}
				else
				{
					if($i == $this->today)
					{
						print '<td align="center"  bgcolor="#'.$set->head4.'" height="60"  width="14.28%" style="border:solid 1px #CCCCCC;text-align:right; vertical-align:text-top;">' . $i .' <br>'.$event_data. '</td>';
					}
					else
					{
						print '<td align="center"   bgcolor="#'.$set->head4.'"height="60"  width="14.28%" style="border:solid 1px #CCCCCC;text-align:right; vertical-align:text-top;">' . $i.'<br> '.$event_data. '</td>';
					}
				}
				$count++;
		}
		print '</tr></table>';
	} 
	function event_data($date)
	{
	$query = ' SELECT * FROM '.$this->_table_prefix.'event where published=1 and start_date="'.$date.'" ';

	$this->_db->setQuery($query);
	return $this->_db->loadObjectlist();
	}
	
	function event_desc($id)
	{
	$query = ' SELECT e.*,c.ename AS category FROM '.$this->_table_prefix.'event AS e LEFT JOIN '.$this->_table_prefix.'cal_category AS c ON e.category=c.id where e.id="'.$id.'" ';
	$this->_db->setQuery($query);
	return $this->_db->loadObjectlist();
	}
	function title()
	{
	$query = ' SELECT title FROM '.$this->_table_prefix.'event_configration where id=1';
	$this->_db->setQuery($query);
	/*print_r($this->_db->loadObject());
	exit;*/
	return $this->_db->loadObject();
	}
	
	function __construct()

	{
		global $context;        
		$mainframe	= JFactory::getApplication();$context = 'id';
		
	  	$this->_table_prefix = '#__jevent_';	
		parent::__construct();
		
		 
	}
	 
	
	 function check_data($id)
	{
	$user 		= clone(JFactory::getUser());
	//echo $user->id;
	  $query = ' SELECT usr FROM '.$this->_table_prefix.'event where published=1 and start_date="'.$id.'" ';
	$this->_db->setQuery($query);
	$res=$this->_db->loadObject();
	
	if($res){
	if($res->usr=='0')
	{
	return true;
	}else{
		$res_data=explode('`',$res->usr);
	
	      if (in_array($user->id,$res_data))
	      {
	               return true;
	      }
		  else
		  {
		            return false;
		  }
	}
	}
	else{
	return false;
	}

	}


function showinfront()
	{
		$db = JFactory::getDbo();
		$sql="SELECT * FROM  #__jevent_event_configration";
			$db->setQuery($sql);
			$row_data=$db->loadObject();
			return $row_data;
			
	}	 

}