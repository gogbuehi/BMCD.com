<?php
require_once 'models/database_object.php';
require_once 'models/Content_Library_Master.php';
require_once 'includes/amfphp/services/vo/Crop.php';

/**
 * Description of Content_Library_Crop
 *
 * @author Goodwin
 */
class Content_Library_Crop extends DBObject {
    public $d_location; //The file location of the crop
	public $d_title; //A.K.A. "title"
	public $d_alternate; //A.K.A. "alternate"
	public $d_description; //A.K.A. "shortDescription"
	public $d_width; //A.K.A. "dimensionWidth"
	public $d_height; //A.K.A. "dimensionHeight"
	public $d_scale;
	public $d_rotation;
	public $d_offset_x;
	public $d_offset_y;
	public $d_o_content_library_master; //A.K.A. "masterId"
    public $d_blnvalid;

    public $d_domain;

    function __construct($value=null,$field='id') {
        if ($value instanceof Crop) {
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
            case 'content_library_master':
                if (!self::isNull($value)) {
                    return new Content_Library_Master($value);
                }
                break;
            default:
                return parent::revertValue($key, $value);
        }
    }
    function loadDataFromAmfPhp(Crop $crop) {
        $transientData = $crop->getFields();
        $transientData = self::cleanupTransientData($transientData);
        $this->loadData($transientData);
        $this->d_domain = $_SERVER['SERVER_NAME'];
    }

    function getAmfPhpInstance() {
        $data = $this->getFields();
        $crop = new Crop();
        $crop->loadData($data);
        $crop->masterId = $this->d_o_content_library_master->id;
        return $crop;
    }
}
?>
