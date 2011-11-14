<?php
require_once 'models/database_object.php';
require_once 'includes/amfphp/services/vo/ModelRecord.php';
require_once 'models/Data_Name_Reference.php';

/**
 * Description of Data_Model_Info
 *
 * @author Goodwin
 */
class Data_Model_Info extends DBObject {
	
	public $d_make; 	
	public $d_model; 	
	public $d_submodel; 	
	public $d_description; 	
	public $d_videos; 	
	public $d_images; 	
	public $d_engine; 	
	public $d_displacement; 	
	public $d_horsepower; 	
	public $d_acceleration; 	
	public $d_topSpeed; 	
	public $d_msrp; 	
	public $d_brochure; 	
	public $d_configurator; 	
	public $d_manufacture;
	public $d_pageDescription;
	public $d_pageKeywords; 
	public $d_visible;
	
    public $d_blnvalid;
    public $d_domain;

    function __construct($value=null,$field='id') {
        if ($value instanceof ModelRecord) {
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
		
	     $this->d_make = ''; 	
	     $this->d_model = ''; 	
	     $this->d_submodel = ''; 	
	     $this->d_description = ''; 	
	     $this->d_videos = ''; 	
	     $this->d_images = ''; 	
	     $this->d_engine = ''; 	
	     $this->d_displacement = ''; 	
	     $this->d_horsepower = ''; 	
	     $this->d_acceleration = ''; 	
	     $this->d_topSpeed = ''; 	
	     $this->d_msrp = ''; 	
	     $this->d_brochure = ''; 	
	     $this->d_configurator = ''; 	
	     $this->d_manufacture = '';
	     $this->d_pageDescription = '';
	     $this->d_pageKeywords = '';
	     $this->d_visible = true;
	
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
            default:
                return parent::revertValue($key, $value);
        }
        return self::NULL;
    }

    function revertKey($key) {
        switch($key) {
            default:
                return parent::revertKey($key);
        }
    }

    function loadDataFromAmfPhp(ModelRecord $record) {
        $transientData = $record->getFields();
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
        $this->d_domain = $_SERVER['SERVER_NAME'];

    }

    function setUrlFromRecord(ModelRecord &$record) {
		$make = new Data_Name_Reference($record->make,'name');
		$model = new Data_Name_Reference($record->model,'name');
		$submodel = new Data_Name_Reference($record->submodel,'name');
		$record->url = URL_SEPARATOR.'research'.URL_SEPARATOR.'model_lineup'.URL_SEPARATOR.$make->d_name_string.URL_SEPARATOR.$model->d_name_string.URL_SEPARATOR.$submodel->d_name_string;
	}
	
    function getAmfPhpInstance() {
        $data = $this->getFields();
        $dataRecord = new ModelRecord();
        $dataRecord->loadData($data);
		$this->setUrlFromRecord($dataRecord);
        return $dataRecord;
    }

}
?>