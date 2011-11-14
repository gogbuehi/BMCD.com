-- phpMyAdmin SQL Dump
-- version 3.0.0
-- http://www.phpmyadmin.net
--
-- Host: localhost
-- Generation Time: Oct 03, 2008 at 09:33 AM
-- Server version: 5.0.51
-- PHP Version: 5.2.6

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";

--
-- Database: `bmcd`
--

-- --------------------------------------------------------

--
-- Table structure for table `crops`
--

DROP TABLE IF EXISTS `crops`;
CREATE TABLE IF NOT EXISTS `crops` (
  `id` int(11) NOT NULL auto_increment,
  `dt` datetime NOT NULL COMMENT 'Default is always "NOW()"',
  `blnvalid` tinyint(1) NOT NULL default '1',
  `master_id` int(11) NOT NULL COMMENT 'Reference to "id" of the master in the "masters" table',
  `dimension_height` int(11) NOT NULL COMMENT 'The height of this crop',
  `dimension_width` int(11) NOT NULL COMMENT 'The width of this crop',
  `crop_location` varchar(50) NOT NULL COMMENT 'The file location of the crop',
  `short_description` varchar(200) default NULL,
  `scale` int(11) NOT NULL default '100' COMMENT 'Scale in % units',
  `rotation` float NOT NULL default '0' COMMENT 'Units in degrees',
  `offset_x` float NOT NULL default '0' COMMENT 'Units in pixels',
  `offset_y` float NOT NULL default '0' COMMENT 'Units in pixels',
  PRIMARY KEY  (`id`)
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COMMENT='Entries must be in the "photos" table first' AUTO_INCREMENT=1 ;
