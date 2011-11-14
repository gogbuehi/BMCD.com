<?php
$target_path = dirname( $_SERVER['SCRIPT_FILENAME']);
echo "Script reached\n";
if(isset($_GET['save'])){
	$target_path = $target_path . $_POST['Filename'];
} else {
	$target_path = $target_path . "/tempfile.tmp";
}
if ( move_uploaded_file( $_FILES[ 'file_upload' ][ 'tmp_name' ], $target_path ) ){
	echo "The file " . basename( $_FILES[ 'Filedata' ][ 'name' ] ) . " has been uploaded to ".$target_path.";";
} else {
	echo "There was an error uploading the ".$target_path.", please try again!";
}


?>
