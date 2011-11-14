<?php
	require_once 'includes/models/page/bmcd/bmcd_999_page.php';
	require_once 'includes/models/page/module_node.php';
    class AboutTeam extends Bmcd999Page {
    	function __construct($url=null) {
    		parent::__construct('Our Team',$url);
			$this->makeContent();
    	}

		function makeContent() {

			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makePersonnelImageLeft();
				$module->addTitleText('Vincent Golde, ');
				$module->addTitleText('');
				$module->addMoreText('General Manager','i');
				$module->addBodyText('');
				$module->child->appendChild( $module->createAnchoredText('vgolde@bmcd.com','mailto:vgolde@bmcd.com'));
				$module->addBodyText('Above all, you want the assistance of someone who will deliver as promised, he is knowledgeable, accurately represents every detail, knows the market, understands the value of your time, can find a solution to any situation, handles your business with discretion and confidentiality, and will be here to help whenever needed. Vincent Golde is our General Manager for Bentley, Lamborghini, Lotus, and related pre-owned. Vincent will be personally involved with your transaction. Purchasing your dream car can be extremely easy…just give Vincent a call.');
				
				$module->addImageNode('/temp/images/our_team_vincent.png');
	
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
				$module->addBodyText('Troy Davis has been in the automotive industry for 17 plus years. He successfully managed one of the largest retailers and now brings his experience, education, energy, enthusiasm, and passion to our service department at British Motor Car Distributors. With his motivation and drive to always do his very best---we are proud to have him lead our team. As a leader, he will listen, and work with our service staff to ensure the best customer and vehicle service.');
				$module->addBodyText('Balance is one reason Troy is successful in what he does, being active in many hobbies including motocross, baseball, and skydiving. Troy helps to ensure our clients will be truly satisfied!');
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
				$module->addTitleText('Lachlan Campbell, ');
				$module->addTitleText('');
				$module->addMoreText('Product Specialist','i');
				$module->addBodyText('');
				$module->child->appendChild( $module->createAnchoredText('lcampbell@bmcd.com','mailto:lcampbell@bmcd.com'));
				$module->addBodyText('"Lach" has been providing his automotive expertise in the Bay Area  for over 17 years. A native of St. Andrews Scotland, Lach’s passion for fine automobiles started early. In the 1950’s his father worked with Rolls Royce and Bentleys, and the vehicles made an impression on Lach. He purchased his first Austin Healey at 17 and to this day has a great respect for British engineering. Lach understands how important finding the right vehicle is, and with his years of expertise, long term approach to sales relationships and extensive product knowledge, he will make sure to find the car that makes and impression on you.');
				$module->addImageNode('/temp/images/none.png');
		
				//Add the module to the Floor.		
				$floor->appendChild($module);		
				//Add the Floor to the page.
				$this->appendContent($floor);
			
			
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makePersonnelImageLeft();
				$module->addTitleText('Billy Edmunds, ');
				$module->addTitleText('');
				$module->addMoreText('Service Advisor - Lotus and Lamborghini','i');
				$module->addBodyText('');
				$module->child->appendChild( $module->createAnchoredText('bedmonds@bmcd.com','mailto:bedmonds@bmcd.com') );
				$module->addBodyText('(415) 351-5166');			
				$module->addBodyText('Billy Edmunds graduated from a University in Cork, Ireland with a Bachelors in Automotive Engineering and joined the Bentley San Francisco team in 2005 when he moved to the U.S.A. During his education, he designed & built what was currently the fastest Go-Kart in Ireland. Billy has been interested in motor sports, specifically Rallying, for as long as he can remember & participated briefly in the drifting championship in Ireland (though he was less successful than he likes to admit). Billy\'s education in the technical aspects of our vehicles and his long standing passion for fine automobiles enables him to accurately assess and communicate and resolve any servicing issues in a timely and efficient mannor. Billy and our qualified team of certified technicians look forward to keeping you on the road.');
				$module->addImageNode('/temp/images/ourteam_billy.png');
		
				//Add the module to the Floor.		
				$floor->appendChild($module);		
				//Add the Floor to the page.
				$this->appendContent($floor);
	
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticleTextLeft();
				$module->addTitleText( 'Service Team');
				$module->addBodyText('In 2005 Bentley San Francisco won "Best Bentley Retailer in the U.S." and in 2006 our Parts Department was awarded the "Best Bentley Parts Retailer in the U.S." and our Sales Department outdid the 2005 Award by becoming the "World’s Largest Bentley Retailer", delivering 301 Bentleys. In addition, we also hold the #1 position for Rolls-Royce worldwide and for Aston Martin nationwide.' );
				$module->addImage('/temp/images/ourteam_service_team.png');
			//Add the module to the Floor.	
			$floor->appendChild($module);	
			//Add the floor to the page.	
			$this->appendContent($floor);	
		}
	}
?>