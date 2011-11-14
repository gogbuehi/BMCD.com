<?php
	require_once 'includes/models/page/bmcd/bmcd_901_page.php';
	require_once 'includes/models/page/module_node.php';
    class AboutUsGeneral extends Bmcd901Page {
    	function __construct($url=null) {
    		parent::__construct('About Us - General',$url);
			$this->makeContent();
    	}
		
		function makeContent() {
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticleTextRight();
				
				$module->addBodyText('For over sixty years British Motors has been a landmark in the San Francisco community. Our four story dealership includes indoor parking and houses all of our inventory onsite.');
				$module->addBodyText('Conveniently located off of Van Ness Avenue and Ellis, with easy access to Hwy 101, the Golden Gate Bridge and the Bay Bridge,  British Motors is an ideal location to purchase ');
				//$module->addMoreLink('/inventory');
				//$module->child->addMoreText('new or pre-owned vehicle');
				$module->child->appendChild( $module->createAnchoredText('new or pre-owned vehicle','/inventory') );
				//$module->addMoreText(' or ');
				//$module->child->appendChild( $module->createAnchoredText('service','/parts_service/service') );
				$module->addMoreText(' or service your vehicle, if you work, live or just enjoy spending time in San Francisco.');
				$module->addImage('/temp/images/bmcd_front.png');
				$module->setMoreAttribute('width',460);
				$module->setMoreAttribute('height',380);
				
				//$module1->addImageNode(CONTENT.'img/sitebody/bmcd_front.png',460,380);	
			//Add the module to the Floor.	
			$floor->appendChild($module);	
			//Add the floor to the page.	
			$this->appendContent($floor);

			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticleTextRight();
				$module->addBodyText('British Motor Car Distributors, Ltd. began with a passion for exciting automobiles. We are fortunate to be headquartered in a 82-year-old ');
				
				$module->child->appendChild( $module->createAnchoredText('Bernard Maybeck','/about/history') );
				$module->addMoreText(' landmark showroom, originally constructed in by the renowned architect to house Packards. To see more about the rich history of the building, the legacy of the business and the renowned people who have contributed to it, please visit the ');
				$module->child->appendChild( $module->createAnchoredText('history','/about/history') );
				$module->addMoreText(' section of our website.');
				
				$module->addBodyText('Today we represent the finest brands in many different segments: ');
				//$module->addMoreLink('/inventory/jaguar',SUBDOMAIN_901);
				//$module->child->addMoreText('Jaguar');
				$module->child->appendChild( $module->createAnchoredText('Jaguar','/inventory/jaguar') );
				$module->addMoreText(' and ');
				//$module->addMoreLink('/inventory/land_rover',SUBDOMAIN_901);
				//$module->child->addMoreText('Land Rover');
				$module->child->appendChild( $module->createAnchoredText('Land Rover','/inventory/land_rover') );
				$module->addMoreText(' in the original British Motors Building, 901 Van Ness, as well as ');
				$module->addMoreLink('/inventory/bentley',SUBDOMAIN_999);
				$module->child->addMoreText('Bentley');
				$module->addMoreText(', ');
				$module->addMoreLink('/inventory/lambo',SUBDOMAIN_999);
				$module->child->addMoreText('Lamborghini');
				$module->addMoreText(', ');
				$module->addMoreLink('/inventory/lotus',SUBDOMAIN_999);
				$module->child->addMoreText('Lotus');
				//$module->child->appendChild( $module->createAnchoredText('Lotus','/inventory/lotus') );
				$module->addMoreText(', in the adjacent building, at 999 Van Ness.  Because of our approach to customer service and building long lasting relationships, many of our customers have purchased vehicles from us for decades.');				
				
				$module->addImageNode('/temp/images/setup_c.png');	
				$module->setMoreAttribute('width',460);
				$module->setMoreAttribute('height',380);
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
	//$page = new AboutUsGeneral();
    /*
    $cacheArgs = Page_File::setArgs();
    $cache = new Page_File($cacheArgs);
    $edit = new Page_Edit();
    $cId = $cache->getId();
    $edits = $edit->get('page_file',current($cId));
    if (count($edits) == 0) {
        //Create a cache
        
    }
     *
     *
     */
    //$tLog->debug("About to make a CacheManager");
    
?>