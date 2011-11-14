CREATE TABLE `bmcd`.`masters` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`dt` DATETIME NOT NULL ,
`blnvalid` BOOL NOT NULL DEFAULT '1',
`master_location` VARCHAR( 50 ) NOT NULL ,
`thumbnail_location` VARCHAR( 50 ) NULL ,
`dimension_height` INT NULL ,
`dimension_width` INT NULL ,
`short_description` VARCHAR( 200 ) NULL
) ENGINE = MYISAM COMMENT = 'Table for Content Library';

ALTER TABLE `masters` ADD `scale` INT NOT NULL DEFAULT '100' COMMENT 'Scale in % units',
ADD `rotation` FLOAT NOT NULL DEFAULT '0' COMMENT 'Units in degrees',
ADD `offset_x` FLOAT NOT NULL DEFAULT '0' COMMENT 'Units in pixels',
ADD `offset_y` FLOAT NOT NULL DEFAULT '0' COMMENT 'Units in pixels';

INSERT INTO `masters` ( `id` , `dt` , `blnvalid` , `master_location` , `thumbnail_location` , `dimension_height` , `dimension_width` , `short_description` ,  `scale` , `rotation` , `offset_x` , `offset_y` ) 
VALUES (
NULL , '2008-09-04 21:30:04', '1', '/images/bmcdlogo.png', '/images/jaguarlogo.png', '128', '139', 'BMCD Logo', '100', '0', '0', '0'
);

UPDATE `bmcd`.`masters` SET `master_location` = CONCAT('http://',`master_location`) WHERE `master_location` NOT LIKE 'http://%';
UPDATE `bmcd`.`masters` SET `thumbnail_location` = CONCAT('http://',`thumbnail_location`) WHERE `thumbnail_location` NOT LIKE 'http://%';