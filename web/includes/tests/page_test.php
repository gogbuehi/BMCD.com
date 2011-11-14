<?php
	require_once 'includes/models/page/bmcd/bmcd_901_page.php';
	require_once 'includes/models/page/module_node.php';
	require_once 'includes/models/page/bmcd/modules/media_highlights_module.php';
    class PageTest extends Bmcd901Page {
    	function __construct() {
    		parent::__construct();
			$this->makeContent();
    	}
		
		function makeContent() {
			$floor1 = $this->makeFloor(); //Todo: This should be "createFloor"
			$module = new MediaHighlightsModule($this->doc);
			$module->addVideo('/temp/video/qlna9139_bmcd_lr_420x280.flv');
			$module->addVideo('/temp/video/lr2_launch_1_p3_bmcd_lr_480x274.flv');
			$module->addVideo('/temp/video/qlna9139_bmcd_lr_420x280.flv"');
			$module->addVideo('/temp/video/xbxt_0806h_xf_30_edit_bmcd_lr_420x280.flv');
			$module->addVideo('/temp/video/lr2_launch_1_p4_bmcd_lr_480x274.flv');
			
			$module->setImageModule('/temp/images/bmcd_901.png','http://www.google.com','Did you know we can use tootips?');
			
			$module->addText('Generations of repeat customers continue to rely upon what you may just now be discovering: our unwavering commitment to providing you, our customer, with value, quality, and excellence in sales and service. Our daily inspiration comes from our customers’ standards and the Qvale family reputation for integrity since 1947.');
			$module->addText(); //Adds a <br /> tag
			
			//Add the module to the Floor
			$floor1->appendChild($module);
			
			$floor2 = $this->makeFloor();
			$plainModule = new ModuleNode($this->doc);
			$plainModule->setClass('Plain_Module');
			$plainModule->addText("Testing if this works.");
			
			$floor2->appendChild($plainModule);
			
			//Once done with adding to the Floor, add the floor to this page
			$this->appendContent($floor1);
			$this->appendContent($floor2);
			
			/**
			 * Note the difference between "appendChild" and "appendContent"
			 * "appendChild" is for adding a node as a child of another node
			 * "appendContent" is for adding a node as a child of the Page's body
			 */
			
		}
    }
	$pageTest = new PageTest();
	echo $pageTest->getHtml();
?>