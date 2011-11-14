CREATE TABLE  `bmcd`.`user` (
`id` INT NOT NULL ,
`username` VARCHAR( 50 ) NOT NULL COMMENT  'Can be email or a username',
`password` VARCHAR( 32 ) NOT NULL ,
`permission` SMALLINT NOT NULL DEFAULT  '1' COMMENT  'Values defined in PHP object',
`dt` DATETIME NULL DEFAULT NULL ,
PRIMARY KEY (  `id` ) ,
UNIQUE (
`username`);

ALTER TABLE  `user` CHANGE  `password`  `password` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '34a87ccd2a8d6e3d3a766ae1258b22e2';

DROP TABLE IF EXISTS `user`;
CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL COMMENT 'Can be email or a username',
  `password` varchar(32) NOT NULL DEFAULT '34a87ccd2a8d6e3d3a766ae1258b22e2',
  `permission` smallint(6) NOT NULL DEFAULT '1' COMMENT 'Values defined in PHP object',
  `dt` datetime DEFAULT NULL,
  PRIMARY KEY (`id`),
  UNIQUE KEY `username` (`username`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8;
--UPDATE 3/27/2009
ALTER TABLE  `user` CHANGE  `id`  `id` INT( 11 ) NOT NULL AUTO_INCREMENT;
ALTER TABLE  `user` CHANGE  `password`  `password` VARCHAR( 32 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT '1c4a019c5d6a0cb0111fae4cc9a87e6d';

--UPDATE 4/2/2009
--Test user with password "PASSWORD"
-- NOTE: THIS SHOULD NOT BE USED ON LIVE
INSERT INTO `user` (`id`, `username`, `password`, `permission`, `dt`) VALUES
(1, 'test', '319f4d26e3c536b5dd871bb2c52e3178', 1, '2009-03-27 20:45:27');