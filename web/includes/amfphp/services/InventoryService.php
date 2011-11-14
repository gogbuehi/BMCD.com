<?php
/**
 *	InventoryService
 */
require_once 'includes/services/file_services.php';
require_once AMFPHP_INCLUDE_PATH_PREPEND.'/services/vo/InventoryRecord.php';
require_once 'includes/services/file_services/external_data_services.php';
require_once 'models/Data_Inventory.php';

class InventoryService
{

	protected $fileService;
	protected $eds;
	protected $inventory;
	public function __construct() 
	{
		$this->fileService = new FileServices();
        $this->eds = new ExternalDataServices(ExternalDataServices::OFFSET_10_HOURS);
	}
	
	/*
	 * This is for use within this class only.
	 * Use "add" for public access
	 */
	protected function createRecord(InventoryRecord $dataObject) {
		//return $this->createObjectRecord(self::TABLE,$dataObject);
       return 0;
	}
	
	public function remove($sessionKey,InventoryRecord $dataObject) {
		//$this->updateObjectByField(self::TABLE,$dataObject,'id');
	}

	public function add($sessionKey,InventoryRecord $dataObject) {
		return 0;		
	}
	
	public function update($sessionKey,InventoryRecord $dataObject) {
		//$this->updateObjectByField(self::TABLE,$dataObject,'id');
	}
    
	public function getById($sessionKey,$id) {
		//return $this->loadObjectByField(self::TABLE,'id',$id,$dataObject);
        return $dataObject;
	}
	public function getByStockNumber($sessionKey,$stockNum) {
		$inventory = $this->getAll($sessionKey);
		foreach ($inventory as $key => $value) {
         	if($value->stockNumber == $stockNum){
				return $value; 
			}
		}
        return $dataObject;
	}
	
	public function getAll($sessionKey) {
			$eData = $this->eds->getExternalData(INVENTORY_AMF_URL,AMF_IDENTIFIER);
			$records = $this->processData($eData);
			$inventoryArray = array();
			foreach ($records as $key => $value) {
         	   array_push($inventoryArray,$value->getAmfPhpInstance());
			}
			return $inventoryArray;
	}
	
	
	protected	function processData($data) {
			$lines = explode("\n",$data);
			$fields = null;
			$recordsets = array();
			//Go line by line, exploding by tab
			foreach ($lines as $key => $value) {
				if (is_null($fields)) {
					$fields = explode("\t",$value);
					continue;
				}
				else {
					$values = explode("\t",$value);
					if (count($fields) == count($values))
						$recordsets[$key] = $this->processRecord($fields,$values);
				}
			}
			return $recordsets;
		}
	protected	function processRecord($fieldArray,$valueArray) {
			$recordArray = array();
			foreach($fieldArray as $key => $value) {
				if (!isset($valueArray[$key])) {
					$msg = "Value array does not have a value for key($key). Value Array DUMP:\n";
					foreach($valueArray as $aKey => $aValue)
						$msg.= "$aKey : $aValue\n";
					throw new Exception($msg);
				}
				$recordArray[trim($value)] = $valueArray[$key];
			}
			$record = new Data_Inventory(false);
			$record->loadData($recordArray);
			return $record;
		}
	
}
?>
