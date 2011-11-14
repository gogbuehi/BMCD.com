<?php
	require_once 'includes/config/globals.php';
	
	$tLog->debug('-----UPLOAD TEST------');
	
	$uploadUrl = 'http://'.HOSTNAME.'/includes/handlers/upload_handler.php';
	$masterUrl = 'http://'.HOSTNAME.'/services/tests/MasterServiceTest.php?do=addMaster';
?>
<html>
	<head>
		<title>
			Upload Test
		</title>
		
		<script type="text/javascript" src="scripts/jquery-1.2.6.min.js"></script>
		<script type="text/javascript" src="scripts/ajaxfileupload.js"></script>
		<script type="text/javascript" src="js/ajax_services.js"></script>
		
		<script type="text/javascript">
			var UPLOAD_URL='<?php echo $uploadUrl; ?>';
			var SESSION_KEY='<?php echo session_id(); ?>';
			var MASTER_URL='<?php echo $masterUrl; ?>';
			
			var files = new Array();
			var masterObject;
			var fileObject;
			function processFiles() {
				if (files.length == 2) {
					var data = {
						session_key:SESSION_KEY,
						master_location:files[0],
						thumbnail_location:files[1],
						dimension_width:0,
						dimesnsion_height:0,
						short_description:'test',
						scale:0,
						offset_x:0,
						offset_y:0
					};
					var url = MASTER_URL;
					$.post(url,data,process_callback,"json");
				}
			}
			function process_callback(data) {
				anObject = data;
				//alert('Master id: '+data.id);
			}
			function ajaxFileUpload(frameId,formId)	{
				$("#loading")
				.ajaxStart(function(){
					$(this).show();
				})
				.ajaxComplete(function(){
					$(this).hide();
				});
		
				$.ajaxFileUpload
				(
					{
						url:UPLOAD_URL,
						secureuri:false,
						fileElementId:'Filedata',
						dataType: 'xml',
						success: function (data, status)
						{
							fileObject = data;
							var response = $(data).find("response");
							var error = response.find("error").html();
							var value = response.find("value").html();
							if(error != '') {
								alert(error);
							}
							else {
								files[files.length] = value;
								processFiles();		
							}
						},
						error: function (data, status, e)
						{
							alert(e);
						}
					},
					frameId,
					formId
				)
				
				return false;
		
			}
		</script>
	</head>
	<body>
		<div style="display:none;">Loading...</div>
		<div>
			<form id="upload_test" enctype="multipart/form-data" action="<?php echo $uploadUrl; ?>" method="post" name="upload_test" target="results">
				<label for="session_key">
					Session Key:
				</label>
				<input id="session_key" name="session_key" type="text" readonly="readonly" value="<?php echo session_id(); ?>" />
				<br />
				<label for="Filedata">
					File to Upload:
				</label>
				<input id="Filedata" name="Filedata" type="file" />
				<input name="upload" type="button" onclick="ajaxFileUpload('results','upload_test');" value="Upload" />
			</form>
		</div>
		<div>
			<form enctype="multipart/form-data" action="<?php echo $uploadUrl; ?>" method="post" id="upload_test2" name="upload_test2" target="results2">
				<label for="session_key2">
					Session Key:
				</label>
				<input id="session_key2" name="session_key" type="text" readonly="readonly" value="<?php echo session_id(); ?>" />
				<br />
				<label for="Filedata2">
					File to Upload:
				</label>
				<input id="Filedata2" name="Filedata" type="file" />
				<input name="upload" type="button" onclick="ajaxFileUpload('results2','upload_test2');" value="Upload" />
			</form>
		</div>
		
		<iframe name="results" id="results" src="javascript:false"></iframe>
		<iframe name="results2" id="results2" src="javascript:false"></iframe>
		<iframe name="results3" id="results3" src="javascript:false"></iframe>
	</body>
</html>