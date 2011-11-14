--
-- Table structure for table `page_edit`
--

DROP TABLE IF EXISTS `page_edit`;
CREATE TABLE IF NOT EXISTS `page_edit` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dt` datetime NOT NULL,
  `page_file` varchar(30) NOT NULL COMMENT 'The page_name of the Page_File',
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8;

-- 1/13/2009
ALTER TABLE  `page_edit` ADD  `hasDynamicContent` BOOL NOT NULL DEFAULT  '0' COMMENT  'Indicates whether this page has dynamic content';
ALTER TABLE  `page_edit` CHANGE  `hasDynamicContent`  `has_dynamic_content` TINYINT( 1 ) NOT NULL DEFAULT  '0' COMMENT 'Indicates whether this page has dynamic content';

-- 1/30/2009
-- IMPORTANT NOTE: Before you run these statements, be sure to change the base domain
-- to match the environment that this database will interact with (i.e. 'bmcd.loc' -> 'hphantdev.com')
ALTER TABLE  `page_edit` ADD  `domain` ENUM(  'www.bmcd.loc',  '901.bmcd.loc',  '999.bmcd.loc' ) NOT NULL DEFAULT  '901.bmcd.loc' COMMENT 'Keeps track of the domain that a cached page belongs to'
ALTER TABLE  `page_edit` CHANGE  `domain`  `domain` ENUM(  'www.bmcd.loc',  '901.bmcd.loc',  '999.bmcd.loc' ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  'Keeps track of the domain that a cached page belongs to';

-- 5/26/2009
-- Adding user tracking to the table
ALTER TABLE `page_edit` ADD `user` INT NULL DEFAULT NULL COMMENT 'Corresponds to the user that made this edit';
