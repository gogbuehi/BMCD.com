<?php
/**
 *	ModelService
 */
require_once 'includes/services/file_services.php';
require_once AMFPHP_INCLUDE_PATH_PREPEND.'/services/vo/ModelRecord.php';
require_once 'models/Data_Model_Info.php';

class ModelService
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
	protected function createRecord(ModelRecord $dataObject) {
		
        $dataRecord = new Data_Model_Info($dataObject);
        return $dataRecord->getIdValue();
	}
	
	public function remove($sessionKey,ModelRecord $dataObject) {
        $dataObject->blnvalid = FALSE;
        $dataRecord = new Data_Model_Info($dataObject);
        $dataRecord->save();
	}

	public function add($sessionKey,ModelRecord $dataObject) {
		$id = $this->createRecord($dataObject);
		$dataObject = $this->getById($sessionKey,$id);
		$this->update($sessionKey,$dataObject);
		return $id;		
	}
	
	public function update($sessionKey,ModelRecord $dataObject) {
		$dataRecord = new Data_Model_Info($dataObject);
	}
    
	public function getById($sessionKey,$id) {
		$record = new Data_Model_Info($id);
        if ($record->isPersistent) {
            $dataRecord = $record->getAmfPhpInstance();
        }
        return $dataRecord;
	}
	
	public function getByModel($sessionKey,$make,$model,$submodel) {
		$record = new Data_Model_Info(array($make,$model,$submodel),array('make','model','submodel'));
        if ($record->isPersistent) {
            $dataRecord = $record->getAmfPhpInstance();
        }
        return $dataRecord;
	}
	
	public function getAll($sessionKey) {
		$record = new Data_Model_Info(false);
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
