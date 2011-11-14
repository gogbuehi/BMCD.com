<?php
    require_once 'includes/services/file_services.php';
	
	class ExternalDataServices extends FileServices {
		const PORT=80;
		const TIMEOUT=15;

        const OFFSET_10_HOURS=36000;

        protected $offset;
		function __construct($offset=0) {
			parent::__construct();
            $this->offset = $offset;
		}
		/**
		 * Makes a call to an external service, retrives
		 * the response data, and saves it to a file in 
		 * the content server.
		 * @return 
		 * @param $url String
		 */
		function getExternalData($url,$identifier='') {
			$filename = $this->generateSaveFileName($identifier);
			if($this->dataFileExists($filename)) {
				//$this->tLog->debug("Getting \"$filename\" from content server...");
                $oneHour = 3600; //3600 seconds in an hour
                $modificationTime = filemtime($this->constructFullFilePath($filename));
                $currentTime = $_SERVER['REQUEST_TIME'];
                $timePassedBy = $currentTime-$modificationTime;
                $this->tLog->debug('Time passed since last modification: '.$timePassedBy.' seconds');
                if ($timePassedBy > $oneHour) {
                    //Update the cache
                    $this->tLog->debug('Updating the cache for: '.$filename);
                    return $this->saveData($url, $identifier,true);
                }
				return $this->getDataFromFile($filename);
			}
			else {
				//$this->tLog->debug("Getting data from \"$url\"...");
                return $this->saveData($url, $identifier);
			}
		}
        function saveData($url,$identifier,$overwrite=false) {
            $data = file_get_contents($url,FALSE);
            $this->saveExternalData($data,$identifier,$overwrite);
            return $data;
        }
		/**
		 * Function to store data on the content server
		 * @return	String		The URL to the data file
		 * @param $data String	The data to be stored on the content server
		 * @param $identifier String[optional]	The identifier the distinguishes the saved external data
		 */
		function saveExternalData($data,$identifier='',$overwrite = false) {
			$fileName = $this->generateSaveFileName($identifier);
			$fullPath = $this->saveDataToFileFull($fileName,$data,DATA_DIRECTORY,$overwrite);
			
			$fileTree = new FileTree($fullPath);
			$leaf = $fileTree->leaf;
			return $leaf->getUrl();
		}
		/**
		 * Retrieve saved external data
		 * @return 
		 * @param $identifier String[optional]	The identifier the distinguishes the saved external data
		 */
		function getSavedData($identifier='') {
			$fileName = $this->generateSaveFileName($identifier);
			return $this->getDataFromFile($fileName);
		}
		function generateSaveFileName($identifier='',$today=null) {
			if (is_null($today)) {
				$today = date('Ymd',(time()-$this->offset));
			}
			return "external_data_$identifier$today.dat";
		}
	}
?>