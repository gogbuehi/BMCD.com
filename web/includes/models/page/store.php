<?php
	require_once 'includes/config/globals.php';
	require_once 'includes/models/page/content_node.php';
	require_once 'includes/models/page/table_node.php';
	require_once 'includes/models/filter.php';
    class Store extends ContentNode {
    	const DEFAULT_CLASS='store';
		const SUPPLEMENTAL_CLASS='supplemental';

        const IDENTIFIER = 'store_';
        static $idCount = 0;
    	/**
    	 * Associative array to apply any filtering on Inventory with
    	 * $key's correspond to Fields to filter by
    	 * $value's correspond to values to  check against
    	 */
    	public $filterArray;
		/**
		 * A DOMDocument object to use when building the inner nodes
		 * of the inventory's table.
		 */
		private $doc;
		private $urlTemplatesNode;
		protected $data;
		/**
		 * Selected vehicles
		 * This is only used when filtered by ID
		 */
		private $supplementalInventory;
		private $optionsTable;

        private $referenceArray;
		function __construct(&$doc) {
			parent::__construct('table',$doc);

            $this->tLog->debug("CREATING STORE WITH COUNT ".self::$idCount);
            $this->setAttribute('id', self::IDENTIFIER.self::$idCount++);
            
			$this->filterArray = array();
			$this->setClass(self::DEFAULT_CLASS);
			$this->supplementalInventory = null;
            $this->referenceArray = array();
		}
		/**
		 * Function to add filters to the inventory
		 * Uses delimeter to add multiple values for a single field
		 * Multiple values are treated as "OR" values
		 * @return void
		 * @param $field String		The column to filter by
		 * @param $value String		The value being sought
		 */
		function addFilter($filter) {
			array_push($this->filterArray,$filter);
			$this->tLog->debug('Filter added...'.$filter->toString());
		}
		function clearFilters() {
			$this->filterArray = array();
		}
		function buildInventory($data,$getSupplemental=false) {
			//Store the original data
			$this->data = $data;
			try {
				$records = $this->processInventoryData($data);
			}
			catch (Exception $e) {
				$msg = "Failed to process inventory data[[$data]]".$e->toString();
				throw new Exception($msg);
			}
			//Build Table Header
			$firstRecord = array_shift($records);
			$this->appendChild($this->createInventoryHeader($firstRecord));
			//$this->appendChild($this->buildInventoryHeader($firstRecord));
			array_unshift($records,$firstRecord);
			
			//Build Table Body
			$bodyNode = $this->createNode('tbody');
			//$bodyNode = new ContentNode('tbody',$this->doc);
			try {
				$count = $this->buildInventoryBody($records,$bodyNode,$getSupplemental);
			}
			catch (Exception $e) {
				$msg = "Building inventory records failed at key($key). ".$e->toString();
				throw new Exception($msg);
			}
			$this->appendChild($bodyNode);
			$this->urlTemplates();
			return $count;
		}		
		/**
		 * Process Inventory Data
		 * The data is expected to be a tab-delimited
		 * file containing vehicle information
		 * @return 
		 * @param $data Object
		 */
		function processInventoryData($data) {
			//$lines = explode("\n",$data);
			//$fields = null;
			//$recordsets = array();
			//Go line by line, exploding by tab
			/*foreach ($lines as $key => $value) {
				if (is_null($fields)) {
					$fields = explode("\t",$value);
					continue;
				}
				else {
					$values = explode("\t",$value);
					if (count($fields) == count($values))
						$recordsets[$key] = $this->processRecord($fields,$values);
				}
			}*/
            
			return $data; //$recordsets;
		}
		function processRecord($recordArray) {
            return $this->addUrlFieldsToRecord($recordArray);
		}
        /**
         * Special method that puts in record fields to match the URI against
         */
        function addUrlFieldsToRecord($recordArray) {
            //$recordArray['uri_brand'] = str_replace(' ','_',strtolower($recordArray['brand']));
            //$recordArray['uri_item'] = str_replace(' ','_',strtolower($recordArray['productId']));
            if (!isset($this->referenceArray[$recordArray['productId']])) {
                $this->referenceArray[$recordArray['productId']] = $recordArray['title'];
            }
            if (!isset($this->referenceArray[$recordArray['uri_item']])) {
                $this->referenceArray[$recordArray['uri_item']] = $recordArray['productId'];
            }
            if (!isset($this->referenceArray['title'])) {
                $this->referenceArray['title'] = $recordArray['title'];
                $this->tLog->debug("Setting title to: " .$recordArray['title']." and productId is: ".$recordArray['productId']);
                $this->tLog->debug('ReferenceArray[title] is: '.$this->referenceArray['title'] );
            }
            else {
                $this->tLog->debug("Would have set title to: ".$recordArray['title']." and productId is: ".$recordArray['productId']);
            }
            return $recordArray;
        }
        function getProperName($uriVersion) {
            $properName = (isset($this->referenceArray[$uriVersion])) ? $this->referenceArray[$uriVersion] : $uriVersion;
            $this->tLog->debug("Retrivieng proper name of $uriVersion: $properName");
            return $properName;
        }
		function createInventoryHeader($fields) {
			$headerNode = $this->createNode('thead');
			
			$headerTr = $this->createNode('tr');
			
			$this->appendChild($headerNode);
			
			$cellNode = $this->createNode('td');
			$cellNode->setClass('header');
			
			$cellNodeText = $this->createTextNode('URL');
			
			$cellNode->appendChild($cellNodeText);
			
			$headerTr->appendChild($cellNode);
			
			foreach($fields as $key => $value) {
				$add = true;
				$name = '';
				switch($key){
					case 'productNumber':
					case 'color':
					case 'size':
						$add = false;
					break;
					case 'productId':
						$name = 'ID';
					break;
					case 'title':
						$name = 'Title';
					break;
					case 'price':
						$name = 'Price';
					break;
					case 'mfca':
						$name = 'M/F/C/A';
					break;
					case 'images':
						$name = 'Images';
					break;
					case 'thumb':
						$name = 'Thumb';
					break;
					case 'sale':
						$name = 'Sale';
					break;
					case 'brand':
						$name = 'Brand';
					break;
					case 'shortDescription':
						$name = 'Short Description';
					break;
					case 'longDescription':
						$name = 'Long Description';
					break;
					case 'category':
						$name = 'Category';
					break;
					case 'dt':
					case 'id':
					case 'domain':
					case 'blnvalid':
					case 'visible':
					case 'pageDescription':
					case 'pageKeywords':
						$add = false;
					break;
					default:
						$name = $key;
					break;
				}
				if($add==true){
					$cellNode = $this->createNode('td');
					$cellNode->setClass('header');
					$cellNodeText = $this->createTextNode($name);
					$cellNode->appendChild($cellNodeText);
					$headerTr->appendChild($cellNode);
				}
			}
			$cellNode = $this->createNode('td');
			$cellNode->setClass('header');
				
			$cellNodeText = $this->createTextNode('Options');
				
			$cellNode->appendChild($cellNodeText);
			$headerTr->appendChild($cellNode);
			$headerNode->appendChild($headerTr);
			return $headerNode;
		}
		function createOptionsTable($options){
			$this->optionsTable = new TableNode($this->getDOMDocument());
			foreach($options as $key => $value) {
					switch($key) {
					case 'color': //case 'Color':
						$this->optionsTable->addColumnHeader('Color');
					break;
					case 'productNumber': //case 'Item Number':
						$this->optionsTable->addColumnHeader('Item Number');
					break;
					case 'size': //case 'Size':
						$this->optionsTable->addColumnHeader('Size');
					break;
					default:
						$this->optionsTable->addColumnHeader($key);
					break;
					}
			}
			$this->addOption($options);
			
		}
		function addOption($options){
			$this->optionsTable->addRow();
			foreach($options as $key => $value) {
				$this->optionsTable->addColumnData($value);
			}
		}
		function buildInventoryBody($records,$bodyNode,$getSupplemental=false) {
			$results = $this->filterRecords($records);
			if($getSupplemental)
				$this->buildSupplementalRecords($results);
			$this->tLog->debug('record count: '.count($results));
			$curid = -1;
			$previd=-2;
			foreach($results as $key => $value) {
				try {
					$tempCn = $this->createNode('tr');
					$tempCn->setClass('inventoryRow');
					$curid = $this->recordToTableCells($value,$tempCn,$curid);
					if($previd!=$curid){
						$bodyNode->appendChild($tempCn);
						$previd=$curid;
					}
				}
				catch (Exception $e) {
					$msg = 'Adding records failed because of an Error('.$e->getMessage().')';
					$this->tLog->error($msg);
					throw new Exception($msg);
				}
			}
			return count($results);
		}
		function filterRecords($records) {
			if (count($this->filterArray)==0) {
				return $records;
			}
			$results = array();
			foreach($this->filterArray as $key => $filter) {
				$filteredRecords = $filter->getFilterSet($records);
				$results = array_merge($results,$filteredRecords);
			}
            foreach ($results as $key => $recordArray) {
                $this->processRecord($recordArray);
            }
			return $results;
		}
		/**
		 * This gets Selected Vehicles that are associated with a single VIN
		 * Note: If the filter has more than one matching result, this will not work
		 * @return
		 * @param records	Array	An array of the filtered records;
		 * 							There should only be one record 
		 */
		function buildSupplementalRecords($records) {
			if (count($records) > 0) {
				
				$this->supplementalInventory = new Store($this->getDOMDocument());
				$this->supplementalInventory->setClass(self::SUPPLEMENTAL_CLASS);
				
				$record = $records[0];
				$this->tLog->debug("Building Supplemental Store inventory with Brand(".$record['brand'].")");
				$this->supplementalInventory->addFilter(new Filter('brand',$record['brand'],5,true));
				$this->supplementalInventory->buildInventory($this->data);
				//return $this->supplementalInventory;
			}
			else {
				$msg = "Cannot get Supplemental Records for more then one record.";
				$this->tLog->warn($msg);
			}
		}
		
		function getSupplementalRecords() {
			return $this->supplementalInventory;
		}
		function getUrlFromRecord($record) {
            $brand = ($record['brand'] == 'Lamborghini') ? 'lambo' : $record['brand'];
			return URL_SEPARATOR.'boutique'.URL_SEPARATOR.str_replace(' ','_',strtolower($brand)).URL_SEPARATOR.$record['productId'];
		}
		function recordToTableCells($record,&$rowNode,$curid) {
			//Link Cell
			$optionsArray = array();
			if($curid!=$record['productId']){ //$record['ID']){
				
				$tempCn = $this->createNode('td');
				$innerNode = $this->createNode('a');
				$innerNode->setClass('url');
				$itemUrl = $this->getUrlFromRecord($record);
				$innerNode->setAttribute('href',$itemUrl);
			 
				$innerNodeText = $this->createTextNode($itemUrl);
			
				$innerNode->appendChild($innerNodeText);
				$tempCn->appendChild($innerNode);
			
				$rowNode->appendChild($tempCn);
			
				//ID Index
			
				foreach($record as $key => $value) {
					$tempCn = $this->createNode('td');
					$tempCn->setClass($key);
					$add = true;
					switch($key) {
						case 'dt':
						case 'id':
						case 'domain':
						case 'blnvalid':
						case 'visible':
						case 'pageDescription':
						case 'pageKeywords':
							$add = false;
						break;
						case 'thumb': //case 'Thumb':
							$innerNode = $this->createNode('img');
							$innerNode->setClass('photo');
							$innerNode->setAttribute('src',$value);
							$tempCn->appendChild($innerNode);
							break;
						case 'images': //case 'Images':
							$photosArray = explode(',',$value);
							foreach ($photosArray as $aKey => $aValue) {
								$innerNode = $this->createNode('img');
								$innerNode->setAttribute('src',$aValue);
								
								$tempCn->appendChild($innerNode);
							}
							break;
						case 'color': //case 'Color':
						case 'productNumber': //case 'Item Number':
						case 'size': //case 'Size':
							$add = false;
							$optionsArray[$key]=$value;
						break;
						default:
							$innerNodeText = $this->createTextNode($value);
							$tempCn->appendChild($innerNodeText);
					}
					if($add) //if($key!='Color'&&$key!='Item Number'&&$key!='Size')
						$rowNode->appendChild($tempCn);
				}
				$this->createOptionsTable($optionsArray);
				$tempCn = $this->createNode('td');
				$tempCn->setClass('Options');
				$tempCn->appendChild($this->optionsTable);
				$rowNode->appendChild($tempCn);
			} else {
				foreach($record as $key => $value) {
					switch($key) {
					case 'color': //case 'Color':
					case 'productNumber': //case 'Item Number':
					case 'size': //case 'Size':
						$optionsArray[$key]=$value;
					break;
					default:
					break;
					}
				}
				$this->addOption($optionsArray);
			}
			return $record['productId']; //$record['ID'];
		}
		function urlTemplates() {
			$div = $this->createNode('div');
			$div->setClass('url_templates');
			
			
			$ul = $this->createNode('ul');
			$ul->setClass('template_list');
			
			$this->addUrlTemplate($ul,'sale_logo','','http://'.CONTENT.'/images/sale.png');
			
			$div->appendChild($ul);
			
			$this->urlTemplatesNode = $div;
		}
		
		function addUrlTemplate(&$ulCn,$liClass,$url,$logo) {
			$li = $this->createNode('li');
			$li->setClass($liClass);
			
			$a = $this->createNode('a');
			$a->setClass('link');
			$a->setAttribute('href',$url);
			
			$img = $this->createNode('img');
			$img->setClass('image');
			$img->setAttribute('src',$logo);
			
			$a->appendChild($img);
			
			$li->appendChild($a);
			
			$ulCn->appendChild($li);
		}
		
		function getUrlTemplates() {
			return $this->urlTemplatesNode;
		}
    }
?>