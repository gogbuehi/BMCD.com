<?php
/**
 *	MastersService
 *	Handle the 'masters' table ( see http://spreadsheets.google.com/ccc?key=ppWO4WjtdJsjZvjQh78HwAQ )
 
 *	TODO
 *
 *	Strategy for error-handling:
 *	Error situations should be handled with exceptions usage, 
 *	so if error occurs, service must throw an exceptions.
 *	Then that exceptions are being converted by AMFPHP into FaultEvent objects,
 *	making client applications be able to differentiate Faults from real Results.
 *
 *	All services must implement this strategy.
 *	See addMaster() method for example.
 */	
 
require_once 'includes/services/file_services.php';
require_once AMFPHP_INCLUDE_PATH_PREPEND.'/services/vo/Master.php';
require_once 'models/Content_Library_Master.php';
require_once 'models/Content_Library_Thumbnail.php';

 
class MastersService {
	
	protected $fileService;

	public function __construct() 
	{
		$this->fileService = new FileServices();
		
	}
    protected function createRecord(Master $object) {
        $dbCrop = new Content_Library_Master($object);
        return $dbCrop->getIdValue();
	}
   
	public function addMaster($sessionKey,Master $masterObject) {
		$id = $this->createRecord($masterObject);
		$masterObject = $this->getMasterById($sessionKey,$id);
		$this->updateMaster($sessionKey,$masterObject);
		return $id;
	}
	
	public function updateMaster($sessionKey,Master $masterObject) {
		if (!$masterObject->hasProperMasterName()) {
			$this->fileService->moveContentUrl($masterObject->masterLocation,$masterObject->generateMasterFileName());
		}
		if (!$masterObject->hasProperThumbnailName()) {
			$this->fileService->moveContentUrl($masterObject->thumbnailLocation,$masterObject->generateThumbnailFileName());
		}
		$masterObject->setProperNames();

        $master = new Content_Library_Master($masterObject);
        //$master->save();
		//$this->updateObjectByField(self::TABLE,$masterObject,'id');
	}
    

	public function getMasterById($sessionKey,$id) {
		//Todo: Refactor so this doesn't create an unused Master object; also for "cleanupContents"
        $master = new Content_Library_Master($id);
        if ($master->isPersistent) {
            $masterObject = $master->getAmfPhpInstance();
        }
        return $masterObject;

		//$masterObject = new Master();
		//return $this->loadObjectByField(self::TABLE,'id',$id,$masterObject);
	}
	
	public function getAllMasters($sessionKey) {
        $master = new Content_Library_Master(false);
        $requiredParams = array(
            'blnvalid' => true,
            'domain' => $_SERVER['SERVER_NAME']
        );
        //$masters =$master->get('blnvalid', true);
        $masters = $master->getComplex($requiredParams);
        $masterArray = array();
        foreach ($masters as $key => $value) {
            array_push($masterArray,$value->getAmfPhpInstance());
        }
        return $masterArray;

	}
	public function recordExists($masterLocation) {

        $master = new Content_Library_Master($masterLocation,'location');
        //$master->match();
        return $master->isPersistent;
	}
	
	public function removeMaster($sessionKey,Master $masterObject) {
        $masterObject->blnvalid = FALSE;
        $master = new Content_Library_Master($masterObject);
        //Remove associated Crops as well
        $crop = new Content_Library_Crop(false);
        $crops =$crop->get('masterId', $master->getId());
        foreach($crops as $key => $value) {
            $value->d_blnvalid = false;
            $value->save();
        }
        $master->save();
	}
	
	public function cleanupContents($sessionKey) {
        $master = new Content_Library_Master(false);
        $masters =$master->get('blnvalid', false);
        foreach ($masters as $key => $value) {
            $masterObject = $value->getAmfPhpInstance();

			$this->fileService->deleteContentUrl($masterObject->masterLocation);
            $value->delete();
        }
	}

    //SERVICE TEST FUNCTIONS
    public function testAddMaster() {
        $sessionKey = 'test_key';
        $master = new Master(
            DBObject::NULL,
            'TEST LOCATION',
            'TEST THUMB LOCATION',
            1,
            2,
            'TEST IMAGE',
            3,
            4,
            5,
            6
        );
        return $this->createRecord($master);
    }
    public function testUpdateMaster() {

    }
    public function testDeleteMaster() {
        
    }
}

?>