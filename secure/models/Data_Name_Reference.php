<?php
require_once 'models/database_object.php';
require_once 'includes/amfphp/services/vo/NameReferenceRecord.php';

/**
 * Description of Data_Name_Reference
 *
 * @author Goodwin
 */
class Data_Name_Reference extends DBObject {
	
	public $d_name;
	public $d_name_string; 
	public $d_logo; 
   
	
	public $d_blnvalid;
    public $d_domain;

    function __construct($value=null,$field='id') {
        if ($value instanceof NameReferenceRecord) {
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
	
	     $this->d_name = '';
	     $this->d_name_string = ''; 
	     $this->d_logo = ''; 
	
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

    
    function loadDataFromAmfPhp(NameReferenceRecord $record) {
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

    

    function getAmfPhpInstance() {
        $data = $this->getFields();
        $dataRecord = new NameReferenceRecord();
        $dataRecord->loadData($data);
        return $dataRecord;
    }

}
?>