CREATE TABLE `bmcd`.`videos` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`dt` DATETIME NOT NULL ,
`blnvalid` BOOL NOT NULL ,
`location` VARCHAR( 100 ) NULL ,
`thumbnail_location` VARCHAR( 100 ) NULL ,
`width` INT NULL COMMENT 'Thumbnail width',
`height` INT NULL COMMENT 'Thumbnail height',
`description` VARCHAR( 100 ) NULL COMMENT 'Video description',
`scale` INT NOT NULL DEFAULT '100' COMMENT 'Unit in %',
`rotation` FLOAT NOT NULL DEFAULT '0' COMMENT 'Unit in degrees',
`offset_x` FLOAT NOT NULL DEFAULT '0' COMMENT 'Unit in pixels',
`offset_y` FLOAT NOT NULL DEFAULT '0' COMMENT 'Unit in pixels'
) ENGINE = MYISAM ;