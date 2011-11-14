<?php
    require_once 'includes/models/page/content_node.php';
	
	class ImageNode extends ContentNode {
		
		function __construct(&$doc) {
			parent::__construct('img',$this->doc);
		}
		
		function setSource($src,$domain=CONTENT) {
			$this->setAttribute('src',"http://$domain$src");
		}
		function setDimensions($width,$height) {
			$this->setAttribute('width',$width);
			$this->setAttribute('height',$height);
		}
		function setTooltip($text) {
			$this->setAttribute('title',$text);
		}
	}
?>