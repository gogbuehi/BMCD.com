<?php
require_once 'models/database_object.php';
require_once 'includes/amfphp/services/vo/StoreRecord.php';

/**
 * Description of Data_Store
 *
 * @author Goodwin
 */
class Data_Store extends DBObject {
	public $d_productId;
	public $d_brand;
	public $d_productNumber;
	public $d_title;
	public $d_price;
	public $d_size;
	public $d_color;
	public $d_mfca;
	public $d_images;
	public $d_thumb;
	public $d_sale;
	public $d_shortDescription;
	public $d_longDescription;
	public $d_category;
	public $d_pageDescription;
	public $d_pageKeywords; 
	public $d_visible;
	
	
    public $d_blnvalid;
    public $d_domain;

    function __construct($value=null,$field='id') {
        if ($value instanceof StoreRecord) {
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
        
	     $this->d_productId = '';
	     $this->d_brand = '';
	     $this->d_productNumber = '';
	     $this->d_title = '';
	     $this->d_price = '';
	     $this->d_size = '';
	     $this->d_color = '';
	     $this->d_mfca = '';
	     $this->d_images = '';
	     $this->d_thumb = '';
	     $this->d_sale = '';
	     $this->d_shortDescription = '';
	     $this->d_longDescription = '';
	     $this->d_category = '';
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

    
    function loadDataFromAmfPhp(StoreRecord $record) {
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


	function setUrlFromRecord(StoreRecord &$record) {
		$record->url = URL_SEPARATOR.'boutique'.URL_SEPARATOR.str_replace(' ','_',strtolower($record->brand)).URL_SEPARATOR.str_replace(' ','_',strtolower($record->productId));
	}
	
    function getAmfPhpInstance() {
        $data = $this->getFields();
        $dataRecord = new StoreRecord();
        $dataRecord->loadData($data);
		$this->setUrlFromRecord($dataRecord);
        return $dataRecord;
    }

}
?>