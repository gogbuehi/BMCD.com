<?php
    require_once 'includes/models/page/content_node.php';
	class MediaListModule extends ContentNode {
		const TYPE_IMAGE=1;
		const IMAGE_CLASS = array(
			'MODULE' 			=> 'ModMultiImageH',
			'MEDIA_LIST'		=> 'MAImageSelector',
			'MEDIA_LIST_ITEM'	=> 'Image');
		
		protected $classArray;
		
		protected $title;
		protected $mediaList;
		
		function __construct(&$doc,$type=1) {
			parent::__construct('div');
			$this->classArray = $this->getClassArray($type);
			$this->setClass($classArray['MODULE']);
			$this->makeTitle();
			$this->makeMediaList();
			
		}
		
		function makeTitle() {
			$module = $this->createNode('h1');
			$module->setClass('Title');
			$titleText = $this->createTextNode('');
			
			$module->appendChild($titleText);
			$this->title = &$titleText;
			
			$this->appendChild($module);
		}
		
		function setTitle($text) {
			$this->title->setContent($text);
		}
		
		function makeMediaList() {
			$module = $this->createNode('ul');
			$module->setClass($this->classArray['MEDIA_LIST']);
			
			$this->appendChild($module);
		}
		function addMedia() {
			$module = $this->createNode('li');
			$module->setClass($this->classArray['MEDIA_LIST_ITEM']);
			$link = $this->createNode('a');
			$image = $this->createNode('img');
			$pNode = $this->createNode('p');
			
		}
		
		function getClassArray() {
			switch($this->type) {
				case self::IMAGE:
					return self::IMAGE_CLASS;
				default:
					$msg = "There are no classes associated with Type($type)";
					$this->tLog->error($msg);
					throw new Exception($msg);
			}
		}
	}
?>