<?php
//CONSTANTS
define('URL_SEPARATOR','/');

//FILE AND DIRECTORY SERVER LOCATIONS
define('LOG_DIRECTORY',"/var/www/bmcd/logs");
define('LOG_BASE_FILENAME','php.log');
define('LOG_LEVEL',0);
define('LOG_ALERT_EMAIL','dont-send-email@bmcdloc');

define('FTP_DIRECTORY',"/var/www/bmcd/ftp");
define('CONTENT_DIRECTORY',"/var/www/bmcd/content");

define('TEMP_DIRECTORY',"temp");

define('IMAGE_DIRECTORY',"images");
define('IMAGE_BASE_FILENAME','image');
define('IMAGE_EXTENSION','.png');

define('PDF_DIRECTORY',"pdfs");
define('PDF_BASE_FILENAME','pdf');
define('PDF_EXTENSION','pdf');
	
define('VIDEO_DIRECTORY',"videos");
define('VIDEO_BASE_FILENAME','video');
define('VIDEO_EXTENSION','flv');

define('DATA_DIRECTORY','text');
define('EMAILS_DIRECTORY','emails');
define('CACHE_DIRECTORY','cache');

//Decide whether emails should be sent out or not
define('ALLOW_EMAILS',false);

//Todo: Video Upload FTP Dir

//MYSQL CONSTANTS
define('MYSQL_SERVER','localhost');
define('MYSQL_PORT','3306');
define('MYSQL_ROOT_USER','root');
define('MYSQL_ROOT_PASSWORD','admin');
define('MYSQL_DEFAULT_DB','bmcd');

//HOST CONSTANTS
define('HOSTNAME','bmcdloc');
define('CONTENT','content.bmcdloc');
define('SUBDOMAIN_999','999.bmcdloc');
define('SUBDOMAIN_901','901.bmcdloc');

//EXTERNAL LOCATIONS
define('INVENTORY_901_URL','http://'.CONTENT.URL_SEPARATOR.DATA_DIRECTORY.URL_SEPARATOR.'data_feed.txt');
define('INVENTORY_999_URL','http://'.CONTENT.URL_SEPARATOR.DATA_DIRECTORY.URL_SEPARATOR.'data_feed_999.txt');
define('CALENDAR_901_URL','http://'.CONTENT.URL_SEPARATOR.DATA_DIRECTORY.URL_SEPARATOR.'events_calendar_901.txt');
define('CALENDAR_999_URL','http://'.CONTENT.URL_SEPARATOR.DATA_DIRECTORY.URL_SEPARATOR.'events_calendar_999.txt');
define('STORE_901_URL','http://'.CONTENT.URL_SEPARATOR.DATA_DIRECTORY.URL_SEPARATOR.'store_901.txt');
define('STORE_999_URL','http://'.CONTENT.URL_SEPARATOR.DATA_DIRECTORY.URL_SEPARATOR.'store_999.txt');
define('MODEL_LINEUP_901_URL','http://'.CONTENT.URL_SEPARATOR.DATA_DIRECTORY.URL_SEPARATOR.'model_lineup_901.txt');
define('MODEL_LINEUP_999_URL','http://'.CONTENT.URL_SEPARATOR.DATA_DIRECTORY.URL_SEPARATOR.'model_lineup_999.txt');
define('MODEL_LINEUP_REF_901_URL','http://'.CONTENT.URL_SEPARATOR.DATA_DIRECTORY.URL_SEPARATOR.'model_lineup_ref_901.txt');
define('MODEL_LINEUP_REF_999_URL','http://'.CONTENT.URL_SEPARATOR.DATA_DIRECTORY.URL_SEPARATOR.'model_lineup_ref_901.txt');
//define('INVENTORY_901_URL','http://content.dealerfusion.com/gen_feed/686/data_feed.txt');

//ANALYTICS
define('TRACK_ANALYTICS',false);
define('GOOGLE_ANALYITCS_ID','');
define('GOOGLE_ANALYTICS_901_ID','');
define('GOOGLE_ANALYTICS_999_ID','');
define('CLICKY_ANALYTICS_ID','');
define('CLICKY_ANALYTICS_901_ID','');
define('CLICKY_ANALYTICS_999_ID','');

//AMFPHP CONSTANTS
define("PRODUCTION_SERVER", false);
define('AMFPHP_INCLUDE_PATH_PREPEND','includes/amfphp');
define('WEB_901_INCLUDE_PATH',"/var/www/bmcd/web:.:/var/www/bmcd/901:/var/www/bmcd/secure:/var/www/bmcd/content/cache");
define('WEB_999_INCLUDE_PATH',"/var/www/bmcd/web:.:/var/www/bmcd/999:/var/www/bmcd/secure:/var/www/bmcd/content/cache");

//REQUIRED CLASSES
require_once 'includes/debug/log.php';
$tLog = new Log();
//$tLog->info('Request URI: '.$_SERVER['REQUEST_URI']);
//$tLog->info('Server Request: '.$_SERVER['SERVER_NAME']);

session_start();
?>