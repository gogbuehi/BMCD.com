<?php
    require_once 'includes/config/globals.php';
	require_once 'includes/models/page/content_node.php';
	
	class StyleNode extends ContentNode {
		const SRC_LINK=1;
		const PAGE_STYLE=2;
		private $type;
		private $sContent;
		function __construct(&$doc,$type,$styleInfo='') {
			if ($type==self::SRC_LINK) {
				$tag='link';
			}
			else {
				$tag='style';
                
			}
			$this->type = $type;
			parent::__construct($tag,$doc);
            //if ($tag == 'style') {
                $this->setsContent('');
            //}
			$this->node->setAttribute('type','text/css');
			
			$this->setStyles($styleInfo);
		}
		function setStyles($styleInfo='') {
			switch($this->type) {
				case self::SRC_LINK:
					$this->setSource($styleInfo);
					break;
				case self::PAGE_STYLE:
					$this->appendsContent($styleInfo);
					break;
				default:
					$msg = "StyleNode does not have an expected type(".$this->type.") to place styleInfo($styleInfo).";
					$this->tLog->error($msg);
					throw new Exception($msg);
			}
		}
		function setSource($src) {
			$this->setAttribute('href',$src);
            $this->setAttribute('rel', 'stylesheet');
		}
		function setsContent($sContent) {
			$this->sContent = $this->createTextNode($sContent);
			$this->appendChild($this->sContent);
		}
		function appendsContent($sContent) {
			$this->sContent->appendContent($sContent);
		}
		
	}
?>