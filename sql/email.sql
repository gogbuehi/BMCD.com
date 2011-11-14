CREATE TABLE `email` (
  `id` int(11) NOT NULL auto_increment,
  `dt` datetime NOT NULL,
  `to` varchar(50) default NULL,
  `cc` varchar(50) default NULL,
  `from` varchar(50) default NULL,
  `subject` varchar(100) default NULL,
  `template` varchar(50) default NULL COMMENT 'The name of the template file',
  `form_data` text COMMENT 'Delimited values',
  `email_sent` tinyint(1) NOT NULL default '0' COMMENT 'Tracks if the email was sent',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8;

-- Update: 2/2/2009
ALTER TABLE  `email` CHANGE  `template`  `template` VARCHAR( 200 ) CHARACTER SET utf8 COLLATE utf8_general_ci NULL DEFAULT NULL COMMENT 'The name of the template file'