--
-- Table structure for table `content_library_crop`
--

CREATE TABLE IF NOT EXISTS `content_library_crop` (
  `id` int(11) NOT NULL,
  `dt` datetime NOT NULL,
  `location` varchar(200) DEFAULT NULL,
  `width` int(11) DEFAULT NULL,
  `height` int(11) DEFAULT NULL,
  `scale` int(11) DEFAULT NULL,
  `rotation` float NOT NULL,
  `offset_x` float NOT NULL,
  `offset_y` float NOT NULL,
  `content_library_master` int(11) NOT NULL,
  `blnvalid` tinyint(1) NOT NULL DEFAULT '1',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- UPDATE 2/18/2009
ALTER TABLE  `content_library_crop` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;

ALTER TABLE  `content_library_crop` ADD  `description` VARCHAR( 200 ) NOT NULL AFTER  `location`;

-- UPDATE 2/19/2009
ALTER TABLE  `content_library_crop` ADD  `domain` ENUM(  'www.bmcd.loc',  '901.bmcd.loc',  '999.bmcd.loc' ) NULL DEFAULT NULL COMMENT  'The domain that this crop belongs to; Should match master';

-- UPDATE 4/13/2009
ALTER TABLE  `content_library_crop` ADD  `title` VARCHAR( 200 ) NOT NULL AFTER  `location`;
ALTER TABLE  `content_library_crop` ADD  `alternate` VARCHAR( 200 ) NOT NULL AFTER  `title`;