<?php
	require_once '../module.php';
    class Article extends Module {
		const MODULE_CLASS='ModArticle';
		
		protected $titleNode;
		protected $titleTextNode;
		protected $bodyNode;
		protected $bodyTextNode;
		
		function __construct(&$doc,$titleText='',$bodyText='') {
			parent::__construct($doc);
			
			$this->setClass(self::MODULE_CLASS);
			
			$this->titleNode = &$this->s->createElement('h1');
			$this->titleNode->setAttribute('class','Title');
			$this->titleTextNode = &$this->s->createTextNode($titleText);
			$this->titleNode->appendChild($this->titleTextNode);
			
			$this->bodyNode = &$this->s->createElement('p');
			$this->bodyNode->setAttribue('class','Body');
			$this->bodyTextNode = &$this->s->createTextNode($bodyText);
			$this->bodyNode->appendChild($this->bodyTextNode);
		}
		
		function setTitle($titleText) {
			$this->titleTextNode->replaceData(
				0,
				$this->titleTextNode->length,
				$titleText
			);
		}
		
		function setBody($bodyText) {
			$this->bodyTextNode->replaceData(
				0,
				$this->bodyTextNode->length,
				$bodyText
			);
		}
	}
?>