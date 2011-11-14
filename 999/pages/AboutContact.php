<?php
	require_once 'includes/models/page/bmcd/bmcd_999_page.php';
	require_once 'includes/models/page/module_node.php';
    class AboutContact extends Bmcd999Page {
    	function __construct($url=null) {
    		parent::__construct('Contact Us',$url);
			$this->makeContent();
    	}
		
	
		function makeContent() {
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->setClass('ModArticleTRNoBreaks');
				$module->addBodyText('');
				$module->addMoreText('Bentley San Francisco','b');
				$module->addBodyText('');
				$module->addMoreText('Lamborghini San Francisco','b');
				$module->addBodyText('');
				$module->addMoreText('Lotus San Francisco','b');
				$module->addBodyText('999 Van Ness Avenue');
				$module->addBodyText('San Francisco CA, 94109');
				$module->addBodyText('(Enter on O\'Farrell Street)');
				//$module->addBodyText('(888) 536-8228');
				$module->addBodyText('');
				$module->addMoreLink('','www.bmcd.com');
				$module->child->addMoreText('www.bmcd.com');
				$module->addBodyText('');
				$module->addMoreLink('');
				$module->addBodyText('');
				$module->addMoreText('Parking:','b');
				$module->addBodyText('Free Indoor Customer Parking is available off of O\'Farrell.');
				$module->addBodyText('Enter Customer Parking or the Service Department from O\'Farrell.');
				$module->addBodyText('');
				$module->addMoreLink('');
				$module->addBodyText('');
				$module->addMoreText('Sales Hours:','b');
				$module->addBodyText('By Appointment Only');
				$module->addBodyText('Monday - Saturday 9:00AM to 6:00PM');	
				$module->addBodyText('Sunday Closed');
				$module->addBodyText('');
				$module->addMoreLink('');	
				$module->addBodyText('');
				$module->addMoreText('Service Hours:','b');
				$module->addBodyText('Monday - Friday   7:30AM to 5:30PM');
				$module->addBodyText('24 Appointment Request Available at BMCD.com');
				$module->addBodyText('');
				$module->addMoreLink('');
				$module->addBodyText('');
				$module->addMoreText('Parts:','b');
				$module->addBodyText('Monday - Friday   8:00AM to 5:00PM');	
				$module->addBodyText('24 Order Request Available at BMCD.com');		
	
				$module->addImageNode('/temp/images/map_image999.png',CONTENT,null,null,'http://www.google.com/maps?f=q&hl=en&q=999+S+Van+Ness+Ave,+San+Francisco,+San+Francisco,+California+94110&sll=37.689743,-122.151437&sspn=0.016522,0.024827&g=999+S+Van+Ness+Ave,+San+Francisco,+San+Francisco,+California+94110&ie=UTF8&cd=2&geocode=FRshQAIdixG0-A&z=17&iwloc=addr');

				
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