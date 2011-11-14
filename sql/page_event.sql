CREATE TABLE  `bmcd`.`page_event` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`dt` DATETIME NOT NULL ,
`session` VARCHAR( 32 ) NOT NULL ,
`uri` VARCHAR( 75 ) NULL DEFAULT NULL
) ENGINE = INNODB;

DROP TABLE IF EXISTS `page_event`;
CREATE TABLE IF NOT EXISTS `page_event` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dt` datetime NOT NULL,
  `session` varchar(32) NOT NULL,
  `uri` varchar(75) DEFAULT NULL,
  `domain` varchar(30) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=10 ;

ALTER TABLE  `page_event` ADD  `status` SMALLINT NOT NULL DEFAULT  '200' COMMENT 'Page Status. Checks for 404s mainly';


-- CLEANUP ON LIVE: FEBRUARY 4, 2009
-- Deleted rows: 84836 (Query took 0.7447 sec)
DELETE 
FROM  `page_event` 
WHERE  `dt` <  '2009-02-03 00:00:00'