<?php
require_once 'includes/services/file_services.php';
require_once AMFPHP_INCLUDE_PATH_PREPEND.'/services/vo/Video.php';
require_once 'models/Content_Library_Video.php';
require_once 'models/Content_Library_Thumbnail.php';
/**
 * Class for managing Videos
 */
class VideoService
{
	protected $fileService;

	public function __construct() 
	{
		$this->fileService = new FileServices();
		
	}
	protected function createRecord(Video $object) {
		//return $this->createObjectRecord(self::TABLE,$object);
        $dbCrop = new Content_Library_Video($object);
        return $dbCrop->getIdValue();
	}
	
	/**
	 * Used to add a new Video record
	 * @return (int) The ID of the newly created Video record
	 * @param $sessionKey (String)
	 * @param $object (Video) New Video object
	 */
	public function add($sessionKey,$object) {
		$id = $this->createRecord($object);
		$object = $this->getById($sessionKey,$id);
		$this->update($sessionKey,$object);
        global $tLog;
        $tLog->debug('Video ID: '.$id);
		return $id;
	}
	/**
	 * Look in the FTP location for uploaded video files
	 * Moves all ".flv" files from the FTP directory to 
	 * the "temp" directory of the content server.
	 * File names are retained 
	 * @return (array) URL locations to the files
	 */
	public function getUploadedFiles() {
		$fileUrls = $this->fileService->moveFtpFilesToTempLocation(VIDEO_EXTENSION);
		return $fileUrls;
	}
	
	/**
	 * Updates the video record according to match the provided Video object
	 * @param $sessionKey (String)
	 * @param $object (Video)
	 */
	public function update($sessionKey,Video $object) {
		if (!$object->hasProperName()) {
			$this->fileService->moveContentUrl($object->location,$object->generateFileName());
		}
		if (!$object->hasProperThumbnailName()) {
			$this->fileService->moveContentUrl($object->thumbnailLocation,$object->generateThumbnailFileName());
		}
		$object->setProperNames();
		//$object->setLocation();

        $object = new Content_Library_Video($object);
		//$this->updateObjectByField(self::TABLE,$object,'id');
	}
    
	/**
	 * Get a Video object, based on a given ID
	 * @return (Video) The retrieved Video object with data
	 * @param $sessionKey (String)
	 * @param $id (int)
	 */
	public function getById($sessionKey,$id) {
		//Todo: Refactor so this doesn't create an unused Video object; also for "cleanupContents"
		 $video = new Content_Library_Video($id);
        if ($video->isPersistent) {
            $videoObject = $video->getAmfPhpInstance();
        }
        return $videoObject;
	}
	/**
	 * Get all valid Videos that are in the database
	 * @return (Array:Video) An array of all valid Video records
	 * @param $sessionKey O(String
	 */
	public function getAll($sessionKey) {
		$video = new Content_Library_Video(false);
        $requiredParams = array(
            'blnvalid' => true,
            'domain' => $_SERVER['SERVER_NAME']
        );
        //$masters =$master->get('blnvalid', true);
        $videos = $video->getComplex($requiredParams);
        $videoArray = array();
        foreach ($videos as $key => $value) {
            array_push($videoArray,$value->getAmfPhpInstance());
        }
        return $videoArray;
	}
	/**
	 * Verify that a record exists for a provided Video URL
	 * @return (boolean) 	TRUE - If the record is found
	 * 						FALSE - Otherwise
	 * @param $location (String) The URL of the Video (including "http://")
	 */
	public function recordExists($location) {
		$video = new Content_Library_Video($location,'location');
        //$master->match();
        return $video->isPersistent;
	}
	
	/**
	 * Invalidates a Video record
	 * @param $sessionKey (String)
	 * @param $object (Video) The Video to be removed from use
	 */
	public function remove($sessionKey,Video $object) {
		$object->blnvalid = FALSE;
        $video = new Content_Library_Video($object);
        $video->save();
	}
	/**
	 * FOR I.T. USE ONLY; DO NOT USE THIS FOR NORMAL USER SERVICES
	 * @return 
	 * @param $sessionKey Object
	 */
	public function cleanupContents($sessionKey) {
		$video = new Content_Library_Video(false);
        $videos =$video->get('blnvalid', false);
        foreach ($videos as $key => $value) {
            $videoObject = $value->getAmfPhpInstance();

			$this->fileService->deleteContentUrl($videoObject->location);
            $value->delete();
        }
		
	}
		
}
?>
