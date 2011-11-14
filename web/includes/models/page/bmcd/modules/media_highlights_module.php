<?php
    require_once 'includes/models/page/module_node.php';
	/**
	 * A module with various media items
	 */
	class MediaHighlightsModule extends ModuleNode {
		protected $mediaList;
		
		protected $imageModule;
		protected $imageLink;
		protected $imageNode;
		
		protected $textModule;
		
		function __construct(&$doc,$nClass='ModPhotoVideoHighlights') {
			parent::__construct($doc);
			$this->setClass($nClass);
			$this->makeVideoList();
			$this->makeImageModule();
			$this->makeTextModule();
		}
		
		/**
		 * Creates a video list ContentNode and
		 * and appends it as a child of this module
		 * @return void
		 */
		function makeVideoList() {
			$module = $this->createNode('ul');
			$module->setClass('MAVideoListController');
			$this->appendChild($module);
			$this->mediaList = $module;
		}
		function makeImageModule() {
			$imageModule = $this->createNode('div');
			$imageModule->setClass('Image');
			
			$imageLink = $this->createNode('a');
			$imageLink->setAttribute('href','');
			
			$imageNode = $this->createNode('img');
			$imageNode->setAttribute('src','');
			$imageNode->setAttribute('width','420');
			$imageNode->setAttribute('height','280');
			$imageNode->setAttribute('title','');
			
			$imageLink->appendChild($imageNode);
			$imageModule->appendChild($imageLink);
			
			$this->appendChild($imageModule);
			$this->imageModule = $imageModule;
			$this->imageLink = $imageLink;
			$this->imageNode = $imageNode;
		}
		function makeTextModule() {
			$module = $this->createNode('p');
			$module->setClass('Body');
			$this->appendChild($module);
			$this->textModule = $module;
		}
		function addVideo($embedSrc,$caption='',$domain=CONTENT) {
			$module = $this->createNode('li');
			$module->setClass('Video');
			
			$embed = $this->createNode('embed');
			$embed->setAttribute('src',"http://$domain$embedSrc");
			$embed->setAttribute('width','420');
			$embed->setAttribute('height','280');
			$embed->setAttribute('type','video/quicktime');
			$embed->setAttribute('pluginspage','http://www.apple.com/quicktime/download/');
			
			$p = $this->createNode('p');
			$pText = $this->createTextNode($caption);
			$p->appendChild($pText);
			
			$module->appendChild($embed);
			$module->appendChild($p);
			
			$this->mediaList->appendChild($module);
		}
		/**
		 * Set the image module's link, source, and tooltip
		 * @return void
		 * @param $src String	The relative URL to the image
		 * @param $link String	The link associated with the image
		 * @param $tooltip String[optional]	Text to show as a caption or in place of the image;
		 * 									Defaults to an empty Strng
		 * @param $domain String[optional]	The domain that the image is served from;
		 * 									Defaults to the CONTENT server domain
		 */
		function setImageModule($src,$link,$tooltip='',$domain=CONTENT) {
			$this->imageLink->setAttribute('href',$link);
			
			$this->imageNode->setAttribute('src','http://'.$domain.$src);
			$this->imageNode->setAttribute('title',$tooltip);
		}
		function addText($text=null,$tag=null) {
			if (is_null($text)) {
				//Just add a break node
				$aNode = $this->createNode('br');
				$this->textModule->appendChild($aNode);
			}
			else {
				$textNode = $this->createTextNode($text);
				if (!is_null($tag)) {
					//Add a surrounding node
					$oNode = $this->createNode($tag);
					$oNode->appendChild($textNode);
					$this->textModule->appendChild($oNode);
				}
				else {
					$this->textModule->appendChild($textNode);	
				}
			}
		}
	}
?>