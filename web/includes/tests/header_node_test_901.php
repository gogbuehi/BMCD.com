<?php
	require_once 'includes/models/page/page.php';
	require_once 'includes/models/page/bmcd/header_node.php';
    class HeaderNodeTest extends Page {
    	function __construct() {
    		parent::__construct();
    	}
    	
		function make() {
			$this->setTitle('Header Node Test');
			
			$this->addScript(ScriptNode::SRC_LINK,'/js/url_manager.js');
			$this->addScript(ScriptNode::PAGE_SCRIPT,"redirect_hash('".$_SERVER["REQUEST_URI"]."');");
			$this->addStyle(StyleNode::PAGE_STYLE,"body {background-color:#AFAFFF;}");
			
			$headerNode = new HeaderNode($this->doc,'ModBMCD901Header');
			$headerNode->addLogo('BMCDLogo','/','/imgdir/50x25_Placeholder.jpg','BMCD',50,25);
			$headerNode->addLogo('JaguarLogo','/','/imgdir/50x25_Placeholder.jpg','Jaguar',50,25);
			$headerNode->addLogo('LandRoverLogo','/','/imgdir/50x25_Placeholder.jpg','Land Rover',50,25);
			$headerNode->addTitle('British Motor Car Distributers - Jaguar and Land Rover');
			$headerNode->addSubtitle('Header Subtitle');
			$headerNode->addAddress('Header Address');
			$headerNode->addMenu('Header_Menu');
			//$headerNode->addMenuItem('Header_Menu_Item','/inventory','Inventory',true);
			//$headerNode->addSubMenuItem('/inventory','Header_SubMenu_Item','/test/data','Test Data');
		    //$headerNode->addSubMenuItem('/inventory','Header_SubMenu_Item','/test/data','Test Data');

			//$nClass,$href,$label,$isSelected=false,$subMenu=null
			// ABOUT US
			$headerNode->addMenuItem('Header_Menu_Item','/about','About Us',false);
			$headerNode->addSubMenuItem('/about','Header_SubMenu_Item','/general','General');
			$headerNode->addSubMenuItem('/about','Header_SubMenu_Item','/history','History');
			$headerNode->addSubMenuItem('/about','Header_SubMenu_Item','/our_team','Our Team');
			$headerNode->addSubMenuItem('/about','Header_SubMenu_Item','/testimonials','Testimonials');
			// INVENTORY 
			$headerNode->addMenuItem('Header_Menu_Item','/inventory','Inventory',false);
			$headerNode->addSubMenuItem('/inventory','Header_SubMenu_Item','/jaguar','Jaguar');
			$headerNode->addSubMenuItem('/inventory','Header_SubMenu_Item','/land_rover','Land Rover');	
			// RESEARCH 
			$headerNode->addMenuItem('Header_Menu_Item','/research','Research',false);
			$headerNode->addSubMenuItem('/research','Header_SubMenu_Item','/new_car_info','New Car Info');
			$headerNode->addSubMenuItem('/research','Header_SubMenu_Item','/forum','Forum');	
			$headerNode->addSubMenuItem('/research','Header_SubMenu_Item','/news_reviews','News/Reviews');	
			// FINANCE
			$headerNode->addMenuItem('Header_Menu_Item','/finance','finance',false);
			$headerNode->addSubMenuItem('/finance','Header_SubMenu_Item','/privacy_policy','Privacy Policy');
			$headerNode->addSubMenuItem('/finance','Header_SubMenu_Item','/tax_benefits','Tax Benefits');	
			$headerNode->addSubMenuItem('/finance','Header_SubMenu_Item','/bank_vendors','Bank Vendors');	
			$headerNode->addSubMenuItem('/finance','Header_SubMenu_Item','/quick_quite','Quick Quote');	
			// PARTS/SERVICE
			$headerNode->addMenuItem('Header_Menu_Item','/parts_service','Finance',false);
			$headerNode->addSubMenuItem('/parts_service','Header_SubMenu_Item','/appointment_scheduler','Appointment Scheduler');
			$headerNode->addSubMenuItem('/parts_service','Header_SubMenu_Item','/bmcd_store','BMCS Store');	
			$headerNode->addSubMenuItem('/parts_service','Header_SubMenu_Item','/order_parts','Order Parts');	
			// EVENTS
			$headerNode->addMenuItem('Header_Menu_Item','/events','Events',false);		
			
			$this->appendContent($headerNode);
			
			return $this->getHtml();
		}	
    }
	
	$test = new HeaderNodeTest();
	
	echo $test->make();
?>