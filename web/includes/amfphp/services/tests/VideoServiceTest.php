<?php
    require_once 'includes/config/globals.php';
	require_once 'services/vo/Video.php';
	require_once 'services/VideoService.php';
	
	class VideoServiceTest {
		protected $vs;
		
		function __construct() {
			$this->vs = new VideoService();
		}
		
		function test_ftpFiles() {
			$urls = $this->vs->getUploadedFiles();
			foreach($urls as $value) {
				echo $value."<br />";
			}
		}
	}
	
	$serviceTest = new VideoServiceTest();
	$serviceTest->test_ftpFiles();
?>