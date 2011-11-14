<?php
	require_once 'includes/services/sql_services.php';
	require_once 'includes/models/page/content_node.php';
	require_once 'includes/models/page/content_attribute.php';
    class ContentAttributeServices extends SqlServices {
    	const TABLE='content_attributes';
		
		function __construct() {
			parent::__construct();
		}
		protected function createRecord($object) {
			return $this->createObjectRecord(self::TABLE,$object);
		}
		
		function add($sessionKey,$contentNode) {
			return $this->createRecord($contentNode);
		}
		
		function update($sessionKey,$contentNode) {
			$this->updateObjectByField(self::TABLE,$contentNode,'id');
		}
		
		function getById($sessionKey,$id) {
			$object = new ContentAttribute();
			return $this->loadObjectByField(self::TABLE,'id',$id,$object);
		}
    }
?>