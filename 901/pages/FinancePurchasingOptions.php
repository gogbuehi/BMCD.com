<?php
	require_once 'includes/models/page/bmcd/bmcd_901_page.php';
	require_once 'includes/models/page/module_node.php';
    class FinancePurchasingOptions extends Bmcd901Page {
    	function __construct($url=null) {
    		parent::__construct('Purchasing Options',$url);
			$this->makeContent();
    	}
		
		function makeContent() {

			
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticle();
				$module->addTitleText('Lease vs. Purchasing');				
				$module->addBodyText('At British Motors we will help you find ideal purchasing options for your vehicle. We have long standing relationships with a number of financial institutions or if you prefer we can arrange financing with your bank. Challenge our experienced staff to find the right option for you on  a new vehicle, pre-owned or trade in.');
				$module->addBodyText('');
				$module->addMoreText('Benefits of Leasing','b');
				$module->addMore($this->createNode('ul'));
				$module->child->addMoreText('No down payment','li');
				$module->child->addMoreText('Deductible Notes for business use.','li');
				$module->child->addMoreText('Tax is only charged on monthly payments.','li');
				$module->child->addMoreText('Ease of ownership.','li');
				$module->child->addMoreText('Lower payments than buying','li');
				$module->child->addMoreText('Ease of disposal at end of term','li');
				$module->child->addMoreText('New car every 2 or 3 yrs.','li');
				$module->addBodyText('');
				$module->addMoreText('Benefits of Purchasing','b');
				$module->addMore($this->createNode('ul'));
				$module->child->addMoreText('Preferable to own if you plan to keep vehicle for long period of time.','li');
				$module->child->addMoreText('Pride of ownership','li');
				$module->addImageNode('img/sitebody/bmcd_front.png');
				//$module->addMoreAttribute('height','460');
				//$module->addMoreAttribute('width','380');				
				//Add the module to the Floor.		
				$floor->appendChild($module);		
				//Add the Floor to the page.
				$this->appendContent($floor);
			


		$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticleTextRight();
				$module->addTitleText('British Motors Bank Vendors');				
				$module->addBodyText('Click the links below to visit the web sites of our bank vendors.');
				$module->addBodyText('');
				$module->child->appendChild( $module->createAnchoredText('Bank of the West','https://www.bankofthewest.com') );
				
				$module->addBodyText('');
				$module->child->appendChild( $module->createAnchoredText('JP Morgan Chase Bank','http://www.jpmorganchase.com') );
				
				$module->addBodyText('');
				$module->child->appendChild( $module->createAnchoredText('US Bank','https://www.usbank.com/') );

				$module->addBodyText('');
				$module->child->appendChild( $module->createAnchoredText('Chase','https://www.chase.com/') );
				
				$module->addBodyText('');
				$module->child->appendChild( $module->createAnchoredText('Jaguar Financing','http://www.jaguarusa.com/us/en/ownership/jaguar_credit/overview.htm') );
				$module->addBodyText('');
				$module->child->appendChild( $module->createAnchoredText('Land Rover Financing','http://www.landrover.com/us/en/Dealers/Special_offers_finance/Overview.htm') );

				$module->addImageNode('/temp/images/bmcd_banks_web.png');
				//Add the module to the Floor.		
				$floor->appendChild($module);		
				//Add the Floor to the page.
				$this->appendContent($floor);			
			
		$floor = $this->makeFloor(); //Todo: This should be "createFloor"
				$module = new ModuleNode($this->doc);
				$module->makeModArticle();
				$module->addTitleText('Specials');				
				$module->addBodyText('Up to 60 months on all XF Luxury Models in stock through Jaguar Credit Corporation. Subject to approval of credit. The offer ends on 12/31/2008.');
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