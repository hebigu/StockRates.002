--
-- Table structure for table `#__creative_forms`
--
CREATE TABLE IF NOT EXISTS `#__creative_forms` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `email_to` text NOT NULL,
  `email_bcc` text NOT NULL,
  `email_subject` text NOT NULL,
  `email_from` text NOT NULL,
  `email_from_name` text NOT NULL,
  `email_replyto` text NOT NULL,
  `email_replyto_name` text NOT NULL,
  `shake_count` mediumint(8) unsigned NOT NULL,
  `shake_distanse` mediumint(8) unsigned NOT NULL,
  `shake_duration` mediumint(8) unsigned NOT NULL,
  `id_template` mediumint(8) unsigned NOT NULL,
  `name` text NOT NULL,
  `top_text` text NOT NULL,
  `pre_text` text NOT NULL,
  `thank_you_text` text NOT NULL,
  `send_text` text NOT NULL,
  `send_new_text` text NOT NULL,
  `close_alert_text` text NOT NULL,
  `form_width` text NOT NULL,
  `alias` text NOT NULL,
  `created` datetime NOT NULL,
  `publish_up` datetime NOT NULL,
  `publish_down` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `checked_out` int(10) unsigned NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `access` int(10) unsigned NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL,
  `ordering` int(11) NOT NULL,
  `language` char(7) NOT NULL,
  `redirect` enum('0','1') NOT NULL DEFAULT '0',
  `redirect_itemid` int(10) unsigned NOT NULL,
  `redirect_url` text NOT NULL,
  `redirect_delay` int(11) NOT NULL,
  `send_copy_enable` enum('0','1') NOT NULL,
  `send_copy_text` text NOT NULL,
  `show_back` enum('0','1') NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARACTER SET = `utf8`;

--
-- Dumping data for table `#__creative_forms`
--

INSERT IGNORE INTO `#__creative_forms` (`id`, `email_to`, `email_bcc`, `email_subject`, `email_from`, `email_from_name`, `email_replyto`, `email_replyto_name`, `shake_count`, `shake_distanse`, `shake_duration`, `id_template`, `name`, `top_text`, `pre_text`, `thank_you_text`, `send_text`, `send_new_text`, `close_alert_text`, `form_width`, `alias`, `created`, `publish_up`, `publish_down`, `published`, `checked_out`, `checked_out_time`, `access`, `featured`, `ordering`, `language`, `redirect`, `redirect_itemid`, `redirect_url`, `redirect_delay`, `send_copy_enable`, `send_copy_text`) VALUES
(1, '', '', '', '', '', '', '', 2, 10, 300, 4, 'Contact Form Example', 'Contact Us', 'Feel free to contact us if you have any questions', 'Message successfully sent', 'Send', 'New email', 'OK', '100%', '', '2013-06-26 15:43:09', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 0, '', '0', 103, '', 0, '1', 'Send me a copy');

--
-- Table structure for table `#__creative_fields`
--

CREATE TABLE IF NOT EXISTS `#__creative_fields` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_user` int(10) unsigned NOT NULL,
  `id_form` mediumint(8) unsigned NOT NULL,
  `name` text NOT NULL,
  `id_type` mediumint(8) unsigned NOT NULL,
  `alias` text NOT NULL,
  `created` datetime NOT NULL,
  `publish_up` datetime NOT NULL,
  `publish_down` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `checked_out` int(10) unsigned NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `access` int(10) unsigned NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL,
  `ordering` int(11) NOT NULL,
  `language` char(7) NOT NULL,
  `required` enum('0','1') NOT NULL DEFAULT '0',
  `width` text NOT NULL,
  `select_show_scroll_after` int(11) NOT NULL DEFAULT '10',
  `select_show_search_after` int(11) NOT NULL DEFAULT '10',
  `message_required` text NOT NULL,
  `message_invalid` text NOT NULL,
  `ordering_field` enum('0','1') NOT NULL DEFAULT '0',
  `show_parent_label` enum('0','1') NOT NULL DEFAULT '1',
  `select_default_text` text NOT NULL,
  `select_no_match_text` text NOT NULL,
  `upload_button_text` text NOT NULL,
  `upload_minfilesize` text NOT NULL,
  `upload_maxfilesize` text NOT NULL,
  `upload_acceptfiletypes` text NOT NULL,
  `upload_minfilesize_message` text NOT NULL,
  `upload_maxfilesize_message` text NOT NULL,
  `upload_acceptfiletypes_message` text NOT NULL,
  `captcha_wrong_message` text NOT NULL,
  PRIMARY KEY (`id`),
  KEY `id_user` (`id_user`),
  KEY `id_form` (`id_form`)
) ENGINE=MyISAM CHARACTER SET = `utf8`;

--
-- Dumping data for table `#__creative_fields`
--

INSERT IGNORE INTO `#__creative_fields` (`id`, `id_user`, `id_form`, `name`, `id_type`, `alias`, `created`, `publish_up`, `publish_down`, `published`, `checked_out`, `checked_out_time`, `access`, `featured`, `ordering`, `language`, `required`, `width`, `select_show_scroll_after`, `select_show_search_after`, `message_required`, `message_invalid`, `ordering_field`, `show_parent_label`, `select_default_text`, `select_no_match_text`, `upload_button_text`, `upload_minfilesize`, `upload_maxfilesize`, `upload_acceptfiletypes`, `upload_minfilesize_message`, `upload_maxfilesize_message`, `upload_acceptfiletypes_message`, `captcha_wrong_message`) VALUES
(1, 0, 1, 'Name', 3, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 1, '', '1', '', 10, 10, '', '', '0', '1', '', '', '', '', '', '', '', '', '', ''),
(2, 0, 1, 'Email', 4, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 0, 0, 2, '', '1', '', 10, 10, '', '', '', '1', '', '', '', '0', '0', '', '', '', '', ''),
(3, 0, 1, 'Country', 9, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 3, '', '1', '', 10, 10, '', '', '0', '1', 'Select country', 'No results match', '', '', '', '', '', '', '', ''),
(4, 0, 1, 'How did you find us?', 12, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 4, '', '1', '', 10, 10, '', '', '0', '1', '', '', '', '', '', '', '', '', '', ''),
(5, 0, 1, 'Message', 2, '', '0000-00-00 00:00:00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 1, 0, 5, '', '1', '', 10, 10, '', '', '0', '1', '', '', '', '', '', '', '', '', '', '');

--
-- Table structure for table `#__creative_field_types`
--

CREATE TABLE IF NOT EXISTS `#__creative_field_types` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARACTER SET = `utf8`;

--
-- Dumping data for table  `#__creative_field_types`
--

INSERT IGNORE INTO `#__creative_field_types` (`id`, `name`) VALUES
(1, 'Text Input'),
(2, 'Text Area'),
(3, 'Name'),
(4, 'E-mail'),
(5, 'Address'),
(6, 'Phone'),
(7, 'Number'),
(8, 'Url'),
(9, 'Select'),
(10, 'Multiple Select'),
(11, 'Checkbox'),
(12, 'Radio'),
(13, 'Captcha : PRO feature'),
(14, 'File upload : PRO feature');

--
-- Table structure for table `#__creative_form_options`
--

CREATE TABLE IF NOT EXISTS `#__creative_form_options` (
  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
  `id_parent` int(11) unsigned NOT NULL,
  `name` text NOT NULL,
  `value` text NOT NULL,
  `ordering` int(11) NOT NULL,
  `showrow` enum('0','1') NOT NULL DEFAULT '1',
  `selected` enum('0','1') NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARACTER SET = `utf8`;

--
-- Dumping data for table `#__creative_form_options`
--

INSERT IGNORE INTO `#__creative_form_options` (`id`, `id_parent`, `name`, `value`, `ordering`, `showrow`, `selected`) VALUES
(1, 3, 'Afghanistan', 'Afghanistan', 0, '1', '0'),
(2, 3, 'Albania', 'Albania', 0, '1', '0'),
(3, 3, 'Algeria', 'Algeria', 0, '1', '0'),
(4, 3, 'American Samoa', 'American Samoa', 0, '1', '0'),
(5, 3, 'Andorra', 'Andorra', 0, '1', '0'),
(6, 3, 'Angola', 'Angola', 0, '1', '0'),
(7, 3, 'Anguilla', 'Anguilla', 0, '1', '0'),
(8, 3, 'Antarctica', 'Antarctica', 0, '1', '0'),
(9, 3, 'Antigua and Barbuda', 'Antigua and Barbuda', 0, '1', '0'),
(10, 3, 'Argentina', 'Argentina', 0, '1', '0'),
(11, 3, 'Armenia', 'Armenia', 0, '1', '0'),
(12, 3, 'Aruba', 'Aruba', 0, '1', '0'),
(13, 3, 'Australia', 'Australia', 0, '1', '0'),
(14, 3, 'Austria', 'Austria', 0, '1', '0'),
(15, 3, 'Azerbaijan', 'Azerbaijan', 0, '1', '0'),
(16, 3, 'Bahamas', 'Bahamas', 0, '1', '0'),
(17, 3, 'Bahrain', 'Bahrain', 0, '1', '0'),
(18, 3, 'Bangladesh', 'Bangladesh', 0, '1', '0'),
(19, 3, 'Barbados', 'Barbados', 0, '1', '0'),
(20, 3, 'Belarus', 'Belarus', 0, '1', '0'),
(21, 3, 'Belgium', 'Belgium', 0, '1', '0'),
(22, 3, 'Belize', 'Belize', 0, '1', '0'),
(23, 3, 'Benin', 'Benin', 0, '1', '0'),
(24, 3, 'Bermuda', 'Bermuda', 0, '1', '0'),
(25, 3, 'Bhutan', 'Bhutan', 0, '1', '0'),
(26, 3, 'Bolivia', 'Bolivia', 0, '1', '0'),
(27, 3, 'Bosnia and Herzegowina', 'Bosnia and Herzegowina', 0, '1', '0'),
(28, 3, 'Botswana', 'Botswana', 0, '1', '0'),
(29, 3, 'Bouvet Island', 'Bouvet Island', 0, '1', '0'),
(30, 3, 'Brazil', 'Brazil', 0, '1', '0'),
(31, 3, 'British Indian Ocean Territory', 'British Indian Ocean Territory', 0, '1', '0'),
(32, 3, 'Brunei Darussalam', 'Brunei Darussalam', 0, '1', '0'),
(33, 3, 'Bulgaria', 'Bulgaria', 0, '1', '0'),
(34, 3, 'Burkina Faso', 'Burkina Faso', 0, '1', '0'),
(35, 3, 'Burundi', 'Burundi', 0, '1', '0'),
(36, 3, 'Cambodia', 'Cambodia', 0, '1', '0'),
(37, 3, 'Cameroon', 'Cameroon', 0, '1', '0'),
(38, 3, 'Canada', 'Canada', 0, '1', '0'),
(39, 3, 'Cape Verde', 'Cape Verde', 0, '1', '0'),
(40, 3, 'Cayman Islands', 'Cayman Islands', 0, '1', '0'),
(41, 3, 'Central African Republic', 'Central African Republic', 0, '1', '0'),
(42, 3, 'Chad', 'Chad', 0, '1', '0'),
(43, 3, 'Chile', 'Chile', 0, '1', '0'),
(44, 3, 'China', 'China', 0, '1', '0'),
(45, 3, 'Christmas Island', 'Christmas Island', 0, '1', '0'),
(46, 3, 'Cocos (Keeling) Islands', 'Cocos (Keeling) Islands', 0, '1', '0'),
(47, 3, 'Colombia', 'Colombia', 0, '1', '0'),
(48, 3, 'Comoros', 'Comoros', 0, '1', '0'),
(49, 3, 'Congo', 'Congo', 0, '1', '0'),
(50, 3, 'Cook Islands', 'Cook Islands', 0, '1', '0'),
(51, 3, 'Costa Rica', 'Costa Rica', 0, '1', '0'),
(52, 3, 'Cote D''Ivoire', 'Cote DIvoire', 0, '1', '0'),
(53, 3, 'Croatia', 'Croatia', 0, '1', '0'),
(54, 3, 'Cuba', 'Cuba', 0, '1', '0'),
(55, 3, 'Cyprus', 'Cyprus', 0, '1', '0'),
(56, 3, 'Czech Republic', 'Czech Republic', 0, '1', '0'),
(57, 3, 'Democratic Republic of Congo', 'Democratic Republic of Congo', 0, '1', '0'),
(58, 3, 'Denmark', 'Denmark', 0, '1', '0'),
(59, 3, 'Djibouti', 'Djibouti', 0, '1', '0'),
(60, 3, 'Dominica', 'Dominica', 0, '1', '0'),
(61, 3, 'Dominican Republic', 'Dominican Republic', 0, '1', '0'),
(62, 3, 'East Timor', 'East Timor', 0, '1', '0'),
(63, 3, 'Ecuador', 'Ecuador', 0, '1', '0'),
(64, 3, 'Egypt', 'Egypt', 0, '1', '0'),
(65, 3, 'El Salvador', 'El Salvador', 0, '1', '0'),
(66, 3, 'Equatorial Guinea', 'Equatorial Guinea', 0, '1', '0'),
(67, 3, 'Eritrea', 'Eritrea', 0, '1', '0'),
(68, 3, 'Estonia', 'Estonia', 0, '1', '0'),
(69, 3, 'Ethiopia', 'Ethiopia', 0, '1', '0'),
(70, 3, 'Falkland Islands (Malvinas)', 'Falkland Islands (Malvinas)', 0, '1', '0'),
(71, 3, 'Faroe Islands', 'Faroe Islands', 0, '1', '0'),
(72, 3, 'Fiji', 'Fiji', 0, '1', '0'),
(73, 3, 'Finland', 'Finland', 0, '1', '0'),
(74, 3, 'France', 'France', 0, '1', '0'),
(75, 3, 'France, Metropolitan', 'France, Metropolitan', 0, '1', '0'),
(76, 3, 'French Guiana', 'French Guiana', 0, '1', '0'),
(77, 3, 'French Polynesia', 'French Polynesia', 0, '1', '0'),
(78, 3, 'French Southern Territories', 'French Southern Territories', 0, '1', '0'),
(79, 3, 'Gabon', 'Gabon', 0, '1', '0'),
(80, 3, 'Gambia', 'Gambia', 0, '1', '0'),
(81, 3, 'Georgia', 'Georgia', 0, '1', '0'),
(82, 3, 'Germany', 'Germany', 0, '1', '0'),
(83, 3, 'Ghana', 'Ghana', 0, '1', '0'),
(84, 3, 'Gibraltar', 'Gibraltar', 0, '1', '0'),
(85, 3, 'Greece', 'Greece', 0, '1', '0'),
(86, 3, 'Greenland', 'Greenland', 0, '1', '0'),
(87, 3, 'Grenada', 'Grenada', 0, '1', '0'),
(88, 3, 'Guadeloupe', 'Guadeloupe', 0, '1', '0'),
(89, 3, 'Guam', 'Guam', 0, '1', '0'),
(90, 3, 'Guatemala', 'Guatemala', 0, '1', '0'),
(91, 3, 'Guinea', 'Guinea', 0, '1', '0'),
(92, 3, 'Guinea-bissau', 'Guinea-bissau', 0, '1', '0'),
(93, 3, 'Guyana', 'Guyana', 0, '1', '0'),
(94, 3, 'Haiti', 'Haiti', 0, '1', '0'),
(95, 3, 'Heard and Mc Donald Islands', 'Heard and Mc Donald Islands', 0, '1', '0'),
(96, 3, 'Honduras', 'Honduras', 0, '1', '0'),
(97, 3, 'Hong Kong', 'Hong Kong', 0, '1', '0'),
(98, 3, 'Hungary', 'Hungary', 0, '1', '0'),
(99, 3, 'Iceland', 'Iceland', 0, '1', '0'),
(100, 3, 'India', 'India', 0, '1', '0'),
(101, 3, 'Indonesia', 'Indonesia', 0, '1', '0'),
(102, 3, 'Iran (Islamic Republic of)', 'Iran (Islamic Republic of)', 0, '1', '0'),
(103, 3, 'Iraq', 'Iraq', 0, '1', '0'),
(104, 3, 'Ireland', 'Ireland', 0, '1', '0'),
(105, 3, 'Israel', 'Israel', 0, '1', '0'),
(106, 3, 'Italy', 'Italy', 0, '1', '0'),
(107, 3, 'Jamaica', 'Jamaica', 0, '1', '0'),
(108, 3, 'Japan', 'Japan', 0, '1', '0'),
(109, 3, 'Jordan', 'Jordan', 0, '1', '0'),
(110, 3, 'Kazakhstan', 'Kazakhstan', 0, '1', '0'),
(111, 3, 'Kenya', 'Kenya', 0, '1', '0'),
(112, 3, 'Kiribati', 'Kiribati', 0, '1', '0'),
(113, 3, 'Korea, Republic of', 'Korea, Republic of', 0, '1', '0'),
(114, 3, 'Kuwait', 'Kuwait', 0, '1', '0'),
(115, 3, 'Kyrgyzstan', 'Kyrgyzstan', 0, '1', '0'),
(116, 3, 'Lao People''s Democratic Republic', 'Lao Peoples Democratic Republic', 0, '1', '0'),
(117, 3, 'Latvia', 'Latvia', 0, '1', '0'),
(118, 3, 'Lebanon', 'Lebanon', 0, '1', '0'),
(119, 3, 'Lesotho', 'Lesotho', 0, '1', '0'),
(120, 3, 'Liberia', 'Liberia', 0, '1', '0'),
(121, 3, 'Libyan Arab Jamahiriya', 'Libyan Arab Jamahiriya', 0, '1', '0'),
(122, 3, 'Liechtenstein', 'Liechtenstein', 0, '1', '0'),
(123, 3, 'Lithuania', 'Lithuania', 0, '1', '0'),
(124, 3, 'Luxembourg', 'Luxembourg', 0, '1', '0'),
(125, 3, 'Macau', 'Macau', 0, '1', '0'),
(126, 3, 'Macedonia', 'Macedonia', 0, '1', '0'),
(127, 3, 'Madagascar', 'Madagascar', 0, '1', '0'),
(128, 3, 'Malawi', 'Malawi', 0, '1', '0'),
(129, 3, 'Malaysia', 'Malaysia', 0, '1', '0'),
(130, 3, 'Maldives', 'Maldives', 0, '1', '0'),
(131, 3, 'Mali', 'Mali', 0, '1', '0'),
(132, 3, 'Malta', 'Malta', 0, '1', '0'),
(133, 3, 'Marshall Islands', 'Marshall Islands', 0, '1', '0'),
(134, 3, 'Martinique', 'Martinique', 0, '1', '0'),
(135, 3, 'Mauritania', 'Mauritania', 0, '1', '0'),
(136, 3, 'Mauritius', 'Mauritius', 0, '1', '0'),
(137, 3, 'Mayotte', 'Mayotte', 0, '1', '0'),
(138, 3, 'Mexico', 'Mexico', 0, '1', '0'),
(139, 3, 'Micronesia, Federated States of', 'Micronesia, Federated States of', 0, '1', '0'),
(140, 3, 'Moldova, Republic of', 'Moldova, Republic of', 0, '1', '0'),
(141, 3, 'Monaco', 'Monaco', 0, '1', '0'),
(142, 3, 'Mongolia', 'Mongolia', 0, '1', '0'),
(143, 3, 'Montserrat', 'Montserrat', 0, '1', '0'),
(144, 3, 'Morocco', 'Morocco', 0, '1', '0'),
(145, 3, 'Mozambique', 'Mozambique', 0, '1', '0'),
(146, 3, 'Myanmar', 'Myanmar', 0, '1', '0'),
(147, 3, 'Namibia', 'Namibia', 0, '1', '0'),
(148, 3, 'Nauru', 'Nauru', 0, '1', '0'),
(149, 3, 'Nepal', 'Nepal', 0, '1', '0'),
(150, 3, 'Netherlands', 'Netherlands', 0, '1', '0'),
(151, 3, 'Netherlands Antilles', 'Netherlands Antilles', 0, '1', '0'),
(152, 3, 'New Caledonia', 'New Caledonia', 0, '1', '0'),
(153, 3, 'New Zealand', 'New Zealand', 0, '1', '0'),
(154, 3, 'Nicaragua', 'Nicaragua', 0, '1', '0'),
(155, 3, 'Niger', 'Niger', 0, '1', '0'),
(156, 3, 'Nigeria', 'Nigeria', 0, '1', '0'),
(157, 3, 'Niue', 'Niue', 0, '1', '0'),
(158, 3, 'Norfolk Island', 'Norfolk Island', 0, '1', '0'),
(159, 3, 'North Korea', 'North Korea', 0, '1', '0'),
(160, 3, 'Northern Mariana Islands', 'Northern Mariana Islands', 0, '1', '0'),
(161, 3, 'Norway', 'Norway', 0, '1', '0'),
(162, 3, 'Oman', 'Oman', 0, '1', '0'),
(163, 3, 'Pakistan', 'Pakistan', 0, '1', '0'),
(164, 3, 'Palau', 'Palau', 0, '1', '0'),
(165, 3, 'Panama', 'Panama', 0, '1', '0'),
(166, 3, 'Papua New Guinea', 'Papua New Guinea', 0, '1', '0'),
(167, 3, 'Paraguay', 'Paraguay', 0, '1', '0'),
(168, 3, 'Peru', 'Peru', 0, '1', '0'),
(169, 3, 'Philippines', 'Philippines', 0, '1', '0'),
(170, 3, 'Pitcairn', 'Pitcairn', 0, '1', '0'),
(171, 3, 'Poland', 'Poland', 0, '1', '0'),
(172, 3, 'Portugal', 'Portugal', 0, '1', '0'),
(173, 3, 'Puerto Rico', 'Puerto Rico', 0, '1', '0'),
(174, 3, 'Qatar', 'Qatar', 0, '1', '0'),
(175, 3, 'Reunion', 'Reunion', 0, '1', '0'),
(176, 3, 'Romania', 'Romania', 0, '1', '0'),
(177, 3, 'Russian Federation', 'Russian Federation', 0, '1', '0'),
(178, 3, 'Rwanda', 'Rwanda', 0, '1', '0'),
(179, 3, 'Saint Kitts and Nevis', 'Saint Kitts and Nevis', 0, '1', '0'),
(180, 3, 'Saint Lucia', 'Saint Lucia', 0, '1', '0'),
(181, 3, 'Saint Vincent and the Grenadines', 'Saint Vincent and the Grenadines', 0, '1', '0'),
(182, 3, 'Samoa', 'Samoa', 0, '1', '0'),
(183, 3, 'San Marino', 'San Marino', 0, '1', '0'),
(184, 3, 'Sao Tome and Principe', 'Sao Tome and Principe', 0, '1', '0'),
(185, 3, 'Saudi Arabia', 'Saudi Arabia', 0, '1', '0'),
(186, 3, 'Senegal', 'Senegal', 0, '1', '0'),
(187, 3, 'Seychelles', 'Seychelles', 0, '1', '0'),
(188, 3, 'Sierra Leone', 'Sierra Leone', 0, '1', '0'),
(189, 3, 'Singapore', 'Singapore', 0, '1', '0'),
(190, 3, 'Slovak Republic', 'Slovak Republic', 0, '1', '0'),
(191, 3, 'Slovenia', 'Slovenia', 0, '1', '0'),
(192, 3, 'Solomon Islands', 'Solomon Islands', 0, '1', '0'),
(193, 3, 'Somalia', 'Somalia', 0, '1', '0'),
(194, 3, 'South Africa', 'South Africa', 0, '1', '0'),
(195, 3, 'South Georgia &amp; South Sandwich Islands', 'South Georgia & South Sandwich Islands', 0, '1', '0'),
(196, 3, 'Spain', 'Spain', 0, '1', '0'),
(197, 3, 'Sri Lanka', 'Sri Lanka', 0, '1', '0'),
(198, 3, 'St. Helena', 'St. Helena', 0, '1', '0'),
(199, 3, 'St. Pierre and Miquelon', 'St. Pierre and Miquelon', 0, '1', '0'),
(200, 3, 'Sudan', 'Sudan', 0, '1', '0'),
(201, 3, 'Suriname', 'Suriname', 0, '1', '0'),
(202, 3, 'Svalbard and Jan Mayen Islands', 'Svalbard and Jan Mayen Islands', 0, '1', '0'),
(203, 3, 'Swaziland', 'Swaziland', 0, '1', '0'),
(204, 3, 'Sweden', 'Sweden', 0, '1', '0'),
(205, 3, 'Switzerland', 'Switzerland', 0, '1', '0'),
(206, 3, 'Syrian Arab Republic', 'Syrian Arab Republic', 0, '1', '0'),
(207, 3, 'Taiwan', 'Taiwan', 0, '1', '0'),
(208, 3, 'Tajikistan', 'Tajikistan', 0, '1', '0'),
(209, 3, 'Tanzania, United Republic of', 'Tanzania, United Republic of', 0, '1', '0'),
(210, 3, 'Thailand', 'Thailand', 0, '1', '0'),
(211, 3, 'Togo', 'Togo', 0, '1', '0'),
(212, 3, 'Tokelau', 'Tokelau', 0, '1', '0'),
(213, 3, 'Tonga', 'Tonga', 0, '1', '0'),
(214, 3, 'Trinidad and Tobago', 'Trinidad and Tobago', 0, '1', '0'),
(215, 3, 'Tunisia', 'Tunisia', 0, '1', '0'),
(216, 3, 'Turkey', 'Turkey', 0, '1', '0'),
(217, 3, 'Turkmenistan', 'Turkmenistan', 0, '1', '0'),
(218, 3, 'Turks and Caicos Islands', 'Turks and Caicos Islands', 0, '1', '0'),
(219, 3, 'Tuvalu', 'Tuvalu', 0, '1', '0'),
(220, 3, 'Uganda', 'Uganda', 0, '1', '0'),
(221, 3, 'Ukraine', 'Ukraine', 0, '1', '0'),
(222, 3, 'United Arab Emirates', 'United Arab Emirates', 0, '1', '0'),
(223, 3, 'United Kingdom', 'United Kingdom', 0, '1', '0'),
(224, 3, 'United States', 'United States', 0, '1', '0'),
(225, 3, 'United States Minor Outlying Islands', 'United States Minor Outlying Islands', 0, '1', '0'),
(226, 3, 'Uruguay', 'Uruguay', 0, '1', '0'),
(227, 3, 'Uzbekistan', 'Uzbekistan', 0, '1', '0'),
(228, 3, 'Vanuatu', 'Vanuatu', 0, '1', '0'),
(229, 3, 'Vatican City State (Holy See)', 'Vatican City State (Holy See)', 0, '1', '0'),
(230, 3, 'Venezuela', 'Venezuela', 0, '1', '0'),
(231, 3, 'Viet Nam', 'Viet Nam', 0, '1', '0'),
(232, 3, 'Virgin Islands (British)', 'Virgin Islands (British)', 0, '1', '0'),
(233, 3, 'Virgin Islands (U.S.)', 'Virgin Islands (U.S.)', 0, '1', '0'),
(234, 3, 'Wallis and Futuna Islands', 'Wallis and Futuna Islands', 0, '1', '0'),
(235, 3, 'Western Sahara', 'Western Sahara', 0, '1', '0'),
(236, 3, 'Yemen', 'Yemen', 0, '1', '0'),
(237, 3, 'Yugoslavia', 'Yugoslavia', 0, '1', '0'),
(238, 3, 'Zambia', 'Zambia', 0, '1', '0'),
(239, 3, 'Zimbabwe', 'Zimbabwe', 0, '1', '0'),
(240, 4, 'Web search', 'Web search', 2, '1', '0'),
(241, 4, 'Social networks', 'Social networks', 1, '1', '0'),
(242, 4, 'Recommended by a friend', 'Recommended by a friend', 3, '1', '0');

--
-- Table structure for table `#__contact_templates`
--

CREATE TABLE IF NOT EXISTS `#__contact_templates` (
  `id` mediumint(8) unsigned NOT NULL AUTO_INCREMENT,
  `name` text NOT NULL,
  `created` datetime NOT NULL,
  `date_start` date NOT NULL,
  `date_end` date NOT NULL,
  `publish_up` datetime NOT NULL,
  `publish_down` datetime NOT NULL,
  `published` tinyint(1) NOT NULL,
  `checked_out` int(10) unsigned NOT NULL,
  `checked_out_time` datetime NOT NULL,
  `access` int(10) unsigned NOT NULL,
  `featured` tinyint(3) unsigned NOT NULL,
  `ordering` int(11) NOT NULL,
  `language` char(7) NOT NULL,
  `styles` text NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=MyISAM CHARACTER SET = `utf8`;

INSERT IGNORE INTO `#__contact_templates` (`id`, `name`, `created`, `date_start`, `date_end`, `publish_up`, `publish_down`, `published`, `checked_out`, `checked_out_time`, `access`, `featured`, `ordering`, `language`, `styles`) VALUES
(1, 'Black', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, '', '0~#2e2d2e|130~#050505|207~15|214~16|213~25|208~16|131~|1~#2b2b2b|2~1|3~solid|4~5|5~5|6~5|7~5|8~#202020|9~|10~0|11~0|12~7|13~0|14~#000000|15~|16~0|17~0|18~10|19~1|20~#ffffff|21~22|22~bold|23~normal|24~none|25~left|27~#000000|28~1|29~1|30~3|190~2|191~0|192~90|193~6|194~1|195~#808080|196~dotted|197~#fafafa|198~12|199~normal|200~italic|201~none|202~|203~#ffffff|204~0|205~0|206~0|215~10|216~0|217~2|218~1|31~#ffffff|32~14|33~normal|34~normal|35~none|36~left|37~#000000|38~1|39~1|40~1|41~#e03c00|42~16|43~normal|44~normal|46~#ffffff|47~0|48~0|49~0|132~#202020|133~#383838|168~43|169~90|170~150|134~#949494|135~1|136~solid|137~4|138~4|139~4|140~4|141~#ffffff|142~|143~0|144~0|145~0|146~0|147~#fafafa|148~14|149~normal|150~normal|151~none|152~tahoma|153~#fcfcfc|154~0|155~0|156~0|157~#454545|158~#0a0a0a|159~#ffffff|160~#ff0000|161~#6b6b6b|162~#fcffc2|163~|164~0|165~0|166~20|167~-1|171~#e03c00|172~#000000|173~0|174~1|175~2|176~#f0b400|177~#701a00|178~#e6cfcf|179~#ffffff|180~#000000|181~-1|182~-1|183~1|184~#ffffff|185~|186~0|187~0|188~15|189~-2|91~#878387|50~#000000|212~left|92~5|93~43|210~16|211~0|219~1|220~0|209~90|100~#383038|101~1|127~solid|102~12|103~0|104~0|105~12|94~#ffffff|95~|96~0|97~2|98~12|99~-2|106~#ffffff|107~14|108~normal|109~normal|110~none|112~Arial|113~#000103|114~1|115~-1|116~1|51~#000000|52~#878387|124~#fafafa|125~#000000|126~#383038|117~#ffffff|118~|119~1|120~-1|121~12|122~-2'),
(2, 'Poison Green', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, '', '0~#a7de00|130~#76a101|207~17|214~17|213~10|208~17|131~''Comic Sans MS'',Georgia,sans-serif!important|1~#2b2b2b|2~0|3~solid|4~8|5~8|6~8|7~8|8~#688a00|9~|10~0|11~0|12~11|13~2|14~#000000|15~|16~0|17~0|18~10|19~1|20~#ffffff|21~24|22~bold|23~normal|24~none|25~left|27~#5b6b00|28~1|29~1|30~3|190~6|191~-2|192~90|193~3|194~1|195~#ffffff|196~dotted|197~#fafafa|198~13|199~normal|200~italic|201~none|202~|203~#323b00|204~0|205~0|206~4|215~0|216~0|217~4|218~0|31~#ffffff|32~13|33~normal|34~normal|35~none|36~left|37~#749d0b|38~1|39~1|40~1|41~#aa00cc|42~16|43~normal|44~normal|46~#ffffff|47~0|48~0|49~0|132~#c5ea0e|133~#c5ea0e|168~46|169~95|170~150|134~#4a8a00|135~1|136~solid|137~4|138~4|139~4|140~4|141~#618208|142~inset|143~6|144~6|145~18|146~0|147~#303e18|148~14|149~normal|150~normal|151~none|152~tahoma|153~#fc0a0a|154~0|155~0|156~0|157~#c5ea0e|158~#e0ff30|159~#151c09|160~#ff0000|161~#9fbd07|162~#749d0b|163~|164~0|165~0|166~20|167~4|171~#9100bd|172~#000000|173~0|174~0|175~0|176~#b361ff|177~#5a0073|178~#450085|179~#ffffff|180~#000000|181~0|182~0|183~0|184~#6e008a|185~inset|186~0|187~0|188~18|189~0|91~#a5d211|50~#407002|212~right|92~6|93~25|210~3|211~0|219~3|220~0|209~95|100~#3f7000|101~1|127~solid|102~11|103~11|104~11|105~11|94~#ffffff|95~inset|96~3|97~3|98~18|99~-3|106~#ffffff|107~14|108~bold|109~normal|110~none|112~''Comic Sans MS'',Georgia,sans-serif!important|113~#427007|114~1|115~-1|116~1|51~#79d107|52~#233d00|124~#fafafa|125~#3e6e00|126~#355e00|117~#ffffff|118~|119~-2|120~-2|121~12|122~-2'),
(4, 'Gray', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, '', '0~#fafafa|130~#a3a3a3|207~17|214~17|213~10|208~17|131~\'Source Sans Pro\', Helvetica, sans-serif|1~#ababab|2~1|3~solid|4~8|5~8|6~8|7~8|8~#333333|9~|10~3|11~3|12~13|13~-1|14~#000000|15~|16~0|17~0|18~10|19~1|20~#333333|21~28|22~normal|23~italic|24~none|25~left|27~#ffffff|28~1|29~1|30~3|190~10|191~-2|192~100|193~3|194~1|195~#292929|196~dotted|197~#333333|198~13|199~normal|200~italic|201~none|202~|203~#ffffff|204~0|205~0|206~4|215~0|216~0|217~1|218~0|31~#000000|32~14|33~normal|34~normal|35~none|36~left|37~#ffffff|38~0|39~0|40~0|41~#f00000|42~16|43~normal|44~normal|46~#ffffff|47~0|48~0|49~0|132~#f0f0f0|133~#9c9c9c|168~60|169~95|170~150|134~#333333|135~1|136~solid|137~4|138~4|139~4|140~4|141~#969696|142~inset|143~0|144~0|145~3|146~0|147~#000000|148~14|149~normal|150~normal|151~none|152~tahoma|153~#fafafa|154~0|155~0|156~0|157~#ffffff|158~#ffffff|159~#1c1c1c|160~#949494|161~#4a4a4a|162~#424142|163~inset|164~0|165~0|166~18|167~0|171~#c40a0a|172~#000000|173~0|174~0|175~0|176~#b5b5b5|177~#000000|178~#000000|179~#ffffff|180~#000000|181~0|182~0|183~0|184~#424142|185~inset|186~0|187~0|188~18|189~0|91~#bababa|50~#212121|212~right|92~6|93~25|210~3|211~0|219~3|220~0|209~95|100~#141414|101~1|127~solid|102~7|103~7|104~7|105~7|94~#636363|95~inset|96~2|97~2|98~3|99~-1|106~#ffffff|107~14|108~bold|109~normal|110~none|112~|113~#000000|114~1|115~-1|116~1|51~#212121|52~#bababa|124~#fafafa|125~#000000|126~#141414|117~#5c5c5c|118~inset|119~-2|120~-2|121~3|122~-1'),
(5, 'Orange', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, '', '0~#fca000|130~#ff9900|207~17|214~17|213~10|208~17|131~|1~#cc4100|2~1|3~solid|4~10|5~10|6~10|7~10|8~#cc4100|9~inset|10~10|11~10|12~45|13~2|14~#cc4100|15~inset|16~12|17~12|18~50|19~6|20~#ffffff|21~24|22~normal|23~normal|24~none|25~left|27~#000000|28~-1|29~-1|30~2|190~6|191~-2|192~90|193~3|194~1|195~#ffffff|196~dotted|197~#000000|198~13|199~normal|200~italic|201~none|202~|203~#ffd500|204~0|205~0|206~1|215~0|216~0|217~1|218~3|31~#000000|32~14|33~normal|34~normal|35~none|36~left|37~#ffd500|38~0|39~0|40~1|41~#d9001d|42~18|43~bold|44~normal|46~#ffffff|47~0|48~0|49~0|132~#b0b0b0|133~#ffffff|168~63|169~93|170~150|134~#ffffff|135~1|136~solid|137~7|138~7|139~7|140~7|141~#262524|142~inset|143~0|144~0|145~25|146~-2|147~#000000|148~14|149~normal|150~normal|151~none|152~tahoma|153~#fafafa|154~0|155~0|156~0|157~#ebebeb|158~#ffffff|159~#1c1c1c|160~#949494|161~#424242|162~#ffffff|163~inset|164~0|165~0|166~10|167~0|171~#c40a0a|172~#000000|173~0|174~0|175~0|176~#b5b5b5|177~#616161|178~#000000|179~#ffffff|180~#000000|181~0|182~0|183~0|184~#1f1f1f|185~inset|186~8|187~10|188~27|189~1|91~#ff0000|50~#630000|212~right|92~6|93~25|210~3|211~0|219~3|220~0|209~93|100~#610000|101~1|127~solid|102~7|103~7|104~7|105~7|94~#300000|95~inset|96~0|97~0|98~0|99~0|106~#ffffff|107~14|108~bold|109~normal|110~none|112~|113~#000000|114~1|115~-1|116~1|51~#ff0000|52~#520000|124~#fafafa|125~#000000|126~#610000|117~#300000|118~inset|119~2|120~3|121~9|122~-2'),
(6, 'Red', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, '', '0~#b0000f|130~#700009|207~17|214~17|213~10|208~17|131~|1~#470006|2~1|3~solid|4~10|5~10|6~10|7~10|8~#470006|9~inset|10~0|11~0|12~49|13~10|14~#470006|15~inset|16~0|17~0|18~50|19~15|20~#ffffff|21~24|22~normal|23~normal|24~none|25~left|27~#000000|28~2|29~1|30~2|190~6|191~-2|192~90|193~3|194~1|195~#ffffff|196~dotted|197~#ffffff|198~13|199~normal|200~italic|201~none|202~|203~#000000|204~2|205~1|206~1|215~0|216~0|217~1|218~3|31~#ffffff|32~14|33~normal|34~normal|35~none|36~left|37~#000000|38~2|39~1|40~1|41~#ffffff|42~18|43~bold|44~normal|46~#ffffff|47~0|48~0|49~0|132~#ffffff|133~#ffffff|168~63|169~93|170~150|134~#540000|135~1|136~solid|137~7|138~7|139~7|140~7|141~#000000|142~inset|143~0|144~0|145~25|146~1|147~#000000|148~14|149~normal|150~normal|151~none|152~tahoma|153~#fafafa|154~0|155~0|156~0|157~#ebebeb|158~#ffffff|159~#1c1c1c|160~#949494|161~#424242|162~#ffffff|163~inset|164~0|165~0|166~10|167~0|171~#f7ff05|172~#000000|173~0|174~0|175~0|176~#7a7a7a|177~#030303|178~#000000|179~#ffffff|180~#000000|181~0|182~0|183~0|184~#1f1f1f|185~inset|186~8|187~10|188~27|189~2|91~#4f4f4f|50~#000000|212~right|92~6|93~25|210~3|211~0|219~3|220~0|209~93|100~#2e0606|101~1|127~solid|102~7|103~7|104~7|105~7|94~#a10000|95~|96~0|97~0|98~16|99~4|106~#ffffff|107~14|108~bold|109~normal|110~none|112~|113~#000000|114~1|115~-1|116~1|51~#424242|52~#000000|124~#fafafa|125~#000000|126~#2e0606|117~#a10000|118~|119~0|120~0|121~18|122~7'),
(7, 'Blue', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, '', '0~#0036bd|130~#0036bd|207~17|214~17|213~10|208~17|131~|1~#001445|2~1|3~solid|4~10|5~10|6~10|7~10|8~#001445|9~inset|10~0|11~0|12~49|13~10|14~#001445|15~inset|16~0|17~0|18~50|19~15|20~#ffffff|21~24|22~normal|23~normal|24~none|25~left|27~#000000|28~2|29~1|30~2|190~6|191~-2|192~90|193~3|194~1|195~#ffffff|196~dotted|197~#ffffff|198~13|199~normal|200~italic|201~none|202~|203~#000000|204~2|205~1|206~1|215~0|216~0|217~1|218~3|31~#ffffff|32~14|33~normal|34~normal|35~none|36~left|37~#000000|38~2|39~1|40~1|41~#ff0000|42~18|43~bold|44~normal|46~#000000|47~2|48~1|49~1|132~#8389fc|133~#ffffff|168~63|169~93|170~150|134~#b6c9f5|135~1|136~solid|137~7|138~7|139~7|140~7|141~#89a100|142~inset|143~0|144~0|145~0|146~0|147~#000000|148~14|149~normal|150~normal|151~none|152~tahoma|153~#fafafa|154~0|155~0|156~0|157~#ebebeb|158~#ffffff|159~#1c1c1c|160~#949494|161~#424242|162~#ffffff|163~inset|164~0|165~0|166~10|167~0|171~#f70021|172~#000000|173~2|174~1|175~1|176~#ff0022|177~#380000|178~#52000b|179~#ffffff|180~#000000|181~0|182~0|183~0|184~#000000|185~inset|186~1|187~1|188~10|189~0|91~#e30000|50~#330000|212~right|92~6|93~25|210~3|211~0|219~3|220~0|209~93|100~#780000|101~1|127~solid|102~7|103~7|104~7|105~7|94~#000899|95~|96~0|97~0|98~16|99~4|106~#ffffff|107~14|108~bold|109~normal|110~none|112~|113~#000000|114~1|115~-1|116~1|51~#b80404|52~#1f0000|124~#fafafa|125~#000000|126~#780000|117~#000899|118~|119~0|120~0|121~18|122~7'),
(8, 'White', '0000-00-00 00:00:00', '0000-00-00', '0000-00-00', '0000-00-00 00:00:00', '0000-00-00 00:00:00', 1, 0, '0000-00-00 00:00:00', 0, 0, 0, '', '0~#ffffff|130~#ffffff|207~17|214~17|213~10|208~17|131~|1~#ffffff|2~1|3~solid|4~10|5~10|6~10|7~10|8~#ffffff|9~inset|10~0|11~0|12~49|13~10|14~#ffffff|15~inset|16~0|17~0|18~50|19~15|20~#3d2d3d|21~24|22~normal|23~normal|24~none|25~left|27~#ffffff|28~2|29~1|30~2|190~5|191~6|192~90|193~3|194~1|195~#302930|196~dashed|197~#3d2d3d|198~12|199~bold|200~italic|201~none|202~|203~#ffffff|204~0|205~0|206~0|215~0|216~0|217~1|218~3|31~#3d2d3d|32~14|33~normal|34~normal|35~none|36~left|37~#ffffff|38~2|39~1|40~1|41~#ff0000|42~18|43~bold|44~normal|46~#ffffff|47~2|48~1|49~1|132~#ffffff|133~#ffffff|168~63|169~93|170~150|134~#b6c9f5|135~1|136~solid|137~7|138~7|139~7|140~7|141~#89a100|142~inset|143~0|144~0|145~0|146~0|147~#000000|148~14|149~normal|150~normal|151~none|152~tahoma|153~#000000|154~0|155~0|156~0|157~#ebebeb|158~#ffffff|159~#1c1c1c|160~#949494|161~#424242|162~#ffffff|163~inset|164~0|165~0|166~10|167~0|171~#f70021|172~#ffffff|173~2|174~1|175~1|176~#ed8e9b|177~#ed8e9b|178~#52000b|179~#ffffff|180~#ffffff|181~0|182~0|183~0|184~#cc7ecc|185~inset|186~1|187~1|188~10|189~0|91~#000000|50~#000000|212~right|92~6|93~25|210~3|211~0|219~3|220~0|209~93|100~#ffffff|101~1|127~solid|102~7|103~7|104~7|105~7|94~#ffffff|95~|96~0|97~0|98~16|99~4|106~#ffffff|107~14|108~bold|109~normal|110~none|112~|113~#000000|114~1|115~-1|116~1|51~#666464|52~#666464|124~#fafafa|125~#000000|126~#ffffff|117~#ffffff|118~|119~0|120~0|121~18|122~7');