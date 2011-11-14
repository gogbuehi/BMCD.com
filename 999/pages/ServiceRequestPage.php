<?php
	require_once 'includes/models/page/bmcd/bmcd_999_page.php';
	require_once 'includes/models/page/module_node.php';
    class ServiceRequestPage extends Bmcd999Page {
    	function __construct($url=null) {
    		parent::__construct('Service Request',$url);
			$this->makeContent();
    	}
		function makeContent() {
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->setClass('ModForm');
				$module->addBodyText('To schedule a service appointment, please fill out the form below. Please call us 888.203.6567, if you would like to schedule an appointment within the next two days.');
				$module->addTitleText('Service Appointment Request');
				$module->addText('The email address you provide will not be transferred, sold, given, or otherwise disclosed to any third party.','p');
				$module->setMoreClass('disclaimer');
				$module->appendChild($this->createNode('ul'));
				$module->addMore($this->createLineItem('/forms/quick_quote','Quick Quote'));
				$module->addMore($this->createLineItem('/forms/parts_request','Parts Request'));
				$module->addMore($this->createLineItem('/forms/service_request','Service Appointment Request','selected'));
				
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