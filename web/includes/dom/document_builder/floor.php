<?php
	require_once '../document_builder.php';
	require_once 'module.php';
	
    class Floor extends DocumentBuilder {
		protected $index;
		protected $modules;
		/*
		 * Constructor for the Floor class
		 * 
		 * int		floorIndex		The index for this floor
		 * Short	docBuilder		The page's document builder
		 */
		function Floor($floorIndex,&$docBuilder) {
			parent::__construct($docBuilder,'div');
			$this->index = $floorIndex;
			$this->node = &$this->s->CE('div');
			$this->s->SC($this->node,'floor');
			$this->s->SA($this->node,'id',"floor$floorIndex");
			$this->modules = array();			
		}
		
		function getModules() {
			return $this->modules;
		}
				
		function getIndex() {
			return $this->index;
		}
		
		function addModule(&$newModule) {
			$count = count($this->modules);
			$this->modules[$count] = &$newModule;
			$newModule->setIndex($count);
		}
	}
?>
