<?php
/**
* @package   JE Section Finder 
* @copyright Copyright (C) 2009 - 2010 Open Source Matters. All rights reserved.
* @license   http://www.gnu.org/licenses/lgpl.html GNU/LGPL, see LICENSE.php
* Contact to : emailtohardik@gmail.com, joomextensions@gmail.com
**/
defined( '_JEXEC' ) or die( 'Restricted access' );

jimport('joomla.application.component.model');


class homeModelhome extends JModelLegacy
{
	var $_data = null;
	var $_total = null;
	var $_pagination = null;
	var $_table_prefix = null;
	function __construct()
	{
		parent::__construct();


		global $context;        
		$mainframe	= JFactory::getApplication();$context='eid';
	  	$this->_table_prefix = '#__jevent_';			
		$limit			= $mainframe->getUserStateFromRequest( $context.'limit', 'limit', $mainframe->getCfg('list_limit'), 0);
		$limitstart = $mainframe->getUserStateFromRequest( $context.'limitstart', 'limitstart', 0 );
		
		$home     = $mainframe->getUserStateFromRequest( $context.'home','home',0);
		$filter   = $mainframe->getUserStateFromRequest( $context.'filter','filter',0);
			
		
		$this->setState('limit', $limit);
		$this->setState('limitstart', $limitstart);
		$this->setState('home', $home);
		$this->setState('filter', $filter);

	}
	
	
}	

