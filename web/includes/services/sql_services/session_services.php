<?php
	require_once 'includes/services/sql_services.php';
	require_once 'includes/models/session.php';
	
    class SessionServices extends SqlServices {
    	const TABLE='sessions';
		function __construct() {
			parent::__construct();
		}
		
		function recordExists($key) {
			$sql = "select count(*) as count from `".self::TABLE."` WHERE `key` = '".mysql_real_escape_string($key)."';";
			$rs = $this->query($sql);
			
			$row = mysql_fetch_assoc($rs);
			if ($row['count'] == 1) {
				$this->tLog->info('User with Session Key('.$key.') exists');
				return TRUE;
			}
			else {
				$this->tLog->info('User with Session Key('.$key.') does not exist');
				return FALSE;
			}
		}
		
		function createObjectRecord($object) {
			return parent::createObjectRecord(self::TABLE,$object);
		}
    	
    }
?>