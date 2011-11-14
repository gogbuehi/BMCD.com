<?php
    require_once 'includes/models/page/bmcd/bmcd_999_page.php';
	require_once 'includes/models/page/module_node.php';
	require_once 'includes/services/file_services/external_data_services.php';
	require_once 'includes/models/page/inventory.php';
	require_once 'includes/models/filter.php';
    class InventoryPage extends Bmcd999Page {
    	const IDENTIFIER='_999_inventory_';
    	protected $headerSorts;
		protected $inventory;
		protected $inventoryHeader;
		protected $eds;
        
    	protected $url;

        protected $dynamicTitle;
        protected $filterElements;
    	function __construct($url=null) {
    		parent::__construct('Inventory',$url);
            $this->hasDynamicContent = true;
            $this->url = $url;
            $this->eds = new ExternalDataServices(ExternalDataServices::OFFSET_10_HOURS);
			$this->makeContent();
    	}
		function createInventoryHeader() {
			$this->inventoryHeader = $this->createNode('div');
			$this->inventoryHeader->setClass('MAInventoryHeader');
			//
			$this->inventoryHeader->addText('Models:','p')->setClass('Types');
			$this->headerSorts = $this->createNode('ul');
			$this->headerSorts->setClass('sorts');
			
			return $this->inventoryHeader;
		}
		function addSort($text,$count) {
			$module = $this->createNode('li');
			$module->appendChild($this->createNode('a'));
			$module->setMoreAttribute('href','inventory/new/stype');
			$module->addMoreText("$text ($count)");
			$this->headerSorts->appendChild($module);
		}
		function makeContent() {
			$floor = $this->makeFloor();
			$module = $this->createNode('div');
			$module->setClass('ModInventory');
			$module->appendChild($this->createInventoryHeader());	
					
			$url = INVENTORY_999_URL;
			$eData = $this->eds->getExternalData($url,self::IDENTIFIER);
			//$this->tLog->debug("External data for URL($url): $eData");
			
			$this->inventory = new Inventory($this->doc);
			$this->determineFilters($this->url);
			$recordCount = $this->inventory->buildInventory($eData);
			if ($recordCount == 1) {
                //add the year to the filter
                $this->filterElements['year'] = $this->inventory->getProperName('year');
            }
            $this->setTitle($this->getFilterElements());
			$urlDiv = &$this->inventory->getUrlTemplates();
			
			$module->appendChild($this->inventory);
			$supplement = $this->inventory->getSupplementalRecords();
			if (!is_null($supplement)) {
				$module->appendChild($supplement);
			}
			$module->appendChild($urlDiv);
			$floor->appendChild($module);
			
			$this->appendContent($floor);
			$module->setAttribute('count',$recordCount);
			if($recordCount==0)
				$this->addNoItemsText();
		}
		function addNoItemsText(){
			$floor = $this->makeFloor();
			$module = $this->createNode('div');
			$module->setClass('ModArticle');
			$module->addBodyText('There are no vehicles to dispaly at this time.');
			$floor->appendChild($module);
			$this->appendContent($floor);
		}
        function getFilterElements() {
            $aYear = $this->filterElements['year'];
            $aModel =  $this->inventory->getProperName($this->filterElements['model']);
            $aMake =  $this->inventory->getProperName($this->filterElements['make']);
            $aVin = $this->filterElements['vin'];
            return "$aYear $aModel | $aVin | Inventory | $aMake San Francisco";
        }
		function determineFilters($url=null) {
			$url = new UrlManager($url);
			$components = $url->getUriComponents();
			$this->filterElements = array(
                'make' => 'Lamborgini San Francisco, Lotus San Francisc, Bentley',
                'model' => 'All Models',
                'vin' => 'All Vehicles',
                'year' => ''

            );
			//Break down the URI and determine what filters to use
			if (isset($components[0]) && $components[0] == '') {
				array_shift($components);
			}
			if (count($components) == 1) {
				$this->inventoryHeader->addTitleText('Inventory: All');
                $this->inventory->clearFilters();
			}
			foreach($components as $key => $value) {
				
				switch($key) {
					case 0:
						//This should always be "inventory"
						if ($value != 'inventory') {
							$this->tLog->warn("INVENTORY URI element($key) failed with value($value)");
							return;
						}
						break;
					case 1:
						/**
						 * Possible elements:
						 *  - VIN
						 *  - Make
						 */
						//if ($this->inventory->isVin) {
							
						//}
						
						//For now, assume it is Make
						$this->inventory->clearFilters();
						if ($value == 'lambo' || $value == 'lamborghini') {
							$this->inventory->addFilter(new Filter('Make','Lamborghini'));
							$this->inventoryHeader->addTitleText('Inventory: Lamborghini');
                            $this->filterElements['make'] = 'Lamborghini';
						}
						else if ($value == 'bentley') {
							$this->inventory->addFilter(new Filter('Make','Bentley'));
							$this->inventoryHeader->addTitleText('Inventory: Bentley');
                            $this->filterElements['make'] = 'Bentley';
						}
						else if ($value == 'lotus') {
							$this->inventory->addFilter(new Filter('Make','Lotus'));
							$this->inventoryHeader->addTitleText('Inventory: Lotus');
                            $this->filterElements['make'] = 'Lotus';
						}
						else if ($value == 'all') {
							$this->inventoryHeader->addTitleText('Inventory: All');
							$this->inventory->clearFilters();
						}
						else {
							//This logic needs to be figured out
							$this->inventoryHeader->addTitleText('Inventory: Other');
							$notFilter = new Filter('Make','Lamborghini',false,false,true);
							$notFilter->andFilter('Make','Lotus',false,false,true);
							$notFilter->andFilter('Make','Bentley',false,false,true);
							$this->inventory->addFilter($notFilter);
                            $this->filterElements['make'] = 'Other Makes';
						}
						break;
					case 2:
						//Model
						$this->inventory->clearFilters();
						$this->inventory->addFilter(new Filter('Model',$value));
                        $this->filterElements['model'] = $value;
						break;
					case 3:
						//VIN
						$this->inventory->clearFilters();
						$this->inventory->addFilter(new Filter('VIN',$value,1,true));
                        $this->filterElements['vin'] = $value;
					default:
						//Assume no filters
						
				}
			}
		}
	}
?>