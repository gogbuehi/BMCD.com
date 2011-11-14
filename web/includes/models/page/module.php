<?php
	require_once 'includes/models/db_model.php';
	class Module extends DBModel {
		public $modClass;
		public $contents; //An array of Content Nodes; Dynamic
		
		function __construct() {
			parent::__construct();
			$this->modClass = 'Module';
			$this->contents = $this->createElement('div');
			$this->appendChild($this->contents);
			
		}
		function getFields() {
			return array_merge(
				parent::getFields(),
				array(
					'mod_class' => &$this->modClass
				)
			);
		}
	}
?>