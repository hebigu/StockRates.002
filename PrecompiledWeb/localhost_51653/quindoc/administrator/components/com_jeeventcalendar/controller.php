<?php
/**
* @package   JE Music
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/


jimport('joomla.application.component.controller');

$l['c']		= 'Category';
$l['e']		= 'Event';
$l['g']		= 'Setting';
$l['a']		= 'About Us';


// Submenu view
$view	= JRequest::getVar( 'view', '', '', 'string', JREQUEST_ALLOWRAW );
if ($view == '' || $view == 'category') {
	
	JSubMenuHelper::addEntry(JText::_($l['c']), 'index.php?option=com_jeeventcalendar&view=category',true);
	JSubMenuHelper::addEntry(JText::_($l['e']), 'index.php?option=com_jeeventcalendar&view=event');
	JSubMenuHelper::addEntry(JText::_($l['g']), 'index.php?option=com_jeeventcalendar&view=event_configration');
	JSubMenuHelper::addEntry(JText::_($l['a']), 'index.php?option=com_jeeventcalendar&view=about' );
}
if ($view == 'event') {
	JSubMenuHelper::addEntry(JText::_($l['c']), 'index.php?option=com_jeeventcalendar&view=category');
	JSubMenuHelper::addEntry(JText::_($l['e']), 'index.php?option=com_jeeventcalendar&view=event',true);
	JSubMenuHelper::addEntry(JText::_($l['g']), 'index.php?option=com_jeeventcalendar&view=event_configration');
	JSubMenuHelper::addEntry(JText::_($l['a']), 'index.php?option=com_jeeventcalendar&view=about' );
}

if ($view == 'event_configration') {
	JSubMenuHelper::addEntry(JText::_($l['c']), 'index.php?option=com_jeeventcalendar&view=category');
	JSubMenuHelper::addEntry(JText::_($l['e']), 'index.php?option=com_jeeventcalendar&view=event');
	JSubMenuHelper::addEntry(JText::_($l['g']), 'index.php?option=com_jeeventcalendar&view=event_configration',true);
	JSubMenuHelper::addEntry(JText::_($l['a']), 'index.php?option=com_jeeventcalendar&view=about' );
}

if ($view == 'about') {
	JSubMenuHelper::addEntry(JText::_($l['c']), 'index.php?option=com_jeeventcalendar&view=category');
	JSubMenuHelper::addEntry(JText::_($l['e']), 'index.php?option=com_jeeventcalendar&view=event');
	JSubMenuHelper::addEntry(JText::_($l['g']), 'index.php?option=com_jeeventcalendar&view=event_configration');
	JSubMenuHelper::addEntry(JText::_($l['a']), 'index.php?option=com_jeeventcalendar&view=about',true);
}

?>