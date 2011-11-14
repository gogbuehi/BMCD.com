<?php
require_once 'models/database_object.php';
require_once 'includes/amfphp/services/vo/CalendarRecord.php';

/**
 * Description of Data_Calendar
 *
 * @author Goodwin
 */
class Data_Calendar extends DBObject {
	
	public $d_title;
	public $d_blurb; 
	public $d_description; 
	public $d_startTime; 
	public $d_endTime; 
	public $d_date; 
	public $d_map; 
	public $d_locationName; 
	public $d_street; 
	public $d_city; 
	public $d_state; 
	public $d_thumb; 
	public $d_images; 
	public $d_zip;
	public $d_pageDescription;
	public $d_pageKeywords; 
	public $d_visible;	
   
	public $d_blnvalid;
    public $d_domain;

    function __construct($value=null,$field='id') {
        if ($value instanceof CalendarRecord) {
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
	
	     $this->d_title = '';
	     $this->d_blurb = ''; 
	     $this->d_description = ''; 
	     $this->d_startTime = ''; 
	     $this->d_endTime = ''; 
	     $this->d_date = ''; 
	     $this->d_map = ''; 
	     $this->d_locationName = ''; 
	     $this->d_street = ''; 
	     $this->d_city = ''; 
	     $this->d_state = ''; 
	     $this->d_thumb = ''; 
	     $this->d_images = ''; 
	     $this->d_zip = '';
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

    
    function loadDataFromAmfPhp(CalendarRecord $record) {
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

	function setUrlFromRecord(CalendarRecord &$record) {
			$d = split('/',$record->date);
		$record->url = URL_SEPARATOR.'events'.URL_SEPARATOR.$d[2].URL_SEPARATOR.$d[0].URL_SEPARATOR.$d[1].URL_SEPARATOR.$record->id;
	}

    function getAmfPhpInstance() {
        $data = $this->getFields();
        $dataRecord = new CalendarRecord();
        $dataRecord->loadData($data);
		$this->setUrlFromRecord($dataRecord);
        return $dataRecord;
    }

}
?>