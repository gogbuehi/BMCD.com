--
-- Table structure for table `content_library_thumbnail`
--

CREATE TABLE IF NOT EXISTS `content_library_thumbnail` (
  `id` int(11) NOT NULL,
  `dt` datetime NOT NULL,
  `location` varchar(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- UPDATE 2/18/2009
ALTER TABLE  `content_library_thumbnail` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;