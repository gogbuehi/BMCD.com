CREATE TABLE `bmcd`.`pages` (
`id` INT NOT NULL ,
`dt` DATETIME NULL DEFAULT NULL ,
`blnvalid` BOOL NOT NULL ,
`name` VARCHAR( 50 ) NOT NULL ,
`title` VARCHAR( 50 ) NOT NULL ,
PRIMARY KEY ( `id` )
) ENGINE = MYISAM ;

ALTER TABLE `pages` CHANGE `id` `id` INT( 11 ) NOT NULL AUTO_INCREMENT ;