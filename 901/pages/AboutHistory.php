<?php
	require_once 'includes/models/page/bmcd/bmcd_901_page.php';
	require_once 'includes/models/page/module_node.php';
    class AboutHistory extends Bmcd901Page {
    	function __construct($url=null) {
    		parent::__construct('Our History',$url);
			$this->makeContent();
    	}
		
		function makeContent() {
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticle();
				$module->addTitleText('History');
				$module->addBodyText('Founded in 1947 by Kjell Qvale, British Motor Car Distributors has been a part of the San Francisco community for over sixty years.');
			
				//Add the module to the Floor.	
				$floor->appendChild($module);	
				//Add the floor to the page.	
				$this->appendContent($floor);

			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticleTextRight();
				$module->addTitleText('Overview');
				$module->addBodyText('Kjell Qvale\'s first car dealership in l946, acquired the MG product line in l947 and opened British Motors in 1949. The "Distributors" part in the name refers to our many years of distributing nearly every automobile coming from England during the 1950\'s through 1970\'s to dealerships all over the Western U.S. There was also a long stint with Porsche, Volkswagen, and Maserati. This was after much humbler beginnings as a single retailer for MG and ');
				$module->addMoreLink('/inventory/jaguar',SUBDOMAIN_901);
				$module->child->addMoreText('Jaguar');
				$module->addMoreText('. We\'ve passed the 1 million vehicle mark and are still counting. The customer care practiced by our founder, Kjell Qvale, led many vehicle manufacturers to seek his representation as their distributor in this growing country.');
				$module->addBodyText('Kjell Qvale organized the first Import Car Show in San Francisco in 1958 (now, the San Francisco International Auto Show), manufactured the acclaimed Jensen Healey for six years beginning in l970, and more recently, produced the Qvale Mangusta sports car. In 2008, British Motors added another significant "first" to its list of achievements: the largest commercial solar power installation in San Francisco.');
				$module->addBodyText('*Left: British Motors as a Jensen Healey dealership');
			
				$module->addImageNode('/temp/images/bmc_inside_old.png');

				
				//Add the module to the Floor.		
				$floor->appendChild($module);		
				//Add the Floor to the page.
				$this->appendContent($floor);
			
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticleTextLeft();
				$module->addTitleText('Kjell Qvale');				
				$module->addBodyText('Kjell Qvale started his life in Norway eighty nine years ago and settled in Seattle before finaly calling San Francisco his home. Among the many passions in his life, the earliest must certainly have been skiing and track and field, sports in which he excelled in school and that led to his meeting many interesting people. After his experiences as a pilot during World War II, he came home and initially became a Willys dealer.');
				$module->addBodyText('However, it wasn\'t long after his involvement with British cars began that his business started to blossom.  He sold the good ones and the bad ones, the ones that leaked and the ones that made Lucas electrical parts famous in America for their lack of reliability. Along the way, he met his wife Kay, his partner both in business and raising their family. As if the car business wasn\'t enough, Kjell also developed a love of race horses early on that continues to this day. He was the owner of the legendary Silky Sullivan nicknamed "the California Comet."');
				$module->addBodyText('*Right: Kjell Qvale driving');
				$module->setMoreAttribute('style','text-align: right;');
								
				$module->addImageNode('/temp/images/mrq_tractor.png');

						
				//Add the module to the Floor.		
				$floor->appendChild($module);		
				//Add the Floor to the page.
				$this->appendContent($floor);
				
			
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticleTextRight();
				$module->addTitleText('Benard Maybeck');				
				$module->addBodyText('Bernard Maybeck was the architect of the British Motors building. Originally built in 1927 it was constructed to be a Packard dealership. Maybeck attended the Ecole des Beaux Arts in Paris, France and designed of number of San Francisco landmark buildings, including the Place of the Fine Art in the Presidio. He is known as a mentor for a generation of California Architects.');
				$module->addBodyText('*Left: Bernard Maybeck');
					
				$module->addImageNode('/temp/images/maybeck.png');	

				//Add the module to the Floor.		
				$floor->appendChild($module);		
				//Add the Floor to the page.
				$this->appendContent($floor);
			

			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticleTextLeft();
				$module->addTitleText('Earle C. Anthony - KFI');				
				$module->addBodyText('Earle Anthony owned the Packard dealership before it became British Motors in 1947.  From 1915 to 1958 Anthony was the Packard distributor for all of California (one out of every seven Packards ever sold were through the Anthony organization).  Earl Anthony also founded the Los Angeles auto show and contributed to developing the concept of the gasoline service station. In addition to automobiles, he also operated the radio stations KFI and KECA in Los Angeles. Although KFI has always been located in Los Angeles, it had its own antenna in San Francisco for many years, atop the British Motors Building.');
				$module->addBodyText('Today, 60,000 solar panels, installed in spring of 2008, replace the two large antennas.');							
				$module->addImageNode('/temp/images/packard_retouch.png');
			
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