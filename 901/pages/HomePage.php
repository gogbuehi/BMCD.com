<?php
	require_once 'includes/models/page/bmcd/bmcd_901_page.php';
	require_once 'includes/models/page/module_node.php';
	require_once 'includes/models/page/bmcd/modules/media_highlights_module.php';
	require_once 'includes/services/file_services/external_data_services.php';
	require_once 'includes/models/page/inventory.php';
	require_once 'includes/models/filter.php';
	
	
    class HomePage extends Bmcd901Page {
		const IDENTIFIER='_901_inventory_';
		protected $inventory;
		protected $eds;
	
	
    	function __construct($url=null) {
    		parent::__construct('',$url=null);
            $this->hasDynamicContent = true;
			Inventory::$idCount = 0;
            $this->makeContent();
            
    	}
		
		function makeContent() {
	
		$this->eds = new ExternalDataServices();
		// Create Highlights Module
	
			$floor = $this->makeFloor();
			$module = new MediaHighlightsModule($this->doc);
			$module->addVideo('/temp/video/2009XFLaunchFilm90_BMCD_LR_382x280_pad.flv');
			$module->addVideo('/temp/video/lr2_launch_1_p3_bmcd_lr_480x274.flv');
			$module->addVideo('/temp/video/H264_Anthem_Edited_BMCD_LR_480x270_nDist.flv');
			$module->addVideo('/temp/video/lr2_launch_1_p4_bmcd_lr_480x274.flv');
			$module->addVideo('/temp/video/JAGUAR_History_BMCD_LR_374x280_pad.flv');
			$module->addVideo('/temp/video/lr2_launch_1_p1_bmcd_lr_480x274.flv');
			$module->addVideo('/temp/video/lr2_launch_1_p2_bmcd_lr_480x274.flv');
			$module->addVideo('/temp/video/xbxt_0806h_xf_30_edit_bmcd_lr_420x280.flv');
			$module->addVideo('/temp/video/lr2_launch_1_p5_bmcd_lr_480x274.flv');
			$module->addVideo('/temp/video/qlna9136_bmcd_lr_420x280.flv');
			$module->setImageModule('/temp/images/bmcd_901.png','/about/general');
			$module->addText('Generations of repeat customers continue to rely upon what you may just now be discovering: our unwavering commitment to providing you, our customer, with value, quality, and excellence in sales and service. Our daily inspiration comes from our customers\' standards and the Qvale family reputation for integrity since 1947.');
			$module->addMore($this->createNode('br'));
			$floor->appendChild($module);
			$this->appendContent($floor);
	
		// Create Featured Items Module	
			$floor = $this->makeFloor();
			$module = new ModuleNode($this->doc);
			$module->setClass('ModMultiImageH');
			$module->addTitleText('Featured Items');
	
	
			$url = INVENTORY_901_URL;
			$eData = $this->eds->getExternalData($url,self::IDENTIFIER);
			$this->inventory = new Inventory($this->doc);
			$rand = rand(0,1);
			$this->inventory->addFilter(new Filter('Make','Jaguar',($rand==0 ? 3 : 2),true));
			$this->inventory->addFilter(new Filter('Make','Land Rover',($rand==0 ? 2 : 3),true));
			$this->inventory->buildInventory($eData);
			$module->appendChild($this->inventory);


			
			$floor->appendChild($module);
            
			$this->appendContent($floor);
	
		}
    }
?>

