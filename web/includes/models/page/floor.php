<?php
	class Floor{
		public $id;
		public $dt;
		public $blnvalid;
		public $modules;
		
		function __construct() {
			$this->$id = -1;
			$this->dt = $_SERVER['REQUEST_TIME'];
			$this->blnvalid = TRUE;
			$this->modules = array();
		}
		
		function loadData($dataArray) {
			$fields = $this->getFields();
			foreach($fields as $key => &$value) {
				if(isset($dataArray[$key])) {
					$value = $dataArray[$key];
				}
			}
		}
		
		function setData($field,$value) {
			switch($field) {
				//No special data cases
				default:
					//Do nothing
			}
			$this->loadData(array($field=>$value));
		}
		
		function getFields() {
			return array(
				'id' => &$this->id,
				'dt' => &$this->dt,
				'blnvalid' => &$this->blnvalid
			);
		}
		
		function toString() {
			$toString = '';
			$dataArray = $this->getFields();
			foreach($dataArray as $key => $value) {
				$toString .= "$key: $value<br />\n";
			}
			return $toString;
		}
	}
?>