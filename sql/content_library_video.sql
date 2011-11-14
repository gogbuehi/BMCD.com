CREATE TABLE  `content_library_video` (
`id` INT NOT NULL AUTO_INCREMENT PRIMARY KEY ,
`location` VARCHAR( 100 ) NULL DEFAULT NULL COMMENT  'The URL of the video''s location',
`content_library_thumbnail` INT NULL DEFAULT NULL COMMENT  'The ID of the associated thumbnail',
`width` INT NULL DEFAULT NULL ,
`height` INT NULL DEFAULT NULL ,
`description` VARCHAR( 200 ) NULL DEFAULT NULL ,
`scale` INT NULL ,
`offset_x` FLOAT NOT NULL DEFAULT  '0',
`offset_y` FLOAT NOT NULL DEFAULT  '0',
`offset_seconds` FLOAT NOT NULL DEFAULT  '0',
`domain` ENUM(  'www.bmcd.loc',  '901.bmcd.loc',  '999.bmcd.loc' ) NOT NULL ,
`dt` DATETIME NOT NULL ,
`blnvalid` BOOL NOT NULL DEFAULT  '1'
) ENGINE = INNODB;

-- UPDATE 3/31/2009
ALTER TABLE  `content_library_video` ADD  `rotation` FLOAT NOT NULL DEFAULT  '0' AFTER  `scale`;

-- UPDATE 4/13/2009
ALTER TABLE  `content_library_video` ADD  `title` VARCHAR( 200 ) NOT NULL AFTER  `location`;
ALTER TABLE  `content_library_video` ADD  `alternate` VARCHAR( 200 ) NOT NULL AFTER  `title`;