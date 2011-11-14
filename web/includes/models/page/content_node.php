<?php
	require_once 'includes/models/db_model.php';
	require_once 'includes/models/page/content_attribute.php';
	
	
	
	class ContentNode extends DBModel {
		public $child; //The most recently appended child node
		//Extended DB Variables
		/**
		 * Each of these fields corresponds to a column
		 * in this Class' corresponding DB table
		 */
		public $nodeTag;
		public $nodeClass;
		public $content;
		
		/**
		 * These are representations of DOMNodes, for storage
		 * in the DB
		 */
		public $nextNode;
		public $innerNode;
		public $parentNode;
		public $pageId; //Stored in the source DOMDocument's ID attr
		public $attributeId; //Stored in the ContentAttribute's ID
		
		
		//Variables that aren't stored in the DB
		/**
		 * DOMNode used for placement in a DOMDocument
		 * Note: This object has a reference to the owner
		 * DOMDocument
		 */
		public $node;
		/**
		 * ContentAttribute object for this node
		 */
		public $attribute;
		function __construct($tag,&$doc,$cheatContent=null) {
			parent::__construct();
			$this->nodeTag = $tag;
            //$this->tLog->debug("Creating a new ContentNode({$this->getTag()})");
			
			//All fields set to NULL by default
			$fields = $this->getFields();
			foreach($fields as $key => &$value) {
				$value = null;
			}
			if ($tag == 'text') {
				$this->node = $doc->createTextNode('');
			}
			else {
				if (is_null($cheatContent))
					$this->node = $doc->createElement($tag);
				else
					$this->node = $doc->createElement($tag,$cheatContent);
			}
			$this->attribute = new ContentAttribute();
		}
		function getFields() {
			return array_merge(
				parent::getFields(),
				array(
					'tag'		=> &$this->nodeTag,
					'nclass'	=> &$this->nodeClass, //Avoiding using keyword "class"
					'next' 		=> &$this->nextNode,
					'inner' 	=> &$this->innerNode,
					'content' 	=> &$this->content,
					'parent' 	=> &$this->parentNode,
					'page_id'	=> &$this->pageId,
					'attribute_id'	=> &$this->attributeId
				)
			);
		}
		
		function getTag() {
			return $this->nodeTag;
		}
		
		function setAttribute($field,$value) {
			if ($this->isTextNode()) {
				$msg = "Cannot set Attribute($field, $value) for text nodes.";
				$this->tLog->warn($msg);
				throw new Exception($msg);
			}
			else {
				$this->attribute->setAttribute($this->node,$field,$value);
			}
		}
		function getAttribute($field) {
			return $this->attribute->getAttribute($this->node,$field);
		}
		
		function setClass($nClass) {
			$this->setAttribute('class',$nClass);
		}
		function setContent($content) {
			if ($this->isTextNode()) {
				//This uses a DOMText node
				$this->node->data=$content; 
			}
		}
        function getContent() {
            if ($this->isTextNode()) {
                return $this->node->data;
            }
            return null;
        }
		function appendContent($content) {
			if($this->isTextNode()) {
				$this->node->data .= $content;
			}
		}
		function isTextNode() {
			return isset($this->node->wholeText);
		}
		
		function setChildAttribute($field,$value=null) {
			if(!is_null($this->child)) {
				$this->child->setAttribute($field,$value);
			}
			else {
				$msg = "There is no child in this link to apply attribute($field: $value)".
				$this->tLog->error($msg);
				throw new Exception($msg);
			}
		}
		function appendChild(ContentNode &$cNode,ContentNode $refNode=null) {
			if (!$this->isTextNode()) {
				if (is_null($refNode))
					$cNode->node = &$this->node->appendChild($cNode->node);
				else
					$cNode->node = &$this->node->insertBefore($cNode->node,$refNode->node);
					
				$this->child=$cNode;
				return $cNode;
			}
			else
				$this->tLog->warn('Attempting to appendChild to a textNode');
			//What should we do if this is a text node?
		}
		function setAttributes() {
			$this->attribute->setNodeAttributes($this->node);
		}
		function hasInnerNode() {
			return $this->node->hasChildNodes();
		}
		function hasParentNode() {
			return !is_null($this->node->parentNode);
		}
		/**
		 * Turn this ContentNode's data into a DOMElement
		 * @return void
		 * @param $doc DOMDocument
		 */
		function unloadDOMNode() {
			if (!is_null($this->id))
					$this->node->setAttribute('id',$this->id);
			if ($this->isTextNode()) {
				//Nothing to be done for DOMText, at the moment
			}
			else {
				if  (!is_null($this->nodeClass))
					$this->node->setAttribute('class',$this->nodeClass);
				$this->attribute->setNodesAttributes($this->node);
			}
		}
		
		function getDOMDocument() {
			return $this->node->ownerDocument;
		}
		
		function getInnerHtml() {
			$innerHtml = '';
			$doc = $this->getDOMDocument();
			$childNodes = $this->node->childNodes;
			for($i =0; $i < $childNodes->length; $i++) {
				$innerHtml .= $doc->saveXML($childNodes->item($i));
			}
			return $innerHtml;
		}
		
		//Append Utilities
		
		function createNode($tag='div',$cheatContent=null) {
			return new ContentNode($tag,$this->getDOMDocument(),$cheatContent);
		}
		
		function createTextNode($text) {
			$textNode =  $this->createNode('text');
			$textNode->setContent($text);
            $this->setContent($text);
			return $textNode;
		}
		
		function createImageNode($src,$domain=CONTENT) {
			$node = $this->createNode('img');
			$node->setAttribute('src','http://'.$domain.$src);
			return $node;
		}
		
		function createLinkNode($href,$domain=HOSTNAME) {
			$node = $this->createNode('a');
			$node->setAttribute('href','http://'.$domain.$href);
			return $node;
		}
		
		function addText($text=null,$tag=null) {
			if (is_null($text)) {
				//Just create a 'br' tag
				$node = $this->createNode('br');
			}
			else if (is_null($tag)){
				$node = $this->createTextNode($text);
			}
			else {
				$node = $this->createNode($tag);
				$node->addText($text);
			}
			return $this->appendChild($node);
		}
		function addBodyText($text=null) {
			if(is_null($text)){
				$textNode = $this->createNode('p');
				$textNode->setClass('Body');
				$textNode->appendChild( $this->createNode('a') );
			}else
			{
				$textNode = $this->addText($text,'p');
				$textNode->setClass('Body');
			}
			return $this->appendChild($textNode);
		}
		
		function addTitleText($text=null) {
			$textNode = $this->addText($text,'h1');
			$textNode->setClass('Title');
			return $textNode;
		}
		
		function addImage($src,$domain=CONTENT) {
			return $this->appendChild($this->createImageNode($src,$domain));
		}
		function addLink($href,$domain=HOSTNAME) {
			return $this->appendChild($this->createLinkNode($href,$domain));
		}

        function addDecendentLink($href='') {
            $uri = $_SERVER['REQUEST_URI'];
            $uriArray = explode("?",$uri);
            $uri = $uriArray[0];
            return $this->appendChild($this->createLinkNode($uri.$href,$_SERVER['SERVER_NAME']));
        }

        function addAnchor($text,$name) {
            $textNode = $this->addText($text,'a');
			$textNode->setAttribute('name',$name);
			return $textNode;
        }
		/**
		 * Appends the supplied node to the most recently created child node
		 * @return 
		 * @param $cNode Object
			 */
		function addMore(ContentNode $cNode) {
			if (!is_null($this->child)) {
				return $this->child->appendChild($cNode);
			}
			else {
				$msg = "There is no child node to add <".$cNode->getTag()."> to.";
				$this->tLog->error($msg);
				throw new Exception($msg);
			}
		}
		/**
		 * Add text to the last appended child
		 * @return ContentNode	The newly appended child node
		 * @param $text String[optional] The text to append to the current node
		 * 								If not supplied, then just creates a "<br />" tag
		 * @param $tag 	String[optional] A surrounding node tag
		 * 								If not supplied, then just creates a plain text node
		 */
		
		function addMoreText($text=null,$tag=null) {
			if (is_null($this->child)) {
				$msg = "Cannot addMoreText($text, $tag) on null child for <".$this->nodeTag.">";
				$this->tLog->warn($msg);
				throw new Exception($msg);
			}
			return $this->child->addText($text,$tag);
		}
		function addMoreBodyText($text=null) {
			if (is_null($this->child)) {
				$msg = "Cannot addMoreBodyText($text) on null child for <".$this->nodeTag.">";
				$this->tLog->warn($msg);
				throw new Exception($msg);
			}
			return $this->child->addBodyText($text);
		}
		function addMoreImage($src,$domain=CONTENT) {
			if (is_null($this->child)) {
				$msg = "Cannot addMoreImage($src, $domain) on null child for <".$this->nodeTag.">";
				$this->tLog->warn($msg);
				throw new Exception($msg);
			}
			return $this->addMore($this->createImageNode($src,$domain));
		}
		function addMoreLink($href,$domain=HOSTNAME) {
			if (is_null($this->child)) {
				$msg = "Cannot addMoreText($href, $domain) on null child for <".$this->nodeTag.">";
				$this->tLog->warn($msg);
				throw new Exception($msg);
			}
			return $this->addMore($this->createLinkNode($href,$domain));
		}
		function setMoreAttribute($field,$value) {
			if (is_null($this->child)) {
				$msg = "Cannot setMoreAttribute($field, $value) on null child for <".$this->nodeTag.">";
				$this->tLog->warn($msg);
				throw new Exception($msg);
			}
			else {
				$this->child->setAttribute($field,$value);
			}
		}
		function setMoreClass($class) {
			$this->setMoreAttribute('class',$class);
		}
		
		
		//----------------------------------
		
		
		/**
		 * Take a DOMElement's data and set the ContentNode's
		 * data to match it.
		 * @return void
		 * @param $domNode DOMElement
		 */
		function loadDOMNode($domNode) {
			$this->nodeTag = $domNode->tagName;
			$this->nodeClass = $domNode->getAttribute('class');
			$this->id = $domNode->getAttribute('id');
			if (!is_null($domNode->nextSibling)) {
				$this->nextNode = $this->nextSibling->getAttribute('id');
			}
			else {
				$this->nextNode = null;
			}
			if (!is_null($domNode->parentNode)) {
				$this->parentNode = $domNode->parentNode->getAttribute('id');
			}
			else {
				$this->parentNode = null;
			}
			if (!$domNode->hasChildNodes()) {
				$this->content = $domNode->textContent;
				$this->innerNode = null;
			}
			else {
				$this->content = null;
				$this->innerNode = $domNode->firstChild;
			}
			$this->attribute->getNodesAttributes($domNode);
		}
		
		/**
		 * Append a DOMElement as a child of this ContentNode's
		 * DOMElement ($this->node)
		 * @return void
		 * @param $cNode ContentNode
		 */
		function attachNode(&$cNode) {
			if (!is_null($this->innerNode)) {
				$this->node->appendChild($cNode->node);
			}
		}
		
		
		/**
		 * Constructs a DOMElement tree from an array of ContentNodes
		 * @return int		The index of the root node
		 * @param $cNodeArray Array<ContentNode>
		 */
		static function attachAllNodes($cNodeArray) {
			$catalyst = null;
			foreach ($cNodeArray as $key => &$value) {
				$index = $value->innerNode;
				while(!is_null($index)) {
					$index = $value->attachNode($cNodeArray[$index]);
				}
				if(!$value->hasParentNode()) {
					$catalyst = $key;
				}
			}
			return $catalyst;
		}
	}
?>