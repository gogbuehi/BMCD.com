<?php
	require_once 'includes/services/sql_services.php';
	require_once 'includes/models/page/content_node.php';
    class ContentNodeServices extends SqlServices {
    	const TABLE='content_nodes';
		
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
		
		function getNodesByPage($sessionKey,$pageId) {
			$cnObject = new ContentNode();
			return $this->loadObjectsByField(self::TABLE,'page_id',$pageId,$cnObject);
		}
    }
?>