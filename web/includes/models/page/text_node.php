<?php
    require_once 'includes/models/page/content_node.php';
	
	class TextNode extends ContentNode {
		function __construct(&$doc,$tag='p') {
			parent::__construct($tag,$doc);
		}
		function addText($text=null,$tag=null) {
			if (is_null($text)) {
				//Just add a 'br' node
				$aNode = $this->createNode('br');
				$this->appendChild($aNode);
			}
			else {
				$textNode = $this->createTextNode($text);
				if (!is_null($tag)) {
					//Add a surrounding node
					$oNode = $this->createNode($tag);
					$oNode->appendChild($textNode);
					$this->appendChild($oNode);
					return $oNode;
				}
				else {
					$this->appendChild($textNode);	
				}
			}
			return null;
		}
		
		function addLink($href,$text,$domain=HOSTNAME) {
			$link = $this->addText($text,'a');
			$link->setAttribute('href',"http://$domain$href");
			return $link;
		}
	}
?>