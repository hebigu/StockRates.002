
CREATE TABLE IF NOT EXISTS `#__jevent_cal_category` (
  `id` int(11) NOT NULL auto_increment,
  `ename` varchar(50) NOT NULL,
  `edesc` text NOT NULL,
  `published` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;



CREATE TABLE IF NOT EXISTS `#__jevent_event` (
  `id` int(11) NOT NULL auto_increment,
  `title` varchar(250) NOT NULL,
  `category` int(11) NOT NULL,
  `usr` text NOT NULL,
  `desc` longtext NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL default '0000-00-00',
  `published` tinyint(4) NOT NULL,
  `bgcolor` varchar(100) NOT NULL,
  `txtcolor` varchar(100) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;

DROP TABLE IF EXISTS `#__jevent_event_configration`;


CREATE TABLE IF NOT EXISTS `#__jevent_event_configration` (
  `id` int(11) NOT NULL auto_increment,
  `pattern` varchar(100) NOT NULL,
  `iscreate` tinyint(4) NOT NULL,
  `title` text NOT NULL,
  `head1` text NOT NULL,
  `head2` text NOT NULL,
  `head3` text NOT NULL,
  `head4` text NOT NULL,
  `autopub` tinyint(4) NOT NULL,
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;



INSERT INTO `#__jevent_event_configration` VALUES (1, 'pattern1', 1, 'Event ', 'cee5f5', '97c7b6', 'ad5ead', 'fa9bfa', 1);
