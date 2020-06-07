<?php
/**
* @package   JE Mediaplayer 
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/
    
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');

class Tableevent_configration extends JTable
{
	var $id = null;
	//var $player_width = null;
//	var $player_height = null;	 
//	var $thumb_width = null;
 	var $pattern = null;
	var $iscreate = null;
	var $title = null;
	var $head1 = null;
	var $head2 = null;
	var $head3 = null;
	var $head4 = null;
	var $autopub = null;
	function Tableevent_configration(& $db) 
	{
	  $this->_table_prefix = '#__jevent_';
			
		parent::__construct($this->_table_prefix.'event_configration', 'id', $db);
	}

	function bind($array, $ignore = '')
	{
		if (key_exists( 'params', $array ) && is_array( $array['params'] )) {
			$registry = new JRegistry();
			$registry->loadArray($array['params']);
			$array['params'] = $registry->toString();
		}

		return parent::bind($array, $ignore);
	}
	
}
?>