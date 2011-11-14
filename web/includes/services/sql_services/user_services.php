<?php
    require_once 'includes/services/sql_services.php';
	require_once 'includes/models/user.php';
	
	class UserServices extends SqlServices {
		const TABLE='users';
		function __construct() {
			parent::__construct();
		}
		
		function save($user) {
			
		}
		function recordExists($email) {
			$sql = "select count(*) as count from `".self::TABLE."` WHERE `email` = '".mysql_real_escape_string($email)."';";
			$rs = $this->query($sql);
			
			$row = mysql_fetch_assoc($rs);
			if ($row['count'] == 1) {
				$this->tLog->info('User with email('.$email.') exists');
				return TRUE;
			}
			else {
				$this->tLog->info('User with email('.$email.') does not exist');
				return FALSE;
			}
			
		}
		
		function loadUserByEmail($email) {
			return parent::loadObjectByField(self::TABLE,'email',$email,new User());
		}
		
		function loadUserById($id) {
			return parent::loadObjectByField(self::TABLE,'id',$id,new User());
		}
		
		function createUserRecord($user) {
			$sql = $this->insertStatement(self::TABLE,$user->getFields());
			return $this->insert($sql);
		}
	}
?>