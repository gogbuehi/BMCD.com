<?php
	class FileTree {
		protected $file;
		protected $childNodes;
		protected $parentNode;
		
		protected $location=null;
		protected $url=null;
		protected $storedName=null;
		
		public $leaf=null;
		
		function __construct($file,$parentNode=null) {
			$this->file=$file;
			$this->parentNode=$parentNode;
			$this->childNodes = array();
			$firstSlash = strpos($file,DIRECTORY_SEPARATOR);
			if ($firstSlash!==FALSE) {
				$this->leaf=$this->add_to_tree($file);
			}
		}
		
		function get_location() {
			if (is_null($this->location)) {
				$this->location = $this->getLocation();
			}
			return $this->location;
		}
		function get_parent_location() {
			return $this->parentNode->get_location();
		}
		
		function get_url() {
			if (is_null($this->url)) {
				$this->url = $this->getUrl();
			}
			return $this->url;
		}
		
		function get_stored_name() {
			if(is_null($this->storedName)) {
				$this->storedName = $this->getStoredName();
			}
			return $this->storedName;
		}
		
		function add_to_tree($fullFile) {
			if (is_null($this->parentNode)) {
				$fullFile = str_replace(CONTENT_DIRECTORY,'',$fullFile);
				
				$firstSlash = strpos($fullFile,DIRECTORY_SEPARATOR);
				if ($firstSlash==0 && $firstSlash!==FALSE) {
					$fullFile = substr($fullFile,1);
				}
				
				$filePartsArray = explode(DIRECTORY_SEPARATOR,$fullFile);
				//array_unshift($filePartsArray,CONTENT_DIRECTORY);
				$this->file=CONTENT_DIRECTORY;
				return $this->add_child($filePartsArray);
				
			}
			else {
				return $this->parentNode->add_to_tree($fullFile);
			}
		}
		function add_child($partFile) {
			if (!is_null($partFile) && count($partFile) > 0) {
				$firstEl = array_shift($partFile);
				if (!isset($this->childNodes[$firstEl])) {
					$this->childNodes[$firstEl] = new FileTree($firstEl,$this);
				}
				return $this->childNodes[$firstEl]->add_child($partFile);
			}
			else {
				return $this;
			}
		}
		
		function addChild(&$childNode) {
			$this->childNodes[$childNode->getName()] = &$childNode;
		}
		
		function getName() {
			return $this->file;
		}
		
		function getLocation() {
			if (is_null($this->parentNode)) {
				//This is the root node
				return $this->getName();
			}
			return $this->parentNode->getLocation().DIRECTORY_SEPARATOR.$this->getName();
		}
		
		function getUrl() {
			if (is_null($this->parentNode)) {
				//This is the root node
				return 'http://'.CONTENT;
			}
			return $this->parentNode->getUrl()."/".$this->getName();
		}
		
		function getStoredName() {
			if (is_null($this->parentNode)) {
				return '';
			}
			return $this->parentNode->getStoredName().DIRECTORY_SEPARATOR.$this->getName();
		}
		
		function &getNodeByName($filename) {
			if ($this->getName() == $filename) {
				return $this;
			}
			else {
				foreach ($this->childNodes as $key => &$value) {
					$getter = $value->getNodeByName($filename);
					if (!is_null($getter)) {
						return $getter;
					}
				}
			}
			return null;
		}
	}
?>