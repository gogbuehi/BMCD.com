<?php
require_once 'models/database_object.php';
require_once 'includes/amfphp/services/vo/InventoryRecord.php';

/**
 * Description of Data_Inventory
 *
 * @author Goodwin
 */
class Data_Inventory extends DBObject {
	public $d_url;
	public $d_Dealership;
	public $d_UniqueID;
	public $d_Year;
	public $d_Make;
	public $d_Model;
	public $d_VIN;
	public $d_StockNumber;
	public $d_Engine;
	public $d_Transmission;
	public $d_Description;
	public $d_Mileage;
	public $d_Price;
	public $d_Color;
	public $d_DealerAddress;
	public $d_DealerCity;
	public $d_DealerState;
	public $d_DealerZipcode;
	public $d_DealerPhone;
	public $d_EmailLeadsTo;
	public $d_Equipment;
	public $d_DealerMessage;
	public $d_Certified;
	public $d_RetailPrice;
	public $d_DealerBlurb;
	public $d_MultiplePhotos;
	public $d_HighOctane;
	public $d_HighOctane360;
	public $d_HighOctaneMultiPhotos;
	public $d_AddDate;
	public $d_PhotoURL;
	
	
    public $d_blnvalid;
    public $d_domain;
	
    function __construct($value=null,$field='id') {
        if ($value instanceof InventoryRecord) {
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
	
	     $this->d_url = '';
	     $this->d_Dealership = '';
	     $this->d_UniqueID = '';
	     $this->d_Year = '';
	     $this->d_Make = '';
	     $this->d_Model = '';
	     $this->d_VIN = '';
	     $this->d_StockNumber = '';
	     $this->d_Engine = '';
	     $this->d_Transmission = '';
	     $this->d_Description = '';
	     $this->d_Mileage = '';
	     $this->d_Price = '';
	     $this->d_Color = '';
	     $this->d_DealerAddress = '';
	     $this->d_DealerCity = '';
	     $this->d_DealerState = '';
	     $this->d_DealerZipcode = '';
	     $this->d_DealerPhone = '';
	     $this->d_EmailLeadsTo = '';
	     $this->d_Equipment = '';
	     $this->d_DealerMessage = '';
	     $this->d_Certified = '';
	     $this->d_RetailPrice = '';
	     $this->d_DealerBlurb = '';
	     $this->d_HighOctane = '';
	     $this->d_HighOctane360 = '';
	     $this->d_HighOctaneMultiPhotos = '';
	     $this->d_MultiplePhotos = '';
	     $this->d_AddDate = '';
	     $this->d_PhotoURL = '';

	
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

    
    function loadDataFromAmfPhp(InventoryRecord $record) {
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

    
	function setUrlFromRecord(InventoryRecord &$record) {
		$record->url = URL_SEPARATOR.'inventory'.URL_SEPARATOR.str_replace(' ','_',strtolower($record->make)).URL_SEPARATOR.str_replace(' ','_',strtolower($record-model)).URL_SEPARATOR.$record->vin;
	}

    function getAmfPhpInstance() {
        $data = $this->getFields();
        $dataRecord = new InventoryRecord();
        $dataRecord->loadData($data);
		$this->setUrlFromRecord($dataRecord);
        return $dataRecord;
    }

}
?>