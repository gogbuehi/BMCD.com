<?php
	require_once 'includes/services/sql_services.php';
	require_once 'includes/models/page/page.php';
    class PageServices extends SQLServices {
    	const TABLE='pages';

		public function __construct() 
		{
			parent::__construct();
		}
		protected function createRecord($object) {
			return $this->createObjectRecord(self::TABLE,$object);
		}
	   
		public function add($sessionKey,$object) {
			$id = $this->createRecord($object);
			return $id;
		}
		
		public function update($sessionKey,$object) {
			$this->updateObjectByField(self::TABLE,$object,'id');
		}
	    
	
		public function getById($sessionKey,$id) {
			//Todo: Refactor so this doesn't create an unused object
			$object = new Page();
			return $this->loadObjectByField(self::TABLE,'id',$id,$object);
		}
		
		public function getAll($sessionKey) {
			$object = new Page();
			return $this->loadObjectsByField(self::TABLE,'blnvalid',1,$object);
		}
		public function recordExists($id) {
	
			$sql = "select count(*) as count from `".self::TABLE."` WHERE `id` = $id;";
			$rs = $this->query($sql);
			
			$row = mysql_fetch_assoc($rs);
			if ($row['count'] == 1) {
				$this->tLog->info('Page with id('.$id.') exists');
				return TRUE;
			}
			else {
				$this->tLog->info('Page with id('.$id.') does not exist');
				return FALSE;
			}
		}
		
		public function remove($sessionKey,$object) {
			$object->blnvalid = FALSE;
			$this->updateObjectByField(self::TABLE,$object,'id');
		}
    	
    }
?>