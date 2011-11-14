<?php
/**
 *	NameReferenceService
 */
require_once 'includes/services/file_services.php';
require_once AMFPHP_INCLUDE_PATH_PREPEND.'/services/vo/NameReferenceRecord.php';
require_once 'models/Data_Name_Reference.php';

class NameReferenceService
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
	protected function createRecord(NameReferenceRecord $dataObject) {
		
        $dataRecord = new Data_Name_Reference($dataObject);
        return $dataRecord->getIdValue();
	}
	
	public function remove($sessionKey,NameReferenceRecord $dataObject) {
        $dataObject->blnvalid = FALSE;
        $dataRecord = new Data_Name_Reference($dataObject);
        $dataRecord->save();
	}

	public function add($sessionKey,NameReferenceRecord $dataObject) {
		$id = $this->createRecord($dataObject);
		$dataObject = $this->getById($sessionKey,$id);
		$this->update($sessionKey,$dataObject);
		return $id;		
	}
	
	public function update($sessionKey,NameReferenceRecord $dataObject) {
		$dataRecord = new Data_Name_Reference($dataObject);
	}
    
	public function getById($sessionKey,$id) {
		$record = new Data_Name_Reference($id);
        if ($record->isPersistent) {
            $dataRecord = $record->getAmfPhpInstance();
        }
        return $dataRecord;
	}
	
	public function getAll($sessionKey) {
		$record = new Data_Name_Reference(false);
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
