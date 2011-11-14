<?php
	require_once 'includes/models/page/bmcd/bmcd_901_page.php';
	require_once 'includes/models/page/module_node.php';
    class AboutContact extends Bmcd901Page {
    	function __construct($url=null) {
    		parent::__construct('Contact Us',$url);
			$this->makeContent();
    	}
	
		function makeContent() {
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->setClass('ModArticleTRNoBreaks');
				$module->addBodyText('');
				$module->addMoreText('British Motor Car Distributors','b');
				$module->addBodyText('901 Van Ness Avenue');
				$module->addBodyText('San Francisco CA, 94109');
				$module->addBodyText('(at the corner of Van Ness and Ellis, Enter on Ellis)');
				$module->addBodyText('(800) 536-8288');
				$module->addBodyText('');
				$module->addMoreLink('',HOSTNAME);
				$module->child->addMoreText('www.bmcd.com');
				$module->addBodyText('');
				//$module->addMoreLink('');
				$module->addBodyText('');
				$module->addMoreText('Parking:','b');
				$module->addBodyText('Free Indoor Customer Parking is available off of Ellis.');
				$module->addBodyText('Enter Customer Parking or the Service Department from Ellis.');
				$module->addBodyText('');
				//$module->addMoreLink('');
				$module->addBodyText('');
				$module->addMoreText('Sales Hours:','b');
				$module->addBodyText('Monday - Thursday 9:00AM to 7:00PM');
				$module->addBodyText('Friday - Saturday 9:00AM to 6:00PM');	
				$module->addBodyText('Sunday           11:00AM to 4:00PM');	
				$module->addBodyText('');
				//$module->addMoreLink('');
				$module->addBodyText('');
				$module->addMoreText('Service Hours:','b');
				$module->addBodyText('Monday - Friday   7:30AM to 5:30PM');
				$module->addBodyText('');
				//$module->addMoreLink('');
				$module->addBodyText('');
				$module->addMoreText('Parts:','b');
				$module->addBodyText('Monday - Friday   8:00AM to 5:00PM');	
	
				$module->addImageNode('/temp/images/map_image901.png',CONTENT,null,null,'http://www.google.com/maps?f=q&hl=en&geocode=&q=901+van+ness,+sf+ca&sll=37.0625,-95.677068&sspn=66.193728,101.689453&ie=UTF8&z=17&g=901+van+ness,+sf+ca&iwloc=addr');

				
				//Add the module to the Floor.		
				$floor->appendChild($module);		
				//Add the Floor to the page.
				$this->appendContent($floor);
			
			/**
			 * Note the difference between "appendChild" and "appendContent"
			 * "appendChild" is for adding a node as a child of another node
			 * "appendContent" is for adding a node as a child of the Page's body
			 */	
			 
		}
    }
?>