<?php
	require_once 'includes/config/globals.php';
	require_once 'includes/models/page/content_node.php';
	require_once 'includes/models/filter.php';
    class Inventory extends ContentNode {
    	const DEFAULT_CLASS='inventory';
		const SUPPLEMENTAL_CLASS='supplemental';

        const IDENTIFIER='inventory_';

        static $idCount = 0;
    	/**
    	 * Associative array to apply any filtering on Inventory with
    	 * $key's correspond to Fields to filter by
    	 * $value's correspond to values to check against
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
		 * This is only used when filtered by VIN
		 */
		private $supplementalInventory;

        private $referenceArray;
		
		function __construct(&$doc) {
			parent::__construct('table',$doc);
            $this->tLog->debug("CREATING INVENTORY WITH COUNT ".self::$idCount);
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
		function buildInventory($data) {
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
				$count = $this->buildInventoryBody($records,$bodyNode);
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
			$lines = explode("\n",$data);
			$fields = null;
			$recordsets = array();
			//Go line by line, exploding by tab
			foreach ($lines as $key => $value) {
				if (is_null($fields)) {
					$fields = explode("\t",$value);
					continue;
				}
				else {
					$values = explode("\t",$value);
					if (count($fields) == count($values))
						$recordsets[$key] = $this->processRecord($fields,$values);
				}
			}
			return $recordsets;
		}
		function processRecord($fieldArray,$valueArray) {
			$recordArray = array();
			foreach($fieldArray as $key => $value) {
				//$this->tLog->debug("$key : " . $valueArray[$key]);
				if (!isset($valueArray[$key])) {
					$msg = "Value array does not have a value for key($key). Value Array DUMP:\n";
					foreach($valueArray as $aKey => $aValue)
						$msg.= "$aKey : $aValue\n";
					$this->tLog->error($msg);
					throw new Exception($msg);
				}
				$recordArray[$value] = $valueArray[$key];
			}
            return $this->addUrlFieldsToRecord($recordArray);
		}
        /**
         * Special method that puts in record fields to match the URI against
         */
        function addUrlFieldsToRecord($recordArray) {
            $recordArray['uri_make'] = str_replace(' ','_',strtolower($recordArray['Make']));
            $recordArray['uri_model'] = str_replace(' ','_',strtolower($recordArray['Model']));
            $recordArray['uri_vin'] = $recordArray['VIN'];
            if (!isset($this->referenceArray['year'])) {
                $this->referenceArray['year'] = $recordArray['Year'];
            }
            if (!isset($this->referenceArray[$recordArray['uri_model']])) {
                $this->referenceArray[$recordArray['uri_model']] = $recordArray['Model'];
                $this->tLog->debug("REFERENCE: ".$this->referenceArray[$recordArray['uri_model']].' <=> '.$recordArray['uri_model']);
            }
            if (!isset($this->referenceArray[$recordArray['uri_vin']])) {
                $this->referenceArray[$recordArray['uri_vin']] = $recordArray['VIN'];
            }
            return $recordArray;
        }

        function getProperName($uriVersion) {
            return (isset($this->referenceArray[$uriVersion])) ? $this->referenceArray[$uriVersion] : $uriVersion;
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
				
				$cellNode = $this->createNode('td');
				$cellNode->setClass('header');
				
				$cellNodeText = $this->createTextNode($key);
				
				$cellNode->appendChild($cellNodeText);
				$headerTr->appendChild($cellNode);
			}
			
			$headerNode->appendChild($headerTr);
			return $headerNode;
		}
		
		function buildInventoryBody($records,$bodyNode) {
			$results = $this->filterRecords($records);
            if (count($results) == 0) {
                $this->tLog->info("There are no records for this inventory.");
            }
			$this->buildSupplementalRecords($results);
			$this->tLog->debug('record count: '.count($results));
			$vinIndex = array();
			foreach($results as $key => $value) {
				try {
					$tempCn = $this->createNode('tr');
					$tempCn->setClass('inventoryRow');
					$this->recordToTableCells($value,$tempCn);
					//$vinIndex[$key['VIN']] = $this->getUrlFromRecord($value);
					$bodyNode->appendChild($tempCn);
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
            if (count($records) == 1 && !$this->isSupplemental()) {
				
				$this->supplementalInventory = new Inventory($this->getDOMDocument());
				$this->supplementalInventory->setClass(self::SUPPLEMENTAL_CLASS);

				
				$record = $records[0];
				$this->tLog->debug("Building Supplemental Inventory with Make(".$record['Make'].")");
				$this->supplementalInventory->addFilter(new Filter('Make',$record['Make'],5,true));
				$this->supplementalInventory->buildInventory($this->data);
				//return $this->supplementalInventory;
			}
			else {
				//$msg = "Cannot get Supplemental Records for more than one record.";
				//$this->tLog->warn($msg);
			}
		}
		function isSupplemental() {
            return $this->getAttribute('class') == self::SUPPLEMENTAL_CLASS;
        }
		function getSupplementalRecords() {
            if (is_null($this->supplementalInventory)) {
                $this->tLog->info("There are no supplemental records for this Inventory.");
            }
			return $this->supplementalInventory;
		}
		function getUrlFromRecord($record) {
			return URL_SEPARATOR.'inventory'.URL_SEPARATOR.str_replace(' ','_',strtolower($record['Make'])).URL_SEPARATOR.str_replace(' ','_',strtolower($record['Model'])).URL_SEPARATOR.$record['VIN'];
		}
		function recordToTableCells($record,&$rowNode) {
			//Link Cell
			$tempCn = $this->createNode('td');
			$tempCn->setClass('vehicleUrl');
			
			$innerNode = $this->createNode('a');
			$innerNode->setClass('url');
			$vehicleUrl = $this->getUrlFromRecord($record);
			$innerNode->setAttribute('href',$vehicleUrl);
			
			$innerNodeText = $this->createTextNode($vehicleUrl);
			
			$innerNode->appendChild($innerNodeText);
			$tempCn->appendChild($innerNode);
			
			$rowNode->appendChild($tempCn);
			
			//VIN Index
			
			foreach($record as $key => $value) {
				$tempCn = $this->createNode('td');
				$tempCn->setClass($key);
				switch($key) {
					case 'PhotoURL':
						$innerNode = $this->createNode('img');
						$innerNode->setClass('photo');
						$innerNode->setAttribute('src',$value);
						$tempCn->appendChild($innerNode);
						break;
					case 'EmailLeadsTo':
						$innerNode = $this->createNode('a');
						$innerNode->setClass('emailLink');
						$innerNode->setAttribute('href',"mailto:$value");
						$innerNodeText = $this->createTextNode($value);
						
						$innerNode->appendChild($innerNodeText);
						$tempCn->appendChild($innerNode);
						break;
					case 'MultiplePhotos':
						$photosArray = explode(',',$value);
						foreach ($photosArray as $aKey => $aValue) {
							$innerNode = $this->createNode('img');
							$innerNode->setAttribute('src',$aValue);
							
							$tempCn->appendChild($innerNode);
						}
						break;
					default:
						$innerNodeText = $this->createTextNode($value);
						
						$tempCn->appendChild($innerNodeText);
				}
				
				$rowNode->appendChild($tempCn);
			}
		}
		function urlTemplates() {
			$div = $this->createNode('div');
			$div->setClass('url_templates');
			
			
			$ul = $this->createNode('ul');
			$ul->setClass('template_list');
			
			$this->addUrlTemplate($ul,'carfax','http://www.carfax.com/cfm/ccc_DisplayHistoryRpt.cfm?partner=DFS_Y&vin=[VIN]','http://'.CONTENT.'/temp/images/bmcd_carfax_logo.png');
			$this->addUrlTemplate($ul,'certified_logo','http://www.dealerfusion.com/CPO_display.php?make=[Make]','http://www.dealerfusion.com/graphics/certified_logos/[Make].gif');
			
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