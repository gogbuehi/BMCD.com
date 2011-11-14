CREATE TABLE IF NOT EXISTS `content_library_pdf` (
  `id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY,
  `dt` datetime NOT NULL,
  `location` varchar(200) DEFAULT NULL,
  `title` varchar(200) DEFAULT NULL,
  `domain` ENUM(  'www.bmcd.com',  '901.bmcd.com',  '999.bmcd.com' ) NOT NULL ,
  `blnvalid` tinyint(1) NOT NULL DEFAULT '1'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

