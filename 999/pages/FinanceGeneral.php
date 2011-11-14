<?php
	require_once 'includes/models/page/bmcd/bmcd_999_page.php';
	require_once 'includes/models/page/module_node.php';
    class FinanceGeneral extends Bmcd999Page {
    	function __construct($url=null) {
    		parent::__construct('General Finance',$url);
			$this->makeContent();
    	}

		function makeContent() {
			
			//
			// CONTENT NEEDED
			//
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticle();
				$module->addBodyText('We are confident that your relationship with us will be a very rewarding and pleasurable one. The goal of our team is to create and maintain an environment of mutual trust and respect with all our clients. Here you are always guaranteed a warm welcome. We look forward to demonstrating to you our enthusiasm for these supremely refined vehicles.');
				$module->addBodyText('We have a wide array of new and quality pre-owned vehicles in excellent condition, with low mileage and extended service and warranty programs. You can custom order your new vehicle in our commissioning suite by choosing the colors, wood veneers and optional equipment from the manufacturer or from our aftermarket accessories and entertainment department.');
				$module->addBodyText('At Bentley, Lamborghini and Lotus San Francisco our Customer Experience Measurement standard is set higher than other dealers because we believe our clients deserve only the best. Our friendly and knowledgeable staff is serious about bringing new and established clients the very best customer service for their special automotive purchase. We offer custom-tailored leases and special financing with our exclusive factory lease companies. We would be honored to have you visit our showroom and join us for a hot cappuccino and experience any of our luxury or sports cars first hand.');
				$module->child->appendChild( $module->createAnchoredText('quickquote@bmcd.com','mailto:quickquote@bmcd.com'));
				//Add the module to the Floor.	
				$floor->appendChild($module);	
				//Add the floor to the page.	
				$this->appendContent($floor);


		}
	}
?>