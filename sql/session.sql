CREATE TABLE  `bmcd`.`session` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`key` VARCHAR( 32 ) NOT NULL ,
`user_id` INT NULL COMMENT  'Corresponds to a User',
`expiration` DATETIME NOT NULL ,
`dt` DATETIME NOT NULL COMMENT  'Date the session was started',
UNIQUE (
`key`
);

ALTER TABLE  `session` ADD  `ip` VARCHAR( 12 ) NULL COMMENT  'If this does not match, create a new session';

DROP TABLE IF EXISTS `session`;
CREATE TABLE IF NOT EXISTS `session` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `key` varchar(32) NOT NULL,
  `user_id` int(11) DEFAULT NULL COMMENT 'Corresponds to a User',
  `expiration` datetime NOT NULL,
  `dt` datetime NOT NULL COMMENT 'Date the session was started',
  `ip` varchar(12) DEFAULT NULL COMMENT 'If this does not match, create a new session',
  PRIMARY KEY (`id`),
  UNIQUE KEY `key` (`key`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=6 ;

ALTER TABLE  `session` CHANGE  `user_id`  `user` INT( 11 ) NULL DEFAULT NULL COMMENT  'Corresponds to a User';