<?php
/**
 *	DataFilterService
 */
require_once 'includes/services/file_services.php';
require_once AMFPHP_INCLUDE_PATH_PREPEND.'/services/vo/DataFilter.php';
require_once 'models/Data_Filters.php';

class DataFilterService
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
	protected function createRecord(DataFilter $dataObject) {
		
        $dataRecord = new Data_Filters($dataObject);
        return $dataRecord->getIdValue();
	}
	
	public function remove($sessionKey,DataFilter $dataObject) {
        $dataObject->blnvalid = FALSE;
        $dataRecord = new Data_Filters($dataObject);
        $dataRecord->save();
	}

	public function add($sessionKey,DataFilter $dataObject) {
		$id = $this->createRecord($dataObject);
		$dataObject = $this->getById($sessionKey,$id);
		$this->update($sessionKey,$dataObject);
		return $id;		
	}
	
	public function update($sessionKey,DataFilter $dataObject) {
		$dataRecord = new Data_Filters($dataObject);
	}
    
	public function getById($sessionKey,$id) {
		$record = new Data_Filters($id);
        if ($record->isPersistent) {
            $dataRecord = $record->getAmfPhpInstance();
        }
        return $dataRecord;
	}
	
	public function getAll($sessionKey) {
		$record = new Data_Filters(false);
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
