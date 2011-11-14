<?php
    require_once 'includes/config/globals.php';
	require_once 'includes/models/page/content_node.php';
	
	class ScriptNode extends ContentNode {
		const SRC_LINK=1;
		const PAGE_SCRIPT=2;
        const BODY_SCRIPT=3;
		protected $sContent;
		protected $type;
		function __construct(&$doc,$type,$scriptInfo=null) {
			parent::__construct('script',$doc);
			$this->type = $type;
			$this->node->setAttribute('type','text/javascript');
			$this->setsContent('');
			if (!is_null($scriptInfo)) {
				$this->setScripts($scriptInfo);
			}
		}
		function setSource($src) {
			$this->setAttribute('src',$src);
		}
		function setsContent($sContent) {
			$this->sContent = $this->createTextNode($sContent);
			$this->appendChild($this->sContent);
		}
		function appendsContent($sContent) {
			$this->sContent->appendContent($sContent);
		}
		function setScripts($scriptInfo) {
			switch($this->type) {
				case self::SRC_LINK:
					$this->setSource($scriptInfo);
					break;
				case self::PAGE_SCRIPT:
                case self::BODY_SCRIPT:
					$this->appendsContent($scriptInfo);
					break;
				default:
					$msg = "ScriptNode does not have an expected type(".$this->type.") to place scriptInfo($scriptInfo).";
					$this->tLog->error($msg);
					throw new Exception($msg);
			}
		}
	}
?>