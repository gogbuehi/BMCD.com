<?php
	require_once 'includes/models/page/bmcd/bmcd_901_page.php';
	require_once 'includes/models/page/module_node.php';
	//require_once 'includes/services/file_services/external_data_services.php';
	require_once 'models/Data_Store.php';
	require_once 'includes/models/page/store.php';
	require_once 'includes/models/filter.php';
	
    class StorePage extends Bmcd901Page {
		const IDENTIFIER='_901_store_';
    	protected $headerSorts;
		protected $store;
		protected $storeHeader;
		protected $eds;

        protected $url;

        protected $dynamicTitle;
        protected $filterElements;
    	function __construct($url=null) {
    		parent::__construct('Boutique',$url);
            $this->hasDynamicContent = true;
            $this->url = $url;
			//$this->eds = new ExternalDataServices();
			$this->makeContent();
            $this->filterElements = array();
    	}
		function makeContent() {
			$floor = $this->makeFloor();
			$module = $this->createNode('div');
			$module->setClass('ModStore');	
					
			//$url = STORE_901_URL;
			//$eData = $this->eds->getExternalData($url,self::IDENTIFIER);
			
			// Retreive all records from DB
			$record = new Data_Store(FALSE);
        	$requiredParams = array(
				'blnvalid' => true,
				'visible' => true,
				'domain' => $_SERVER['SERVER_NAME']
			);
			$records = $record->getComplex($requiredParams);
			$eData = array();
			foreach ($records as $key => $value) {
				array_push($eData,$value->getFields());
			}
			rsort($eData);
			//$this->tLog->debug("External data for URL($url): $eData");
			$this->store = new Store($this->doc);
			$getSupplemental = $this->determineFilters($this->url);
			$recordCount = $this->store->buildInventory($eData,$getSupplemental);
            $this->tLog->debug("Record count, after building store is: ".$recordCount);
            if ($recordCount == 1) {
                //add the year to the filter
                $this->filterElements['title'] = $this->store->getProperName('title');
            }
            $this->setTitle($this->getFilterElements());

			$urlDiv = &$this->store->getUrlTemplates();
			$module->appendChild($this->createBrandList());
			$module->appendChild($this->store);
			$supplement = $this->store->getSupplementalRecords();
			if (!is_null($supplement)) {
				$module->appendChild($supplement);
			}
			$module->appendChild($urlDiv);
			$floor->appendChild($module);
			
			$this->appendContent($floor);
			if($recordCount==0)
				$this->addNoItemsText();
		}
		function addNoItemsText(){
			$floor = $this->makeFloor();
			$module = $this->createNode('div');
			$module->setClass('ModArticle');
			$module->addBodyText('There are no items to dispaly at this time.');
			$floor->appendChild($module);
			$this->appendContent($floor);
		}
		function createBrandList(){
			$brands = $this->createNode('ul');
			$brands->setClass('makes');
			$brands->appendChild($this->createBrandImage('Jaguar','http://'.CONTENT.'/temp/images/jaguar/jag.png','90','46','/boutique/jaguar'));
			$brands->appendChild($this->createBrandImage('Land Rover','http://'.CONTENT.'/temp/images/land_rover/land_rover.png','90','46','/boutique/landrover'));
			return $brands;	
		}
		function createBrandImage($alt,$src,$w,$h,$href){
			$img = $this->createNode('img');
			$img->setAttribute('alt',$alt);
			$img->setAttribute('src',$src);
			$img->setAttribute('width',$w);
			$img->setAttribute('height',$h);
			$a = $this->createNode('a');
			$a->appendChild($img);
			$a->setAttribute('href',$href);
			$li = $this->createNode('li');
			$li->appendChild($a);
			return $li;
		}
		function getFilterElements() {
            $aBrand =  $this->store->getProperName($this->filterElements['brand']);
            $aTitle =  $this->store->getProperName($this->filterElements['item']);
            //$aTitle = $this->filterElements['title'];
            return "$aTitle, $aBrand | Boutique | British Motor Car Distributors";
        }
		function determineFilters($url=null) {
			$url = new UrlManager($url);
			$components = $url->getUriComponents();
            $this->filterElements = array(
                'brand' => 'All Brands',
                'item' => 'All Items',
                'title' => 'All Items'

            );
			$getSupplemental = false;
			//Break down the URI and determine what filters to use
			if (isset($components[0]) && $components[0] == '') {
				array_shift($components);
			}
			if (count($components) == 1) {
				//Just filter it down to 4 of each brand
				//$this->module->addTitleText('All');
				$this->store->clearFilters();
			}
			foreach($components as $key => $value) {
				
				switch($key) {
					case 0:
						//This should always be "boutique"
						if ($value != 'boutique') {
							$this->tLog->warn("STORE URI element($key) failed with value($value)");
							return;
						}
						break;
					case 1:
						/**
						 * Possible elements:
						 *  - ID
						 *  - Brand
						 */
						//if ($this->inventory->isVin) {
							
						//}
						
						$this->store->clearFilters();
						//For now, assume it is Brand
						if ($value == 'jaguar') {
							$this->store->addFilter(new Filter('brand','Jaguar'));
							//$this->storeHeader->addTitleText('Jaguar');
                            $this->filterElements['brand'] = 'Jaguar';
						}
						else if ($value == 'landrover') {
							$this->store->addFilter(new Filter('brand','Land Rover'));
							//$this->storeHeader->addTitleText('Land Rover');
                            $this->filterElements['brand'] = 'Land Rover';
						}
						else if ($value == 'all') {
							//$this->storeHeader->addTitleText('All');
						}
						else {
							//This logic needs to be figured out
							//$this->storeHeader->addTitleText('Other');
							$notFilter = new Filter('brand','Jaguar',false,false,true);
							$notFilter->andFilter('brand','Land Rover',false,false,true);
							$this->store->addFilter($notFilter);
						}
						break;
					case 2:
						//ID
						$this->store->clearFilters();
						$this->store->addFilter(new Filter('productId',$value));
						$getSupplemental = true;
                        $this->filterElements['item'] = $value;
						break;
					default:
						//Assume no filters
						
					break;
				}
			}
		return $getSupplemental;
		}
    }
	//$page = new StorePage();
	//echo $page->getHtml();
?>