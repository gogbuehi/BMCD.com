<?php
	require_once 'includes/models/page/bmcd/bmcd_901_page.php';
	require_once 'includes/models/page/module_node.php';
    class AboutTeam extends Bmcd901Page {
    	function __construct($url=null) {
    		parent::__construct('Our Team',$url);
			$this->makeContent();
    	}
		
		function makeContent() {
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticle();
				$module->addTitleText('Our Team');
				$module->addBodyText('At British Motors we believe in building long-lasting relationships. Both our Sales and Service staff will answer all of your questions and help you to feel confident about your vehicle. Contact us at any time if we can be of assistance. With four floors of onsite inventory, which is constantly changing, we can make sure you find the exact vehicle you want. If for some reason the vehicle is not currently in our inventory, we will go above and beyond to find it for you.');
				$module->addBodyText('Land Rovers and Jaguars are remarkable automobiles and they deserve the care of experts. Our technicians receive factory certified training on a regular bases, which keeps them up do date on the workings of your vehicles, so you can be sure that they will spare you any unnecessary repairs. Our Service Advisors understand the value of your time and will make sure you understand the needs of your vehicle.');
				$module->addBodyText('Also, amenities include a shuttle, wireless internet, a child play area, a newly renovated waiting area and the customer service you would expect from the brands family tradition we represent.');
				//Add the module to the Floor.	
				$floor->appendChild($module);	
				//Add the floor to the page.	
				$this->appendContent($floor);

			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makePersonnelImageLeft();
				$module->addTitleText('Mario Terzic, ');
				$module->addTitleText('');
				$module->addMoreText('General Sales Manager ','i');
				$module->addBodyText('');
				$module->child->appendChild( $module->createAnchoredText('mterzic@bmcd.com','mailto:mterzic@bmcd.com'));
				$module->addBodyText('Mario Terzic is our General Sales Manager. Originally from Europe, he fell in love with America when he moved to California in 2000. His sales philosophy is based on long term relationships stemming from product knowledge, honesty and integrity.  Over the years he has built long-term relationships with many clients in the Bay Area. His ultimate goal is to provide you with a level of service that is as extraordinary as the vehicles we sell.');
				
				$module->addImageNode('/temp/images/mario.png');
	
				//Add the module to the Floor.		
				$floor->appendChild($module);		
				//Add the Floor to the page.
				$this->appendContent($floor);

			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makePersonnelImageLeft();
				$module->addTitleText('Troy Davis, ');
				$module->addTitleText('');
				$module->addMoreText('Service Director','i');
				$module->addBodyText('');
				$module->child->appendChild( $module->createAnchoredText('tdavis@bmcd.com','mailto:tdavis@bmcd.com'));
				$module->addBodyText('Troy Davis has been in the automotive industry for 17 plus years. He formerly managed one of the largest retailers and now brings his experience, education, energy, enthusiasm, and passion to our service department at British Motor Car Distributors. With his motivation and drive to always do his very best---we are proud to have him lead our team. As a leader, he will listen, and work with our service staff to ensure the best Customer and vehicle service.');
				$module->addBodyText('Balance is one reason Troy is successful in what he does-being active in many hobbies including motocross, baseball, and skydiving. With both trusted reputations, we will ensure our clients will be truly satisfied!');
				$module->addImageNode('/temp/images/ourteam_troy.png');
		
				//Add the module to the Floor.		
				$floor->appendChild($module);		
				//Add the Floor to the page.
				$this->appendContent($floor);
			
			
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makePersonnelImageLeft();
				$module->addTitleText('John Wolbertus, ');
				$module->addTitleText('');
				$module->addMoreText('Parts And Accessories Director','i');
				$module->addBodyText('');
				$module->child->appendChild( $module->createAnchoredText('jwolbertus@bmcd.com','mailto:jwolbertus@bmcd.com'));
				$module->addBodyText('Our parts and accessories director, John Wolbertus, is a certifiable car nut. His humble collection is always changing to keep up with his diverse appreciation for a variety of makes and models. Currently it includes: 1949 Chevy Stepside; 2001 Qvale Mangusta. And motorcycles too! FLH Harley Davidson, Lightning Buell, V11 Sport Moto Guzzi. John also serves as our Vice President, Parts and Service Division, for Qvale and was our Directori Generale for Mangusta production in Italy: Quite an accomplishment from his first parts job 37 years ago. No wonder John’s knowledge is so expansive. Looking for the right part or special gift? He and his staff can find it.');
				$module->addImageNode('/temp/images/ourteam_john_w.png');
		
				//Add the module to the Floor.		
				$floor->appendChild($module);		
				//Add the Floor to the page.
				$this->appendContent($floor);
	
	
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makePersonnelImageLeft();
				$module->addTitleText('Bud Manthey, ');
				$module->addTitleText('');
				$module->addMoreText('Service Advisor - Jaguar','i' );
				$module->addBodyText('');
				$module->child->appendChild( $module->createAnchoredText('bmanthey@bmcd.com','mailto:bmanthey@bmcd.com') );
				$module->addBodyText('(415) 351-5167');
				$module->addBodyText('Bud Manthey has nearly 40 years in the Automotive Industry. Before he joined the British Motors service team, he was in the auto parts Industry, in the Bay Area, for 30 years. Bud has been a Jaguar service advisor since 2000 and a Master Service Consultant since 2003. He has competed in, and been a member of, the Jaguar Masters Guild for over 4 years. Bud has one motto about the service he provides, he gives the type of service he would expect to receive when he is out in the market place. Bud also likes to spend time with his grand children and is an avid Golfer. Bud also likes to fish and builds and flies custom stunt kites. You can rest assured that when working with Bud, he will always strive to provide you with prompt and efficient service to assure your car is always in its best running condition.');
				$module->addImageNode('/temp/images/bud.png');
							
				//Add the module to the Floor.		
				$floor->appendChild($module);		
				//Add the Floor to the page.
				$this->appendContent($floor);
			
			
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makePersonnelImageLeft();
				$module->addTitleText('Joe Machado, ');
				$module->addTitleText('');
				$module->addMoreText('Service Advisor - Land Rover','i');
				$module->addBodyText('');
				$module->child->appendChild( $module->createAnchoredText('jmachado@bmcd.com','mailto:jmachado@bmcd.com') );
				$module->addBodyText('(415) 351-5164');
				$module->addBodyText('Joe Machado has been in the automotive industry for 10 years and his is one of our Land Rover specialists. Joe says his approach to customer service is, "I try to treat everyone who comes in with the respect I would want afforded to my grandmother." Joe became interested in cars at a young age, when he was spending time with his grandfather who was a mechanic. In high school, he began experimenting in his shop classes and afterwards continued studying automotive repairs. Joe enjoys taking Rovers off-roading, which may provide some insight into his excitement for the brand. His favorite Rover is the 1990 Defender – with the Range Rover Sport as a very close second.');
				$module->addImageNode('/temp/images/joe.png');
							
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