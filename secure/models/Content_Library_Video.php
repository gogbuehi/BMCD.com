<?php
require_once 'models/database_object.php';
require_once 'models/Content_Library_Thumbnail.php';
require_once 'includes/amfphp/services/vo/Video.php';

/**
 * Description of Content_Library_Video
 *
 * @author Goodwin
 */
class Content_Library_Video extends DBObject {
    public $d_location;
	public $d_o_content_library_thumbnail;
	public $d_width;
	public $d_height;
	public $d_title; //A.K.A. "title"
	public $d_alternate; //A.K.A. "alternate"
	public $d_description;
	public $d_scale;
	public $d_rotation;
	public $d_offset_x;
	public $d_offset_y;
    public $d_offset_seconds;
    public $d_blnvalid;

    public $d_domain;

    function __construct($value=null,$field='id') {
        if ($value instanceof Video) {
            parent::__construct(false);
            $this->loadDataFromAmfPhp($value);
        }
        else {
            parent::__construct($value, $field);
        }
        if ($value !== FALSE) {
            $this->save();
        }
    }
    function setDefaultValues($value,$field) {
        $this->tLog->debug('Setting '.$this->getTable().' default values...');
        parent::setDefaultValues($value,$field);
        $this->d_location = '';
        $this->d_title = '';
        $this->d_alternate = '';
        $this->d_description = '';
        $this->d_width = 0;
        $this->d_height = 0;
        $this->d_rotation = 0;
        $this->d_scale = 1;
        $this->d_offset_x = 0;
        $this->d_offset_y = 0;
        $this->d_blnvalid = true;
        $this->d_domain = $_SERVER['SERVER_NAME'];
    }

    function validateValue($key,$value) {
        switch($key) {
            case 'dt':
                if ($value == '') {
                    return parent::validateValue($key,$_SERVER['REQUEST_TIME']);
                }
                else {
                    return parent::validateValue($key, $value);
                }
                break;
            default:
                return parent::validateValue($key, $value);
        }
    }
    function revertValue($key,$value) {
        switch($key) {
            case 'id':
                if ($value === -1 || $value === 0) {
                    return self::NULL;
                }
                else {
                    return parent::revertValue($key, $value);
                }
                break;
            case 'dt':
                if ($value == '') {
                    return $_SERVER['REQUEST_TIME'];
                }
                else {
                    return parent::revertValue($key, $value);
                }
                break;
            case 'thumbnail_location':
                if (!self::isNull($value)) {
                    return new Content_Library_Thumbnail($value,'location');
                }
                break;
            case 'content_library_thumbnail':
                //Only valid for "id"s
                if (!self::isNull($value)) {
                    return new Content_Library_Thumbnail($value);
                }
                break;
            default:
                return parent::revertValue($key, $value);
        }
        return self::NULL;
    }

    function revertKey($key) {
        switch($key) {
            case 'thumbnail_location':
                return 'content_library_thumbnail';
                break;
            default:
                return parent::revertKey($key);
        }
    }

    function loadDataFromAmfPhp(Video $video) {
        $transientData = $video->getFields();
        $transientData = self::cleanupTransientData($transientData);
        $transientId = $transientData['id'];
        if (!self::isNull($this->revertValue('id',$transientId))) {
            //This object has an ID; Go ahead an load it
            $this->loadObjectByField($this->getTable(), 'id', $transientId, $this);
            if (!$this->isPersistent){
                $msg = 'AMFPHP is trying to save data for an object that is not in the database:'.$this->__toString();
                $this->tLog->error($msg);
                throw new Exception($msg);
            }
        }
        $this->loadData($transientData);
        //Figure out what thumbnail location is being used
        $thumbnailLocation = $transientData['thumbnail_location'];
        if ($this->d_o_content_library_thumbnail instanceof Content_Library_Thumbnail) {
            $this->d_o_content_library_thumbnail->setLocation($thumbnailLocation);
        }
        else {
            $this->d_o_content_library_thumbnail = new Content_Library_Thumbnail($thumbnailLocation,'location');
        }
        $this->d_domain = $_SERVER['SERVER_NAME'];

    }



    function getAmfPhpInstance() {
        $data = $this->getFields();
        $video = new Video();
        $video->loadData($data);
        $video->thumbnailLocation = $this->d_o_content_library_thumbnail->d_location;
        return $video;
    }
}
?>
