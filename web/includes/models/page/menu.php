<?php
	require_once 'includes/config/globals.php';
	require_once 'includes/models/page/content_node.php';
	require_once 'includes/models/page/menu_item.php';
    require_once 'includes/utils/url_manager.php';
	
    class Menu extends ContentNode {
    	protected $menuArray;
		
    	function __construct(&$doc) {
			parent::__construct('ul',$doc);
			$this->menuArray = array();
		}
		function addMenuItem($menuItem) {
			$this->appendChild($menuItem);
			$this->menuArray[$menuItem->getHref()] = &$menuItem;
			
		}
		function addSubMenuToItem($href,&$menu) {
			$this->menuArray[$href]->setSubMenu($menu);
		}
		function addSubMenuItem($parentHref,$nClass,$href,$label,$isSelected=false,$subMenu=null) {
			if (!isset($this->menuArray[$parentHref])) {
				$msg = "MenuItem($parentHref) is not in this Menu(".$this->listHrefs().')';
				$this->tLog->error($msg);
				throw new Exception($msg);
			}
            $subMenuItem = new MenuItem($this->getDOMDocument(),$nClass,$href,$label,$isSelected,$subMenu);
			$this->menuArray[$parentHref]->addSubMenuItem($subMenuItem);
            if ($subMenuItem->isSelected()) {
                $this->menuArray[$parentHref]->setSelected(true);
            }
		}
		function setSelectedItem($href) {
            foreach($this->menuArray as $key => $value) {
                $currentUrl = new UrlManager($href);
                $menuUrl = new UrlManager($key);

                if ($currentUrl->isDecendentUrl($menuUrl)) {
                    return $this->setSelectedSubMenuItem($key);
                }
            }
			return false;
		}
		
		function setSelectedSubMenuItem($parentHref,$href=null) {
			$hasSelected = false;
			$hasSelectedSubMenuItem = true;
			//foreach($this->menuArray as $key => &$value) {
			//	$value->setSelected(false);
			//} 
			if (isset($this->menuArray[$parentHref])) {
				$this->menuArray[$parentHref]->setSelected(true);
				$hasSelected = true;
				if (!is_null($href)) {
					$hasSelectedSubMenuItem = $this->menuArray[$parentHref]->setSelectedSubMenuItem($href);
				}
			}
			return $hasSelected && $hasSelectedSubMenuItem;
		}
		
		function listHrefs() {
			$hrefs = '';
			$comma = '';
			foreach ($this->menuArray as $key => $value) {
				$hrefs .= $comma.$key;
				$comma = ',';
			}
			return $hrefs;
		}
    }
?>