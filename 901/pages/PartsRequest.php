<?php
	require_once 'includes/models/page/bmcd/bmcd_901_page.php';
	require_once 'includes/models/page/module_node.php';
    class PartsRequest extends Bmcd901Page {
    	function __construct($url=null) {
    		parent::__construct('Parts Request',$url);
			$this->makeContent();
    	}
		function makeContent() {
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->setClass('ModForm');
				$module->addBodyText('To Order a Part, please fill out the form below.');
				$module->addTitleText('Parts Request');
				$module->addText('The email address you provide will not be transferred, sold, given, or otherwise disclosed to any third party.','p');
				$module->setMoreClass('disclaimer');
				$module->appendChild($this->createNode('ul'));
				$module->addMore($this->createLineItem('/forms/quick_quote','Quick Quote'));
				$module->addMore($this->createLineItem('/forms/parts_request','Parts Request','selected'));
				$module->addMore($this->createLineItem('/forms/service_request','Service Appointment Request'));
				
			//Add the module to the Floor.	
			$floor->appendChild($module);	
			//Add the floor to the page.	
			$this->appendContent($floor);
		}
		function createLineItem($href,$label,$selected=null) {
			$li = $this->createNode('li');
			if (!is_null($selected)) {
				$li->setAttribute('selected','selected');
			}
			$a = $this->createLinkNode($href);
			$a->addText($label);
			$li->appendChild($a);
			return $li;
		}
    }
?>