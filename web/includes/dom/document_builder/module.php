<?php
	require_once 'document_builder.php';
	
    class Module extends DocumentBuilder {
		protected $index;
		function __construct($moduleIndex,&$docBuilder) {
			parent::__construct($docBuilder,'div');
			$this->index = $moduleIndex;
			$this->updateId();
		}
		
		function getIndex() {
			return $this->index;
		}
		function setIndex($moduleIndex) {
			$this->index = $moduleIndex;
		}
		function updateId() {
			$this->node->setAttribute('id','module'.$this->index);
		}
		function setClass($moduleClass) {
			$this->node->setAttribute('class',$moduleClass);
		}
	}
?>