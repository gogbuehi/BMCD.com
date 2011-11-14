<?php
/**
 *	StoreService
 */
require_once 'includes/services/file_services.php';
require_once AMFPHP_INCLUDE_PATH_PREPEND.'/services/vo/StoreRecord.php';
require_once 'models/Data_Store.php';

class StoreService
{

	protected $fileService;
	public function __construct() 
	{
		$this->fileService = new FileServices();
	}
	
	/*
	 * This is for use within this class only.
	 * Use "add" for public access
	 */
	protected function createRecord(StoreRecord $dataObject) {
		
        $dataRecord = new Data_Store($dataObject);
        return $dataRecord->getIdValue();
	}
	
	public function remove($sessionKey,StoreRecord $dataObject) {
        $dataObject->blnvalid = FALSE;
        $dataRecord = new Data_Store($dataObject);
        $dataRecord->save();
	}

	public function add($sessionKey,StoreRecord $dataObject) {
		$id = $this->createRecord($dataObject);
		$dataObject = $this->getById($sessionKey,$id);
		$this->update($sessionKey,$dataObject);
		return $id;		
	}
	
	public function update($sessionKey,StoreRecord $dataObject) {
		$dataRecord = new Data_Store($dataObject);
	}
    
	public function getByProductID($sessionKey,$id) {
		$record = new Data_Store($id,'productId');
        if ($record->isPersistent) {
            $dataRecord = $record->getAmfPhpInstance();
        }
        return $dataRecord;
	}
	public function getById($sessionKey,$id) {
		$record = new Data_Store($id);
        if ($record->isPersistent) {
            $dataRecord = $record->getAmfPhpInstance();
        }
        return $dataRecord;
	}
	
	public function getAll($sessionKey) {
		$record = new Data_Store(false);
        $requiredParams = array(
            'blnvalid' => true,
            'domain' => $_SERVER['SERVER_NAME']
        );
        $records = $record->getComplex($requiredParams);
		$dataRecords = array();
        foreach ($records as $key => $value) {
            array_push($dataRecords,$value->getAmfPhpInstance());
        }
        return $dataRecords;
	}
}
?>
