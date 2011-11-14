<?php
/**
 *	SuggestionsService
 */
require_once 'includes/services/file_services.php';
require_once AMFPHP_INCLUDE_PATH_PREPEND.'/services/vo/SuggestionsRecord.php';

class SuggestionsService
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
	protected function createRecord(SuggestionsRecord $dataObject) {
		//return $this->createObjectRecord(self::TABLE,$dataObject);
       return 0;
	}
	
	public function remove($sessionKey,SuggestionsRecord $dataObject) {
		//$this->updateObjectByField(self::TABLE,$dataObject,'id');
	}

	public function add($sessionKey,SuggestionsRecord $dataObject) {
		return 0;		
	}
	
	public function update($sessionKey,SuggestionsRecord $dataObject) {
		//$this->updateObjectByField(self::TABLE,$dataObject,'id');
	}
    
	public function getById($sessionKey,$id) {
		//return $this->loadObjectByField(self::TABLE,'id',$id,$dataObject);
        return $dataObject;
	}
	
	public function getAll($sessionKey) {
        $dataArray = array();
		//return $this->loadObjectsByField(self::TABLE,'blnvalid',1,$dataObject);
        return $dataArray;
	}
}
?>
