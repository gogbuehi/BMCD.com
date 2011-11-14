--
-- Table structure for table `page_file`
--

DROP TABLE IF EXISTS `page_file`;
CREATE TABLE IF NOT EXISTS `page_file` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `dt` datetime NOT NULL,
  `domain` varchar(30) NOT NULL,
  `uri` varchar(75) DEFAULT NULL,
  `page_name` varchar(30) NOT NULL COMMENT 'This coresponds to the file used for caching the page',
  `blnvalid` tinyint(1) NOT NULL DEFAULT '1',
  `use_decendent_uri` tinyint(1) NOT NULL DEFAULT '0' COMMENT 'Indicates whether decendent uri are used by this as well',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM  DEFAULT CHARSET=utf8 AUTO_INCREMENT=40 ;

--
-- Dumping data for table `page_file`
-- IMPORTANT NOTE: Be sure to replace "bmcd.loc" with whatever domain the SQL server will work with

INSERT INTO `page_file` (`id`, `dt`, `domain`, `uri`, `page_name`, `blnvalid`, `use_decendent_uri`) VALUES
(1, '2008-12-29 09:19:42', '901.bmcd.loc', '/about/general', 'AboutUsGeneral', 1, 0),
(2, '2008-12-29 09:19:42', '901.bmcd.loc', '/about', 'AboutUsGeneral', 1, 0),
(3, '2009-01-02 13:49:04', '901.bmcd.loc', '/about/contact_us', 'AboutContact', 1, 0),
(4, '2009-01-02 13:49:04', '901.bmcd.loc', '/about/history', 'AboutHistory', 1, 0),
(5, '2009-01-02 13:49:04', '901.bmcd.loc', '/about/our_team', 'AboutTeam', 1, 0),
(6, '2009-01-02 13:49:04', '901.bmcd.loc', '/about/testimonials', 'AboutTestimonials', 1, 0),
(7, '2009-01-02 13:49:04', '901.bmcd.loc', '/finance', 'FinancePrivacyPolicy', 1, 0),
(8, '2009-01-02 13:49:04', '901.bmcd.loc', '/finance/privacy_policy', 'FinancePrivacyPolicy', 1, 0),
(9, '2009-01-02 13:49:04', '901.bmcd.loc', '/finance/purchasing_options', 'FinancePurchasingOptions', 1, 0),
(10, '2009-01-02 13:49:04', '901.bmcd.loc', '/forms/quick_quote', 'QuickQuote', 1, 0),
(11, '2009-01-02 13:49:04', '901.bmcd.loc', '/forms/parts_request', 'PartsRequest', 1, 0),
(12, '2009-01-02 13:49:04', '901.bmcd.loc', '/parts_service', 'ServiceRequest', 1, 0),
(13, '2009-01-02 16:10:45', '901.bmcd.loc', '/', 'HomePage', 1, 0),
(14, '2009-01-02 16:10:45', '901.bmcd.loc', '/home', 'HomePage', 1, 0),
(16, '2009-01-14 08:12:13', '901.bmcd.loc', '/inventory', 'InventoryPage', 1, 1),
(17, '2009-01-18 21:51:24', '901.bmcd.loc', '/research', 'ModelLineupPage', 1, 1),
(18, '2009-01-24 12:53:49', '901.bmcd.loc', '/boutique', 'StorePage', 1, 1),
(19, '2009-01-24 14:52:36', '901.bmcd.loc', '/events', 'CalendarPage', 1, 1),
(20, '2009-01-25 17:55:16', '901.bmcd.loc', '/forms/quick_quote', 'QuickQuote', 1, 0),
(21, '2009-01-25 17:55:16', '901.bmcd.loc', '/forms/parts_request', 'PartsRequest', 1, 0),
(22, '2009-01-25 17:57:25', '901.bmcd.loc', '/parts_service', 'ServiceRequest', 1, 0),
(23, '2009-01-25 17:57:25', '901.bmcd.loc', '/forms/service_request', 'ServiceRequest', 1, 0),
(24, '2009-01-29 22:31:45', '999.bmcd.loc', '/home', 'HomePage', 1, 0),
(25, '2009-02-01 16:28:45', '999.bmcd.loc', '/inventory', 'InventoryPage', 1, 1),
(26, '2009-02-01 16:34:18', '999.bmcd.loc', '/research', 'ModelLineupPage', 1, 1),
(27, '2009-02-01 16:34:18', '999.bmcd.loc', '/boutique', 'StorePage', 1, 1),
(28, '2009-02-01 18:03:26', '999.bmcd.loc', '/about', 'AboutUsGeneral', 1, 0),
(29, '2009-02-01 18:03:26', '999.bmcd.loc', '/about/general', 'AboutUsGeneral', 1, 0),
(30, '2009-02-01 18:07:20', '999.bmcd.loc', '/about/contact_us', 'AboutContact', 1, 0),
(31, '2009-02-01 18:07:20', '999.bmcd.loc', '/about/history', 'AboutHistory', 1, 0),
(32, '2009-02-01 19:51:09', '999.bmcd.loc', '/finance', 'FinanceGeneral', 1, 0),
(33, '2009-02-01 19:51:09', '999.bmcd.loc', '/finance/general', 'FinanceGeneral', 1, 0),
(34, '2009-02-01 19:52:33', '999.bmcd.loc', '/finance/privacy_policy', 'FinancePrivacyPolicy', 1, 0),
(35, '2009-02-01 19:52:33', '999.bmcd.loc', '/forms/quick_quote', 'QuickQuote', 1, 0),
(36, '2009-02-01 19:54:07', '999.bmcd.loc', '/forms/parts_request', 'PartsRequest', 1, 0),
(37, '2009-02-01 19:54:07', '999.bmcd.loc', '/parts_service', 'ServiceRequest', 1, 0),
(38, '2009-02-01 19:54:52', '999.bmcd.loc', '/forms/service_request', 'ServiceRequest', 1, 0),
(39, '2009-02-01 20:59:46', '999.bmcd.loc', '/about/our_team', 'AboutTeam', 1, 0);

-- UPDATE 02/25/2009
UPDATE `page_file` SET `page_name` = 'ServiceRequestPage' WHERE `page_name` = 'ServiceRequest';

-- UPDATE 03/26/2009
-- This is an update to add a test page for testing the JS cache updating service
-- Be sure to change the `domain` value to match the domain the database is used for
INSERT INTO  `bmcd`.`page_file` (
`id` ,
`dt` ,
`domain` ,
`uri` ,
`page_name` ,
`blnvalid` ,
`use_decendent_uri`
)
VALUES (
NULL , NOW( ) ,  '901.bmcd.loc',  '/test/flash/cache',  'TestFlashCache',  '1',  '0'
);

--UPDATE 4/8/2009
-- Adding new page: SpecialsPage
INSERT INTO `bmcd`.`page_file` (`id`, `dt`, `domain`, `uri`, `page_name`, `blnvalid`, `use_decendent_uri`) VALUES (NULL, NOW(), '901.bmcd.loc', '/specials', 'SpecialsPage', '1', '0'), (NULL, NOW(), '999.bmcd.loc', '/specials', 'SpecialsPage', '1', '0');