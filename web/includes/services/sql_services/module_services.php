<?php
	require_once '../sql_services';
	require_once '../../dom/module.php';
	
    class ModuleServices extends SqlServices {
		const TABLE='modules';
		static $fields=array(
			'id',
			'dt',
			'blnvalid',
			'class',
			'content'
		);
		function __construct() {
			parent::__construct();
		}
		
		function save($module) {
			
		}
		function recordExists($table,$index) {
			$sql = "select count(*) from `$table` WHERE `id` = $index;";
			
		}
	}
?>