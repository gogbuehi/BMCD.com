<?php
	require_once 'includes/models/page/bmcd/bmcd_999_page.php';
	require_once 'includes/models/page/module_node.php';
	require_once 'includes/models/page/bmcd/modules/media_highlights_module.php';
	require_once 'includes/services/file_services/external_data_services.php';
	require_once 'includes/models/page/inventory.php';
	require_once 'includes/models/filter.php';
	
	
    class HomePage extends Bmcd999Page {
		const IDENTIFIER='_999_inventory_';
		protected $inventory;
		protected $eds;
	
	
    	function __construct() {
    		parent::__construct('');
            $this->hasDynamicContent = true;
			Inventory::$idCount = 0;
			$this->makeContent();
    	}
		
		function makeContent() {
	
		$this->eds = new ExternalDataServices();
		// Create Highlights Module
	
	

			$floor = $this->makeFloor();
			$module = new MediaHighlightsModule($this->doc);
			$module->addVideo('/temp/video/bentley_teaser_march_bmcd_lr_470x168_pad.flv');
			$module->addVideo('/temp/video/GallardoLP560-4-1_BMCD_LR_470x276_nDist.flv');
			$module->addVideo('/temp/video/Bentley_MultiCarPromo_main_BMCD_LR_480x272_pad.flv');
			$module->addVideo('/temp/video/exige_bmcd_lr_508x280_pad.flv');
			$module->addVideo('/temp/video/Bentley_Pwr_Legend_2_BMCD_LR_480x270_nDist.flv');
			$module->addVideo('/temp/video/Murcielago_LP640_BMCD_LR_374x280_pad.flv');
			$module->addVideo('/temp/video/Bentley_Pwr_Legend_3_BMCD_LR_480x270_nDist.flv');
			$module->addVideo('/temp/video/Continental_GTC_BMCD_LR_480x270_nDist.flv');
			$module->addVideo('/temp/video/elise_bmcd_lr_508x280_pad.flv');
			$module->addVideo('/temp/video/Continental_Series_BMCD_LR_480x270_nDist.flv');
			$module->setImageModule('/temp/images/arnage_ggb.png','/research/model_lineup/bentley/arnage/t');
			$module->addText('Welcome to San Francisco\'s premiere luxury automotive dealership. Our website will assist you in discovering the details about our products, while learning more about us and our services.');
			$module->addMore($this->createNode('br'));
			$floor->appendChild($module);
			$this->appendContent($floor);
	
		// Create Featured Items Module	
			$floor = $this->makeFloor();
			$module = new ModuleNode($this->doc);
			$module->setClass('ModMultiImageH');
			$module->addTitleText('Featured Items');
	
	
			$url = INVENTORY_999_URL;
			$eData = $this->eds->getExternalData($url,self::IDENTIFIER);
			$this->inventory = new Inventory($this->doc);
			$this->inventory->addFilter(new Filter('Make','Bentley',2,true));
			$this->inventory->addFilter(new Filter('Make','Lotus',1,true));
			$this->inventory->addFilter(new Filter('Make','Lamborghini',2,true));
			$this->inventory->buildInventory($eData);
			$module->appendChild($this->inventory);
			
			$floor->appendChild($module);
			$this->appendContent($floor);
	
		}
    }
?>