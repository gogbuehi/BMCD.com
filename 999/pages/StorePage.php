<?php
    require_once 'includes/models/page/bmcd/bmcd_999_page.php';
	require_once 'includes/models/page/module_node.php';
	//require_once 'includes/services/file_services/external_data_services.php';
	require_once 'models/Data_Store.php';
	require_once 'includes/models/page/store.php';
	require_once 'includes/models/filter.php';
    class StorePage extends Bmcd999Page {
    	const IDENTIFIER='_999_store_';
    	protected $headerSorts;
		protected $store;
		protected $storeHeader;
		protected $eds;
        protected $filterElements;
		
    	function __construct($url=null) {
    		parent::__construct('Boutique',$url);
            $this->hasDynamicContent = true;
			$this->url = $url;
			//$this->eds = new ExternalDataServices();
			$this->makeContent();
    	}
		function makeContent() {
			$floor = $this->makeFloor();
			$module = $this->createNode('div');
			$module->setClass('ModStore');
					
			//$url = STORE_999_URL;
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
		function createBrandList(){
			$brands = $this->createNode('ul');
			$brands->setClass('makes');
			$brands->appendChild($this->createBrandImage('Bentley','http://'.CONTENT.'/temp/images/bentley/bentley.png','90','46','/boutique/bentley'));
			$brands->appendChild($this->createBrandImage('Lotus','http://'.CONTENT.'/temp/images/lotus/lotus.png','90','46','/boutique/lotus'));
			$brands->appendChild($this->createBrandImage('Lamborghini','http://'.CONTENT.'/temp/images/lambo/lambo.png','90','46','/boutique/lambo'));
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
		function addNoItemsText(){
			$floor = $this->makeFloor();
			$module = $this->createNode('div');
			$module->setClass('ModArticle');
			$module->addBodyText('There are no items to dispaly at this time.');
			$floor->appendChild($module);
			$this->appendContent($floor);
		}
		function getFilterElements() {
            $aBrand =  $this->store->getProperName($this->filterElements['brand']);
            $aTitle =  $this->store->getProperName($this->filterElements['item']);
            //$aTitle = $this->filterElements['title'];
            return "$aTitle | Boutique | $aBrand San Francisco";
        }
		function determineFilters($url=null) {
			$url = new UrlManager($url);
			$components = $url->getUriComponents();
			$getSupplemental = false;
            $this->filterElements = array(
                'brand' => 'Lamborghini San Francisco, Lotus San Francisco, Bentley',
                'item' => 'All Items',
                'title' => 'All Items'

            );
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
						if ($value == 'lambo') {
							$this->store->addFilter(new Filter('brand','Lamborghini'));
							//$this->storeHeader->addTitleText('Lamborghini');
                            $this->filterElements['brand'] = 'Lamborghini';
						}
						else if ($value == 'bentley') {
							$this->store->addFilter(new Filter('brand','Bentley'));
							//$this->storeHeader->addTitleText('Bentley');
                            $this->filterElements['brand'] = 'Bentley';
						}
						else if ($value == 'lotus') {
							$this->store->addFilter(new Filter('brand','Lotus'));
							//$this->storeHeader->addTitleText('Lotus');
                            $this->filterElements['brand'] = 'Lotus';
						}
						else if ($value == 'all') {
							//$this->storeHeader->addTitleText('All');
						}
						else {
							//This logic needs to be figured out
							//$this->storeHeader->addTitleText('Other');
							$notFilter = new Filter('brand','Lamborghini',false,false,true);
							$notFilter->andFilter('brand','Lotus',false,false,true);
							$notFilter->andFilter('brand','Bentley',false,false,true);
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
?>