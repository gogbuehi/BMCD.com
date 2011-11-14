<?php
    require_once 'includes/models/page/bmcd/bmcd_901_page.php';
	require_once 'includes/models/page/module_node.php';
	require_once 'includes/services/file_services/external_data_services.php';
	require_once 'includes/models/page/inventory.php';
	require_once 'includes/models/filter.php';
    class InventoryPage extends Bmcd901Page {
    	const IDENTIFIER='_901_inventory_';
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
			$this->inventoryHeader->addText('Models:','p')->setClass('Types');
			$this->headerSorts = $this->createNode('ul');
			$this->headerSorts->setClass('sorts');
			/*
			$this->addSort('Range Rover',26);
			$this->addSort('Range Rover Sport',3);
			$this->addSort('LR2',3);
			$this->addSort('xf',4);
			$this->addSort('s-type',3);
			$this->addSort('t-type',4);
			*/
			return $this->inventoryHeader;
		}
		function addSort($text,$count) {
			$module = $this->createNode('li');
			$module->appendChild($this->createNode('a'));
			$module->setMoreAttribute('href','/inventory/new/stype');
			$module->addMoreText("$text ($count)");
			$this->headerSorts->appendChild($module);
		}
		function makeContent() {
			$floor = $this->makeFloor();
			$module = $this->createNode('div');
			$module->setClass('ModInventory');
			$module->appendChild($this->createInventoryHeader());	
					
			$url = INVENTORY_901_URL;
			$eData = $this->eds->getExternalData($url,self::IDENTIFIER);
			//$this->tLog->debug("External data for URL($url): $eData");
			
			$this->inventory = new Inventory($this->doc);
			$this->determineFilters($this->url);
			//$this->inventory->addFilter(new Filter('Make','Jaguar',10,true));
			//$this->inventory->addFilter(new Filter('Make','Land Rover',3,true));
			$recordCount = $this->inventory->buildInventory($eData);
            if ($recordCount == 1) {
                //add the year to the filter
                $this->filterElements['year'] = $this->inventory->getProperName('year');
            }
            $this->setTitle($this->getFilterElements());
			
			//$this->page->appendContent($inventory);
			$urlDiv = &$this->inventory->getUrlTemplates();
			//$this->page->appendContent($urlDiv);
			
			$module->appendChild($this->inventory);
			$supplement = $this->inventory->getSupplementalRecords();
			if (!is_null($supplement)) {
				$module->appendChild($supplement);
			}
				
			$module->appendChild($urlDiv);
			$floor->appendChild($module);
			
			$this->appendContent($floor);
	
			$module->setAttribute('count',$recordCount);
			if($recordCount==0) {
				$this->addNoItemsText();
            }

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
            return "$aYear $aModel, $aMake | $aVin | Inventory | British Motor Car Distributors";
        }
		function determineFilters($url=null) {
			$url = new UrlManager($url);
			$components = $url->getUriComponents();
			$this->filterElements = array(
                'make' => 'All Makes',
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
                $this->inventoryHeader->setMoreAttribute('id', Inventory::IDENTIFIER.'_header');
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
						if ($value == 'jaguar') {
							$this->inventory->addFilter(new Filter('Make','Jaguar'));
							$this->inventoryHeader->addTitleText('Inventory: Jaguar');
                            $this->inventoryHeader->setMoreAttribute('id', Inventory::IDENTIFIER.'_header');
                            $this->filterElements['make'] = 'Jaguar';
						}
						else if ($value == 'land_rover') {
							$this->inventory->addFilter(new Filter('Make','Land Rover'));
							$this->inventoryHeader->addTitleText('Inventory: Land Rover');
                            $this->inventoryHeader->setMoreAttribute('id', Inventory::IDENTIFIER.'_header');
                            $this->filterElements['make'] = 'Land Rover';
						}
						else if ($value == 'all') {
							$this->inventoryHeader->addTitleText('Inventory: All');
                            $this->inventoryHeader->setMoreAttribute('id', Inventory::IDENTIFIER.'_header');
                            $this->filterElements['make'] = 'All Vehicles';
						}
						else {
							//This logic needs to be figured out
							$this->inventoryHeader->addTitleText('Inventory: Other');
                            $this->inventoryHeader->setMoreAttribute('id', Inventory::IDENTIFIER.'_header');
							$notFilter = new Filter('Make','Jaguar',false,false,true);
							$notFilter->andFilter('Make','Land Rover',false,false,true);
							$this->inventory->addFilter($notFilter);
                            $this->filterElements['make'] = 'Other Vehicles';
						}
						break;
					case 2:
						//Model
						$this->inventory->clearFilters();
						$this->inventory->addFilter(new Filter('uri_model',$value));
                        $this->inventoryHeader->addTitleText('Inventory: '.$value);
                        $this->inventoryHeader->setMoreAttribute('id', Inventory::IDENTIFIER.'_header');
                        $this->filterElements['model'] = $value;
						break;
					case 3:
						//VIN
						$this->inventory->clearFilters();
						$this->inventory->addFilter(new Filter('VIN',$value,1,true));
                        $this->inventoryHeader->addTitleText('Inventory: '.$value);
                        $this->inventoryHeader->setMoreAttribute('id', Inventory::IDENTIFIER.'_header');
                        $this->filterElements['vin'] = $value;
                        break;
					default:
						//Assume no filters
				}
			}
		}
	}
?>