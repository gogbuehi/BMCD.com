<?php
    /*
	 * This will be a parent class for Floors and Modules
	 * 
	 * It will provide DOM utilities, to expedite page building
	 */
	class DocumentBuilder {
		protected $s;
		protected $node;
		
		function __construct(&$docBuilder,$nodeTag="") {
			$this->s = &$docBuilder;
			if ($nodeTag!='') {
				$this->node = &$this->s->createElement($nodeTag);
			}
		}
		
		function createAndSetNode($nodeTag) {
			$this->node = &$this->s->createElement($nodeTag);
		}
		
		function SA($attribute,$value) {
			$this->node->setAttribute($attribute,$value);
		}
		
		function SC($className) {
			$this->SA('class',$className);
		}
		
		function AC(&$child) {
			$this->node->appendChild($child);
		}
		
		function ATN($text) {
			$tempTextNode = $s->createTextNode($text);
			$this->AC($tempTextNode);
			
		}
		
		function &getNode() {
			return $this->node;
		}	
	}
?>
