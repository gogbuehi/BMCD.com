<?php
	require_once 'includes/config/globals.php';
	require_once 'includes/models/file_tree.php';
    require_once 'includes/services/file_services.php';
	
	$fileService = new FileServices();
	$msg = '';
	$response = '';
	if (!isset($_POST['session_key'])) {
		$msg = "Failed to receive a session_key";
		$tLog->error($msg);
		//die($msg);
	}
	else {
		$sessionKey = $_POST['session_key'];
		$time = time();
		$filename = "t$time.tmp";
		try {
			$fileTreeLeaf = $fileService->uploadContent('Filedata',TEMP_DIRECTORY,$filename);
			$response = $fileTreeLeaf->getUrl();
		}
		catch (Exception $e) {
			$msg=$e->getMessage();
		}
	}
?>
<response><error><?php echo $msg;?></error><value><?php echo $response; ?></value></response>