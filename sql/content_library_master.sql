--
-- Table structure for table `content_library_master`
--

CREATE TABLE IF NOT EXISTS `content_library_master` (
  `id` int(11) NOT NULL,
  `location` varchar(100) DEFAULT NULL,
  `content_library_thumbnail` int(11) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `description` varchar(200) DEFAULT NULL,
  `scale` int(11) DEFAULT NULL,
  `rotation` float NOT NULL DEFAULT '0',
  `offset_x` float DEFAULT '0',
  `offset_y` float DEFAULT '0',
  `blnvalid` tinyint(1) DEFAULT '1',
  `dt` datetime NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- UPDATE 2/18/2009
ALTER TABLE  `content_library_master` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;

-- UPDATE 2/19/2009
ALTER TABLE  `content_library_master` ADD  `domain` ENUM(  'www.bmcd.loc',  '901.bmcd.loc',  '999.bmcd.loc' ) NULL DEFAULT NULL COMMENT  'The domain that this content belongs to';

-- UPDATE 4/13/2009
ALTER TABLE  `content_library_master` ADD  `title` VARCHAR( 200 ) NOT NULL AFTER  `location`;
ALTER TABLE  `content_library_master` ADD  `alternate` VARCHAR( 200 ) NOT NULL AFTER  `title`;