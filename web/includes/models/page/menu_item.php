<?php
	require_once 'includes/config/globals.php';
	require_once 'includes/models/page/content_node.php';
	require_once 'includes/models/page/menu.php';
    class MenuItem extends ContentNode {
    	protected $link;
		protected $itemLabelText;
		protected $isSelected=false;
		protected $subMenu=null;
		
    	function __construct(&$doc,$nClass,$href,$label,$isSelected=false) {
    		parent::__construct('li',$doc);
			$this->link = $this->createNode('a');
			if (get_class($label)=='ContentNode') {
				//Just append the node, instead of using a text label
				$itemLabel = $label;
			}
			else {
				$itemLabel = $this->createNode('p');
				$this->itemLabelText = $this->createTextNode($label);
				$itemLabel->appendChild($this->itemLabelText);
			}
			$this->setClass($nClass);
			$this->link->setAttribute('href',$href);
			
			$this->link->appendChild($itemLabel);
			$this->appendChild($this->link);
			
			$this->setSelected($isSelected);
		}
		
		function setSelected($isSelected) {
			$selectedText = ($isSelected===true ? 'selected':null);
			$this->isSelected = $isSelected;
			$this->setAttribute('selected',$selectedText);
		}
        function isSelected() {
            return $this->isSelected;
        }
		
		function setSelectedSubMenuItem($href) {
			if (!is_null($this->subMenu)) {
				return $this->subMenu->setSelected($href);
			}
		}	
		
		function setSubMenu(&$menu) {
			if (!is_null($this->subMenu)) {
				//Remove the current menu
				$this->node->removeChild($this->subMenu);
			}
			$this->subMenu = $menu;
			if (!is_null($this->subMenu)) {
				$this->appendChild($this->subMenu);	
			}
		}
		
		function addSubMenuItem($menuItem) {
			if (is_null($this->subMenu)) {
				//Create a SubMenu
				$subMenu = new Menu($this->getDOMDocument());
				$this->setSubMenu($subMenu);
			}
			$this->subMenu->addMenuItem($menuItem);
		}
		
		function getHref() {
			return $this->link->getAttribute('href');
		}
    }
?>