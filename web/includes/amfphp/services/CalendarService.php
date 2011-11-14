<?php
/**
 *	CalendarService
 */
require_once 'includes/services/file_services.php';
require_once AMFPHP_INCLUDE_PATH_PREPEND.'/services/vo/CalendarRecord.php';
require_once 'models/Data_Calendar.php';

class CalendarService
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
	protected function createRecord(CalendarRecord $dataObject) {
		
        $dataRecord = new Data_Calendar($dataObject);
        return $dataRecord->getIdValue();
	}
	
	public function remove($sessionKey,CalendarRecord $dataObject) {
        $dataObject->blnvalid = FALSE;
        $dataRecord = new Data_Calendar($dataObject);
        $dataRecord->save();
	}

	public function add($sessionKey,CalendarRecord $dataObject) {
		$id = $this->createRecord($dataObject);
		$dataObject = $this->getById($sessionKey,$id);
		$this->update($sessionKey,$dataObject);
		return $id;		
	}
	
	public function update($sessionKey,CalendarRecord $dataObject) {
		$dataRecord = new Data_Calendar($dataObject);
	}
    
	public function getById($sessionKey,$id) {
		$record = new Data_Calendar($id);
        if ($record->isPersistent) {
            $dataRecord = $record->getAmfPhpInstance();
        }
        return $dataRecord;
	}
	
	public function getByDate($sessionKey,$date) {
		$record = new Data_Calendar(false);
        $requiredParams = array(
			'date' => $date,
            'blnvalid' => true,
            'domain' => $_SERVER['SERVER_NAME']
        );
        $records = $record->getComplex($requiredParams);
		$dataRecords = array();
        foreach ($records as $key => $value) {
            array_push($dataRecords,$value->getAmfPhpInstance());
        }
        return $dataRecords[0];
	}
	
	public function getAll($sessionKey) {
		$record = new Data_Calendar(false);
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
