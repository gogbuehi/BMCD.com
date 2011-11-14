<?php
    require_once 'includes/config/globals.php';
	require_once 'includes/models/page/content_node.php';
	require_once 'includes/models/page/menu.php';
	require_once 'includes/utils/url_manager.php';
	
	class HeaderNode extends ContentNode {
		protected $hTitle; //Header's Title
		protected $subtitle;
		protected $address;
		protected $menu;
		
		protected $footer;
		protected $fMenu;

        protected $url;
		
		function __construct(&$doc,$nClass) {
			parent::__construct('div',$doc);
			$this->setClass($nClass);
			
			//Footer element
			$this->footer = $this->createNode('div');
			$footerClass = $this->generateFooterClass($nClass);
			$this->footer->setClass($footerClass);
		}

        function setUrl($url=null) {
            $this->url = $url;
        }

		/**
		 * Adds a logo module to the header node
		 * @return 
		 * @param $nClass Object
		 * @param $link Object
		 * @param $imgSrc Object
		 * @param $title Object[optional]
		 * @param $width Object[optional]
		 * @param $height Object[optional]
		 */
		function addLogo($nClass,$link,$imgSrc,$title='Image',$width=null,$height=null) {
			$module = $this->createNode('div');
			$logoLink = $this->createNode('a');
			$logoImg = $this->createNode('img');
			
			$module->setClass($nClass);
			$logoLink->setAttribute('href',$link);
			$logoImg->setAttribute('src','http://'.CONTENT.$imgSrc);
			$logoImg->setAttribute('title',$title);
			if (!is_null($width))
				$logoImg->setAttribute('width',$width);
			if (!is_null($height))
				$logoImg->setAttribute('height',$height);
			
			$module->appendChild($logoLink);
			$logoLink->appendChild($logoImg);
			
			$this->appendChild($module);
			return $module;
		}
		
		function addTitle($title) {
			$this->hTitle = $this->addSimpleText('h1',$title,'Title');
		}
		
		function addSubTitle($subtitle) {
			$this->subtitle = $this->addSimpleText('h2',$subtitle,'SubTitle');
		}
		
		function addAddress($address) {
			$this->address = $this->addSimpleText('h3',$address,'Address'); 
		}
		
		function &addSimpleText($tag,$text,$nClass='') {
			$module = $this->createNode($tag);
			$textNode = $this->createTextNode($text);
			
			$module->setClass($nClass);
			
			$module->appendChild($textNode);
			$this->appendChild($module);
			return $module;
		}
		
		function addMenu($nClass) {
			$module = new Menu($this->getDOMDocument());
			$module->setClass($nClass);
			$this->menu = &$module;
			$this->appendChild($module);
			
			//Footer element
			$fModule = new Menu($this->getDOMDocument());
			$fModule->setClass($this->generateFooterClass($nClass));
			$this->fMenu = &$fModule;
			$this->footer->appendChild($fModule);
			
			return $module;
		}
		function generateFooterClass($nClass='') {
			return str_replace('Header','Footer',$nClass);
		}
		function addMenuItem($nClass,$href,$label,$isSelected=false) {
			$currentUrl = new UrlManager();
			$menuHref = new UrlManager($href);
			$isSelected = $currentUrl->isDecendentUrl($menuHref);
			$this->menu->addMenuItem(new MenuItem($this->getDOMDocument(),$nClass,$href,$label,$isSelected));
			$this->addFooterMenuItem($nClass,$href,$label,$isSelected);
			if ($isSelected) {
				$this->menu->setSelectedItem($href);	
			}
		}
		function addFooterMenuItem($nClass,$href,$label,$isSelected=false){
			$currentUrl = new UrlManager();
			$menuHref = new UrlManager($href);
			$isSelected = $currentUrl->isDecendentUrl($menuHref);
			$this->fMenu->addMenuItem(new MenuItem($this->getDOMDocument(),$nClass,$href,$label,$isSelected));
			if ($isSelected) {
				$this->fMenu->setSelectedItem($href);	
			}
		}
		function addSubMenuItem($parentHref,$nClass,$href,$label,$isSelected=false) {
			$currentUrl = new UrlManager($this->url);
			$menuHref = new UrlManager($href);
			$isSelected = $currentUrl->isDecendentUrl($menuHref);
			$this->menu->addSubMenuItem($parentHref,$nClass,$href,$label,$isSelected);
			$this->fMenu->addSubMenuItem($parentHref,$nClass,$href,$label,$isSelected);
		}
		
		function setSelectedMenuItem($href) {
			$this->menu->setSelectedItem($href);
			$this->fMenu->setSelectedItem($href);
		}
		function getFooterModule() {
			return $this->footer;
		}
	}
?>