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
			$headerNode->addTitle('Header Title');
			$headerNode->addSubtitle('Header Subtitle');
			$headerNode->addAddress('Header Address');
			$headerNode->addMenu('Header_Menu');
			$headerNode->addMenuItem('Header_Menu_Item','/inventory','Inventory',true);
			$headerNode->addSubMenuItem('/inventory','Header_SubMenu_Item','/test/data','Test Data');
			
			$headerNode->addMenuItem('Header_Menu_Item','/inventory','Inventory',true);
			$headerNode->addSubMenuItem('/inventory','Header_SubMenu_Item','/test/data','Test Data');
			
			$this->appendContent($headerNode);
			
			return $this->getHtml();
		}	
    }
	
	$test = new HeaderNodeTest();
	
	echo $test->make();
?>