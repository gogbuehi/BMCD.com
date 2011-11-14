<?php
    require_once 'includes/models/page/content_node.php';
	
	class LinkNode extends ContentNode {
		public $child; //Holds a reference to the last appended child node
		
		function __construct(&$doc) {
			parent::__construct('a',$doc);
		}
		
		function setHref($href,$domain=HOSTNAME) {
			$this->setAttribute('href',"http://$domain$href");
		}
		
		/**
		 * Clone the attributes of this LinkNode
		 * into a new LinkNode
		 * Example: $aCloneLink = $link->copy();
		 * @return LinkNode		The clone of this LinkNode
		 */
		function copy() {
			$cloneLink = new LinkNode($this->getDOMDocument());
			$cloneLink->setAttribute('href',$this->getAttribute('href'));
			$cloneLink->setAttribute('target',$this->getAttribute('target'));
			
			return $cloneLink;
		}
	}
?>