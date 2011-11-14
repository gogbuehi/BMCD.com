<?php
    
	//require_once 'includes/services/file_services/external_data_services.php';
	require_once 'includes/models/page/page.php';
	//require_once 'includes/models/page/inventory.php';
	//require_once 'includes/models/filter.php';
	
	class BmcdPage extends Page {
		//protected $eds;
		protected $headerNode;
		protected $footerNode;
		function __construct() {
			parent::__construct();
			$this->makeHeader();
			$this->makeFooter();
		}
		/**
		 * Make the page's header and menu
		 * @return void
		 */
		function makeHeader() {
			$headerNode = new HeaderNode($this->doc,'ModBMCD901Header');
			$headerNode->addLogo('BMCDLogo','/','/imgdir/50x25_Placeholder.jpg','BMCD',50,25);
			$headerNode->addLogo('JaguarLogo','/','/imgdir/50x25_Placeholder.jpg','Jaguar',50,25);
			$headerNode->addLogo('LandRoverLogo','/','/imgdir/50x25_Placeholder.jpg','Land Rover',50,25);
			$headerNode->addTitle('Title');
			$headerNode->addSubtitle('Header Subtitle');
			$headerNode->addAddress('Header Address');
			$headerNode->addMenu('Header_Menu');
			$headerNode->addMenuItem('Section','/home','Home');
			$headerNode->addMenuItem('Section','/inventory','Inventory',true);
			$headerNode->addSubMenuItem('/inventory','Subsection','/test/data','Test Data');
			
			$this->headerNode = &$headerNode;
			//The parent version needs to be called
			parent::appendContent($headerNode);
		}
		function makeFooter() {
			$footerNode = $this->createNode('div');
			$footerNode->setClass('footer');
			$footerText = $this->createTextNode('THIS NODE NEEDS A FOOTER_NODE CLASS CREATED FOR IT.');
			$footerNode->appendChild($footerText);
			
			$this->footerNode = &$footerNode;
			//The parent version needs to be called
			parent::appendContent($footerNode);
		}
		/**
		 * Appends content nodes before the footerNode
		 * @return void
		 * @param $cNode ContentNode	The ContentNode to insert into the page
		 */
		function appendContent($cNode) {
			parent::appendContent($cNode,$this->footerNode);
		}
		/*
		//Get external page content
		function retrievePageContent($uri) {
			$url = INVENTORY_901_URL;
			$eData = $this->eds->getExternalData($url);
			//$this->tLog->debug("External data for URL($url): $eData");
			
			$inventory = new Inventory($this->page->doc);
			$inventory->addFilter(new Filter('Make','Jaguar',3,true));
			$inventory->addFilter(new Filter('Make','Land Rover',3,true));
			$inventory->buildInventory($eData);
			
			$this->appendContent($inventory);
			$urlDiv = &$inventory->getUrlTemplates();
			$this->appendContent($urlDiv);
			
			$this->tLog->debug('Done processing nodes...');
			$html = $this->getBodyInnerHtml();
			return $html;
		}
		*/
		
	}
?>