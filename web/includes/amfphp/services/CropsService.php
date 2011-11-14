<?php
/**
 *	CropsService
 *	Handles the 'crops' table ( see http://spreadsheets.google.com/ccc?key=ppWO4WjtdJsjZvjQh78HwAQ )
 */
require_once 'includes/services/file_services.php';
require_once AMFPHP_INCLUDE_PATH_PREPEND.'/services/vo/Crop.php';
require_once 'models/Content_Library_Crop.php';

class CropsService
{

	protected $fileService;
	public function __construct() 
	{
		$this->fileService = new FileServices();
	}
	
	/*
	 * This is for use within this class only.
	 * Use "addCrop" for public access
	 */
	protected function createRecord(Crop $object) {
		//return $this->createObjectRecord(self::TABLE,$object);
        $dbCrop = new Content_Library_Crop($object);
        return $dbCrop->getIdValue();
	}


	public function addCrop($sessionKey,Crop $cropObject) {
		$id = $this->createRecord($cropObject);
		$cropObject = $this->getCropById($sessionKey,$id);
		$this->updateCrop($sessionKey,$cropObject);
		return $id;		
	}
	
	public function updateCrop($sessionKey,Crop $cropObject) {
		//Todo: Make sure crop has the following method
		if (!$cropObject->hasProperCropName()) {
			$this->fileService->moveContentUrl($cropObject->cropLocation,$cropObject->generateCropFileName());
		}
		$cropObject->setProperNames();
		
		//$this->updateObjectByField(self::TABLE,$cropObject,'id');

        $crop = new Content_Library_Crop($cropObject);
        //$crop->save();

	}
    

	public function getCropById($sessionKey,$id) {
        $crop = new Content_Library_Crop($id);
        if ($crop->isPersistent) {
            $cropObject = $crop->getAmfPhpInstance();
        }
        return $cropObject;
            //$cropObject = $crop->;

        	//return $this->loadObjectByField(self::TABLE,'id',$id,$cropObject);
	}
	
	public function getAllCrops($sessionKey) {
		$crop = new Content_Library_Crop(false);
        $requiredParams = array(
            'blnvalid' => true,
            'domain' => $_SERVER['SERVER_NAME']
        );
        //$crops =$crop->get('blnvalid', true);
        $crops = $crop->getComplex($requiredParams);
        $cropArray = array();
        foreach ($crops as $key => $value) {
            array_push($cropArray,$value->getAmfPhpInstance());
        }
		//return $this->loadObjectsByField(self::TABLE,'blnvalid',1,$cropObject);
        return $cropArray;
	}
	
	public function getSuggestedCrops($sessionKey,$cropObject) {
		$cropObject = new Crop();
		return $this->getAllCrops($sessionKey);
		
	}
	
	function recordExists($cropLocation) {

        $crop = new Content_Library_Crop($cropLocation,'location');
        $crop->match();
        return $crop->isPersistent;
	}
	
	public function removeCrop($sessionKey,Crop $cropObject) {
		$cropObject->blnvalid = FALSE;
        $crop = new Content_Library_Crop($cropObject);
        $crop->save();
		//$this->updateObjectByField(self::TABLE,$cropObject,'id');
	}
	
	public function cleanupContents($sessionKey) {
        $crop = new Content_Library_Crop(false);
        $crops =$crop->get('blnvalid', false);
        foreach ($crops as $key => $value) {
            $cropObject = $value->getAmfPhpInstance();

			$this->fileService->deleteContentUrl($cropObject->cropLocation);
            $value->delete();
        }
	}
    //SERVICE TEST FUNCTIONS
    public function testAddCrop() {
        $sessionKey = 'test_key';
        $crop = new Crop(
            DBObject::NULL,
            'CROP LOCATION',
            1,
            2,
            'A CROP OBJECT',
            3,
            4,
            5,
            6,
            2
        );
        return $this->createRecord($crop);
    }
}
?>
