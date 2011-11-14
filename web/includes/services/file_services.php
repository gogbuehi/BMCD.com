<?php
	/**
	 * $Id: file_services.php 986 2009-04-09 20:45:38Z gogbuehi $
	 */
	require_once 'includes/config/globals.php';
	require_once 'includes/models/file_tree.php';
	class FileServices {
		protected $tLog;
		function __construct() {
			global $tLog;
			$this->tLog = &$tLog;	
		}
		
		function uploadContent($fileField='Filedata',$directory='temp',$filename='temp.tmp') {
			//$this->tLog->debug("FILEDATA:");
			foreach ($_FILES as $key => $value) {
			//	echo "$key: $value".'<br />';
				
				//$this->tLog->debug("$key");
			}
			$path = CONTENT_DIRECTORY.DIRECTORY_SEPARATOR.$directory.DIRECTORY_SEPARATOR.$filename;
			$this->tLog->info("Uploading file to: $path");
			
			$fileTree = new FileTree($path);
			$leaf = $fileTree->leaf;
			$contentUrl = $leaf->getUrl();
			//$this->tLog->debug("contentUrl: $contentUrl");
			
			if (!isset($_FILES[$fileField])) {
				$msg = "There was no file data posted for $fileField";
				$this->tLog->error($msg); 
				throw new Exception($msg);
			}
			else {
				if (! move_uploaded_file( $_FILES[$fileField][ 'tmp_name' ], $path ) ){
					$msg = "There was an error saving the posted file data ($fileField) to $path";
					$this->tLog->error($msg);
					throw new Exception($msg);						
				}
			}
			//$this->tLog->info("File data successfully uploaded to: $contentUrl");
			return $leaf;
		}
		
		function UrlToFileLocation($url) {
			$searchArray = array('http://','https://',URL_SEPARATOR,CONTENT);
			$replaceArray = array('','',DIRECTORY_SEPARATOR,CONTENT_DIRECTORY);
			
			return str_replace($searchArray,$replaceArray,$url);
		}
		
		function moveContent($filename,$newFileName) {
			if (is_file($filename)) {
				//$this->tLog->info("Moving $filename to $newFileName");
				if (rename($filename,$newFileName)) {
					//$this->tLog->info("File($filename) successfully moved to $newFileName");
				}
				else {
					$msg = "File($filename) failed to move to $newFileName";
					$this->tLog->error($msg);
					throw new Exception($msg);
				}
			}
			else {
				$msg = "File($filename) is not a file.";
				$this->tLog->error($msg);
				throw new Exception($msg);
			}
		}
		
		function getFtpFiles($extension) {
			$files = array();
			foreach(scandir(FTP_DIRECTORY) as $value) {
				$path = FTP_DIRECTORY.DIRECTORY_SEPARATOR.$value;
				$ext = end(explode('.',"$value"));
				if (is_file($path) && $extension == $ext) {
					$files[] = $path;
				}
			}
			return $files;
		}
		
		function moveFtpFilesToTempLocation($extension) {
			$files = $this->getFtpFiles($extension);
			$filename;
			foreach ($files as $key => $filePath) {
				$fileTree = new FileTree($filePath);
				$leaf = $fileTree->leaf;
				$newFilePath = CONTENT_DIRECTORY.DIRECTORY_SEPARATOR.TEMP_DIRECTORY.DIRECTORY_SEPARATOR.$leaf->getName();
				$this->moveContent($filePath,$newFilePath);
				$newFileTree = new FileTree($newFilePath);
				$newLeaf = $newFileTree->leaf;
				$files[$key] = $newLeaf->getUrl();
			}
			$otherTempFiles = array();
			foreach(scandir(CONTENT_DIRECTORY.DIRECTORY_SEPARATOR.TEMP_DIRECTORY) as $value) {
				$path = CONTENT_DIRECTORY.DIRECTORY_SEPARATOR.TEMP_DIRECTORY.DIRECTORY_SEPARATOR.$value;
				$ext = end(explode('.',"$value"));
				if (is_file($path) && $extension == $ext) {
					$fileTree = new FileTree($path);
					$leaf = $fileTree->leaf;
					$otherTempFiles[] = $leaf->getUrl();
				}
			}
			return $otherTempFiles;
		}
		
		
		
		function moveContentUrl($url,$newUrl) {
			$this->moveContent(
				$this->UrlToFileLocation($url),
				$this->UrlToFileLocation($newUrl)
			);
		}
		
		function deleteContent($filename) {
			$this->tLog->info("Attempting to delete file($filename).");
			if(is_file($filename)) {
				if(unlink($filename)) {
					//$this->tLog->info("File($filename) successfully deleted.");
				}
				else {
					$msg = "File($filename) was not able to be deleted.";
					$this->tLog->error($msg);
					throw new Exception($msg);
				}
			}
			else {
				$msg = "File($filename) is not a file.";
				$this->tLog->error($msg);
				throw new Exception($msg);
			}
		}
		
		function deleteContentUrl($url) {
			$this->deleteContent(
				$this->UrlToFileLocation($url)
			);
		}
		/**
		 * Saves data to a file in the content server
         * Note: This will not overwrite a file.
		 * @return 			String	The filepath of the newly created file
		 * @param $filename String	The name of the file to save to
		 * @param $data 	String	The data that belongs in the file
		 */
        function saveDataToFile($filename,$data,$directory=DATA_DIRECTORY) {
            return $this->saveDataToFileFull($filename, $data, $directory, false);
        }

        function saveDataToFileFull($filename,$data,$directory=DATA_DIRECTORY,$overwrite=true) {
            $fullFilePath = CONTENT_DIRECTORY.DIRECTORY_SEPARATOR.$directory.DIRECTORY_SEPARATOR.$filename;
			if ((is_file($fullFilePath) || is_dir($fullFilePath)) && !$overwrite ) {
				$msg = "File($fullFilePath) already exists.";
				$this->tLog->error($msg);
				throw new Exception($msg);
			}
			$file = fopen($fullFilePath,"w");
			if ($file === false) {
				$msg = "Could not open file($fullFilePath).";
				$this->tLog->error($msg);
				throw new Exception($msg);
			}
			if (fwrite($file,$data) === false) {
				$msg = "Could not write to file($fullFilePath).";
				$this->tLog->error($msg);
				throw new Exception($msg);
			}
			if (fclose($file) === FALSE) {
				$msg = "File($fullFilePath) failed to close.";
				$this->tLog->error($msg);
				//throw new Exception($msg);
			}
			return $fullFilePath;
        }

		/**
		 * Retrives data that was saved to the content server
		 * @return 			String	The data found in the requested file
		 * 					Boolean	False if data could not be retrieved
		 * @param $filename String	The filename, without the directory path
		 */
		function getDataFromFile($filename,$directory=DATA_DIRECTORY) {
			$fullFilePath = CONTENT_DIRECTORY.DIRECTORY_SEPARATOR.$directory.DIRECTORY_SEPARATOR.$filename;
			//$this->tLog->info("Getting data from filepath($fullFilePath)");
			if ($this->dataFileExists($filename)) {
				//The file can be read from
				$file = fopen($fullFilePath,"r+b");
				$data = fread($file,filesize($fullFilePath));
				fclose($file);
				return $data;
			}
			else {
				$msg = "File($filename) is not a file or does not exist.";
				$this->tLog->warn($msg);
				return false;
			}
		}

        function getTemplateEmailFromFile($filename) {
            $fullFilePath = CONTENT_DIRECTORY.DIRECTORY_SEPARATOR.EMAILS_DIRECTORY.DIRECTORY_SEPARATOR.$filename;
            //$this->tLog->info('Getting template from filepath('.$fullFilePath.')');
            if ($this->fileExists($fullFilePath)) {
                $file = fopen($fullFilePath,"r+b");
				$data = fread($file,filesize($fullFilePath));
				fclose($file);
				return $data;
			}
			else {
				$msg = "File($filename) is not a file or does not exist.";
				$this->tLog->warn($msg);
				return false;
			}

        }
        function constructFullFilePath($filename,$directory=DATA_DIRECTORY) {
            return CONTENT_DIRECTORY.DIRECTORY_SEPARATOR.$directory.DIRECTORY_SEPARATOR.$filename;
        }
		function dataFileExists($filename,$directory=DATA_DIRECTORY) {
            $fullFilePath = $this->constructFullFilePath($filename, $directory);
            return $this->fileExists($fullFilePath);
		}
        function fileExists($fullFilePath) {
            return (is_file($fullFilePath) && !is_dir($fullFilePath));
        }
		
	}
?>