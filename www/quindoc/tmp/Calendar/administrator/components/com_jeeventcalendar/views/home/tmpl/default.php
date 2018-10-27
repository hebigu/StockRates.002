<?php defined('_JEXEC') or die('Restricted access');
 /**
* @package   JE Section Finder 
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/
$option = JRequest::getVar('option');
$filter = JRequest::getVar('filter'); 
?>
 <table cellspacing="0" cellpadding="0" border="0" width="100%">
		<tr>
			<td valign="top">
			<table class="adminlist">
				<tr>
					<td>
						<div id="cpanel"> 
					 <?php
						//global $option;
						
						$link = 'index.php?option='.$option.'&amp;view=home';
						homeViewhome::quickiconButton( $link, 'home48.png', JText::_( 'HOME' ) );
						
						$link = 'index.php?option='.$option.'&amp;view=category';
						homeViewhome::quickiconButton( $link, 'category.png', JText::_( 'CATEGORY' ) );
						
						$link = 'index.php?option='.$option.'&amp;view=event';
						homeViewhome::quickiconButton( $link, 'event.png', JText::_( 'EVENT' ) );
						
						$link = 'index.php?option='.$option.'&amp;view=event_configration';
						homeViewhome::quickiconButton( $link, 'event_setting.png', JText::_( 'EVENT_SETTING' ) );
						
						
						
						/*$link = 'index.php?option='.$option.'&amp;view=form_layout';
						homeViewhome::quickiconButton( $link, 'layout48.png', JText::_( 'FORM_LAYOUT ' ) );*/
												 
						
						?>
						</div>
					</td>
				</tr>
			</table>
			</td>
			<td valign="top" width="320px" style="padding: 7px 0 0 5px">
			
 
					</td>
				</tr>
			</table>