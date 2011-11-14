<?php
    require_once 'includes/models/page/content_node.php';
	
	class ModuleNode extends ContentNode {
		function __construct(&$doc) {
			parent::__construct('div',$doc);
		}
		
		/**
		 * make[ModClassName]  functions used to set module clases and do any module 
		 * specific tasks. Thus far, not task is module specific.
		 * 
		 * @return 
		 */
		public function makeModArticleTextRight() {
			$this->setClass('ModArticleTextRight');
			
		}
		
		public function makeModArticleTextLeft() {
			$this->setClass('ModArticleTextLeft');
			
		}
		/**
         * Sets the module's structure to conform to ModArticle
         * specifications
         */
		public function makeModArticle() {
			$this->setClass('ModArticle');
			
		}
		
		public function makePersonnelImageLeft(){
			$this->setClass('ModPersonnelImageLeft');
			
		}
		
		
		public function makeModVideoShowcase(){
			$this->setClass('ModVideoShowcase');
			
		}
		
			
			
		function addVideoItem($videoLink, $toolTip='', $selected=null ){
			$this->videoList->appendChild( $this->createVideoItem($videoLink, $toolTip, $selected ) );
		}
		
		
		function addImageItem($src, $toolTip='', $selected=null ){
			$this->imageList->appendChild( $this->createImageItem($src, $toolTip, $selected ) );
		}
		
		function createImageItem($src, $toolTip='', $selected=null ){
			
				$liNode = $this->createNode('li');
				$liNode->setAttribute( 'selected',$selected );
				$liNode->appendChild( $this->createImageNode($src) );
				$liNode->appendChild( $this->createTextNode($toolTip) );
	
				return $liNode;
		}		
		function createVideoItem($videoLink, $toolTip='', $selected=null ){

				$liNode = $this->createNode('li');
				$liNode->setClass('Video');
				$liNode->appendChild( $this->createEmbedVideoNode($videoLink) );
				$liNode->setAttribute( 'selected',$selected );
				$liNode->appendChild( $this->createTextNode($toolTip) );
	
				return $liNode;
		}
		
		
		/**
		 * 
		 * @return 
		 * @param object $imgPath
		 * @param object $imgWidth[optional]
		 * @param object $imgHeight[optional]
		 * @param object $anchor[optional]
		 * @param object $target[optional] 
		 * 
		 * Note: Domain attribute added. 
		 * 
		 */
		
		
		function addImageNode($imgPath,$domain=CONTENT, $imgWidth=null,$imgHeight=null,$anchor=null, $target=null){
			$imgNode=$this->createNode('img');
			$domain = 'http://'.$domain;
			$imgNode->setAttribute('src',$domain.$imgPath);
			
			// Conditional shorthand: checks if $imgWidth is NOT null, 
			// if so, it sets the width attribtute, else it does nothing.
			!is_Null($imgWidth) ? $imgNode->setAttribute('width',$imgWidth) : null;
			!is_Null($imgHeight) ? $imgNode->setAttribute('height',$imgHeight) : null;
			
			if(!is_null($anchor)){
				$aNode=$this->createAnchorNode($anchor,$target);
				$aNode->appendChild( $imgNode );
				$this->appendChild( $aNode );
			}
			else{
				$this->appendChild( $imgNode );
			}
		}
		
		function createEmbedVideoNode($videoPath,$domain=CONTENT){
			$domain = 'http://'.$domain;
			//$videoNode = $this->createNode();
			//$videoNode->setClass('Video');
			//$videoNode->appendChild( $this->createNode('embed'));
			$videoNode = $this->createNode('embed');
			$videoNode->setAttribute('src',$domain.$videoPath);
			$videoNode->setAttribute('type','video/quicktime');
			$videoNode->setAttribute('pluginspage','http://www.apple.com/quicktime/download/');
			return $videoNode;
		}	
		
		function createImageSelectorItem($imagePath, $srcDomain=CONTENT, $selected=null, $mediaPath=null, $mediaDomain=CONTENT, $toolTip=null){
			$liNode = $this->createNode('li');
			$liNode->setAttribute('selected',$selected);
			$liNode->addLink($mediaPath,$mediaDomain );
			$liNode->addMoreImage($imagePath,$srcDomain );
			$liNode->child->setMoreAttribute('title',$toolTip);
			
			return $liNode;
		}

		
		/**
		 * 
		 * @return 
		 * @param object $text
		 * @param object $anchor[optional] : defaults to '#'
		 * @param object $target[optional] : defaults to '_self'
		 * 
		 * note: This function should likely implament the createAnchorNode() method 
		 * however, at the moment I do not know howe ot access the creatTextNode() method
		 * that only creates a simple invisible text node. 
		 */
		
		function createAnchoredText($text,$anchor='#',$target='_self'){
			$node = $this->createNode('a');
			
			$node->addText($text);
			$node->setAttribute('href',$anchor);
			$node->setAttribute('target',$target);

			return $node;
		}	
		
		function addAnchoredText($text,$anchor='#',$target='_self') {
			$this->appendChild($this->createAnchoredText($text,$anchor,$target));
		}
		/**
		 *
		 * @return complete anchor tag.
		 * @param object $anchor[optional] : defaults to '#'
		 * @param object $target[optional] : defaults to '_self'
		 * 
		 */		
		function createAnchorNode($anchor='#', $target='_self'){
			$node=$this->createNode('a');
			$node->setAttribute('href',$anchor);
			$node->setAttribute('target',$target);

			return $node;
		}
	}
?>