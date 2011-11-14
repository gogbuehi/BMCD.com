<?php
	require_once 'includes/models/page/bmcd/bmcd_999_page.php';
	require_once 'includes/models/page/module_node.php';
    class AboutUsGeneral extends Bmcd999Page {
    	function __construct($url=null) {
    		parent::__construct('About Us - General',$url);
			$this->makeContent();
    	}

		function makeContent() {
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticleTextRight();
				$module->addTitleText( 'Welcome to British Motor\'s');
				$module->addTitleText( 'Bentley San Francisco, Lamborghini San Francisco, Lotus San Francisco');
				$module->addBodyText('Welcome to San Francisco\'s premiere luxury automotive dealership. Our website will assist you in discovering the details about our products, while learning more about us and our services. Bentley San Francisco, Lamborghini San Francisco and Lotus San Francisco are all part of the British Motors automotive group - a company that has been a member of the ');
				$module->addMoreText( 'San Francisco community for over sixty years.' );
				$module->addBodyText('Our expert sales staff, large indoor inventory and long standing reputation in the industry, help ensure our ability to find the precise exotic vehicle to fit your personality. We’ll help you to accurately assess each vehicles capabilities to ensure it fits your needs and make the purchasing process simple. You will receive the level of service and professionalism you would expect from the brands we represent. We\'re ready to exceed your expectations.');
				$module->addImage('/temp/images/au_general_01.png');
			//Add the module to the Floor.	
			$floor->appendChild($module);	
			//Add the floor to the page.	
			$this->appendContent($floor);

			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticleTextLeft();
				$module->addBodyText('We are confident that your relationship with us will be a very rewarding and pleasurable one. The goal of our team is to create and maintain an environment of mutual trust and respect with all our clients. Here you are always guaranteed a warm welcome. We look forward to demonstrating to you our enthusiasm for these supremely refined vehicles.' );
				$module->addBodyText('We have a wide array of new and quality pre-owned vehicles in excellent condition, with low mileage and extended service and warranty programs. You can custom order your new vehicle in our commissioning suite by choosing the colors, wood veneers and optional equipment from the manufacturer or from our aftermarket accessories and entertainment department.');
				$module->addImage('/temp/images/au_general_02.png');
			//Add the module to the Floor.	
			$floor->appendChild($module);	
			//Add the floor to the page.	
			$this->appendContent($floor);

			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticleTextRight();
				$module->addBodyText('You really can buy with confidence via the internet. Our customers are proof. Remember, we’re continuing a 50+ year history of looking past the initial sale. Our vehicles are purchased by many of the most well know names in the Bay Area as well as a number of other renowned individuals around the world.' );
				$module->addBodyText('We believe in maintaining long term relationships to help enhance the quality of the relationship with you and your vehicle, it ensure you get the most out of these spectacular machines.');
				$module->addImage('/temp/images/au_general_03.png');
			//Add the module to the Floor.	
			$floor->appendChild($module);	
			//Add the floor to the page.	
			$this->appendContent($floor);
		}
	}
?>