<?php
require_once 'includes/services/file_services.php';

/**
 * Description of caching_services
 *
 * @author Goodwin Ogbuehi
 */
class CachingServices extends FileServices {
    function __construct() {
        parent::__construct();
    }

    function saveDataToFile($filename,$data) {
        return parent::saveDataToFileFull($filename, $data, CACHE_DIRECTORY,true);
    }

    function getDataFromFile($filename) {
        return parent::getDataFromFile($filename, CACHE_DIRECTORY);
    }

    function dataFileExists($filename) {
        return parent::dataFileExists($filename, CACHE_DIRECTORY);
    }
}
?>
