<?php
	require_once 'includes/models/page/content_node.php';
	require_once 'includes/models/page/script_node.php';
	require_once 'includes/models/page/style_node.php';
	
	
    class Page extends ContentNode {
    	const PAGE_SCRIPT='PAGE_SCRIPT';
		const PAGE_STYLE='PAGE_STYLE';
        const BODY_SCRIPT='BODY_SCRIPT';
    	public $name='';
		public $title='';
		
		public $doc;
		public $pTitle;
		private $scripts; //Array of ScriptNodes
		private $styles; //Array of StyleNodes
		public $head;
		public $body;
		public $cNodes; //Array of Content Nodes
		public $catalyst; //The root node of the content

        public $hasDynamicContent;
		
		function __construct($rootTag='html') {
			parent::__construct($rootTag,new DOMDocument('1.0', 'iso-8859-1'));
            $this->hasDynamicContent = false;
			$this->doc = &$this->getDOMDocument();
			$this->scripts = array();
			$this->styles = array();
			$this->buildPageStructure();
		}
		
		function getFields() {
			return array_merge(
				parent::getFields(),
				array(
					'name'	=> &$this->name,
					'title' => &$this->title
				)
			);
		}
		
		function tableFieldType($fieldName) {
			switch($fieldName) {
				case 'title':
				case 'name':
				default:
					return parent::tableFieldType($fieldName);
			}
			
		}
		
		function buildPageStructure() {
			$this->doc->appendChild($this->node);
			
			$this->head = $this->createNode('head');
			$title = $this->createNode('title');
			$this->pTitle = $this->createTextNode('');
			$title->appendChild($this->pTitle);
			$this->head->appendChild($title);
			$this->appendChild($this->head);
			$this->body = $this->createNode('body');
			
			$this->appendChild($this->body);
		}
		function createNode($tag) {
			return new ContentNode($tag,$this->doc);
		}
		function addScript($type,$scriptInfo='') {
            //$this->tLog->debug('Adding script of type('.$type.') with info('.$scriptInfo.')');
			switch($type) {
				case ScriptNode::SRC_LINK:
					if (!isset($this->scripts[$scriptInfo])) {
						$this->scripts[$scriptInfo]=new ScriptNode($this->doc,$type,$scriptInfo);
						$this->head->appendChild($this->scripts[$scriptInfo]);
					}
					break;
				case ScriptNode::PAGE_SCRIPT:
                    //Make a unique identifier
                    $identifier = 'PAGE_SCRIPT_'.count($this->scripts);
					if(isset($this->scripts[$identifier])) {
						//$this->scripts[self::PAGE_SCRIPT]->appendContent($scriptInfo);
                        $this->scripts[$identifier]=new ScriptNode($this->doc,$type,$scriptInfo);
						//$this->head->appendChild($this->scripts[self::PAGE_SCRIPT]);
                        $this->head->appendChild($this->scripts[$identifier]);
                        
					}
					else {
                        $this->scripts[$identifier]=new ScriptNode($this->doc,$type,$scriptInfo);
						//$this->scripts[self::PAGE_SCRIPT]=new ScriptNode($this->doc,$type,$scriptInfo);
						//$this->head->appendChild($this->scripts[self::PAGE_SCRIPT]);
                        $this->head->appendChild($this->scripts[$identifier]);
                        
					}
					break;
                case ScriptNode::BODY_SCRIPT:
                    if(isset($this->scripts[self::BODY_SCRIPT])) {
						$this->scripts[self::BODY_SCRIPT]->appendContent($scriptInfo);
					}
					else {
						$this->scripts[self::BODY_SCRIPT]=new ScriptNode($this->doc,$type,$scriptInfo);
                        //$this->tLog->debug('Appending body script with content('.$scriptInfo.')');
						$this->body->appendChild($this->scripts[self::BODY_SCRIPT]);
					}
					break;
				default:
					$msg = "There is no ScriptNode of type($type) to insert Info($scriptInfo) into.";
					$this->tLog->error($msg);
					throw new Exception($msg);
			}
		}
		function addStyle($type,$styleInfo='') {
			
			switch($type) {
				case StyleNode::SRC_LINK:
					if (!isset($this->styles[$styleInfo])) {
						$this->styles[$styleInfo]=new StyleNode($this->doc,$type,$styleInfo);
						$this->head->appendChild($this->styles[$styleInfo]);
					}
					break;
				case StyleNode::PAGE_STYLE:
					if(isset($this->styles[self::PAGE_STYLE])) {
						$this->styles[self::$styleInfo]->appendContent($styleInfo);
					}
					else {
						$this->styles[self::PAGE_SCRIPT]=new StyleNode($this->doc,$type,$styleInfo);
						$this->head->appendChild($this->styles[self::PAGE_SCRIPT]);
					}
					break;
				default:
					$msg = "There is no StyleNode of type($type) to insert Info($styleInfo) into.";
					$this->tLog->error($msg);
					throw new Exception($msg);
			}
		}
		function setTitle($title) {
			$this->pTitle->setContent($title);
		}
        function getTitle() {
            return $this->pTitle->getContent();
        }
		function appendScript($type,$scriptInfo) {
			
		}
		function hasScript($scriptReference) {
			foreach ($this->scripts as $key => $value) {
				if ($value->attribute->src == $scriptReference) {
					return true;
				}
			}
			return false;
		}
		function appendContent($cNode,$refNode = null) {
			$this->body->appendChild($cNode,$refNode);
		}
		
		function getHtml() {
			return $this->doc->saveXML();
		}
		function getBodyInnerHtml() {
			return $this->body->getInnerHtml();
		}

        function jsGlobals() {
            $scriptString = '';

            $gVars = array();
            $gVars['HOSTNAME'] = HOSTNAME;
            $gVars['CONTENT'] = CONTENT;
            $gVars['SUBDOMAIN_999'] = SUBDOMAIN_999;
            $gVars['SUBDOMAIN_901'] = SUBDOMAIN_901;
            $gVars['SESSION_KEY'] = session_id();
            $gVars['FLASH_VERSION'] = 'trunk1144';

            $comma = "\n\t";
            foreach ($gVars as $key => $value) {
                $scriptString .= "$comma$key:'$value'";
                $comma = ",\n\t";
            }
            $scriptString = 'var gVars = {'.$scriptString."\n};\nfunction getGlobals() { return gVars; }";
            return $scriptString;
        }
    }
?>
