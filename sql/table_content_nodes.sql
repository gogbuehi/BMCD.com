CREATE TABLE `bmcd`.`content_nodes` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`dt` DATETIME NULL DEFAULT NULL ,
`blnvalid` BOOL NOT NULL ,
`class` VARCHAR( 30 ) NULL DEFAULT NULL ,
`next` INT NULL DEFAULT NULL COMMENT 'Next Sibling Node ID',
`inner` INT NULL DEFAULT NULL COMMENT 'First Child Node ID',
`content` TEXT NULL DEFAULT NULL COMMENT 'Text content',
`parent` INT NULL DEFAULT NULL COMMENT 'Parent Node ID'
) ENGINE = MYISAM ;

ALTER TABLE `content_nodes` ADD `tag` VARCHAR( 20 ) NOT NULL AFTER `blnvalid` ;
ALTER TABLE `content_nodes` ADD `page_id` INT NOT NULL ;
ALTER TABLE `content_nodes` ADD `attribute_id` INT NULL DEFAULT NULL AFTER `page_id` ;