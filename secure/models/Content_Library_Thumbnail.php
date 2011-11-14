<?php
require_once 'models/database_object.php';
/**
 * Description of Content_Library_Thumbnail
 *
 * @author Goodwin
 */
class Content_Library_Thumbnail extends DBObject {
    public $d_location;
    function __construct($value=null,$field='id') {
        parent::__construct($value, $field);
        if ($value !== FALSE) {
            $this->save();
        }
    }
    function setDefaultValues($value,$field) {
        $this->tLog->debug('Setting '.$this->getTable().' default values...');
        parent::setDefaultValues($value,$field);
        if (self::isNull($this->d_location)) {
            $this->d_location = '';
        }
    }
    function setLocation($location) {
        $this->d_location = $location;
        $this->save();
    }
}
?>
