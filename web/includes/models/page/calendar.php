<?php
	require_once 'includes/config/globals.php';
	require_once 'includes/models/page/content_node.php';
	require_once 'includes/models/filter.php';
    class Calendar extends ContentNode {
    	const DEFAULT_CLASS='calendar';
		const SUPPLEMENTAL_CLASS='supplemental';

        const IDENTIFIER = 'calendar_';
        static $idCount = 0;
        protected $filteredRecords;
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

        private $referenceArray;
		function __construct(&$doc) {
			parent::__construct('table',$doc);

            $this->tLog->debug("CREATING CALENDAR WITH COUNT ".self::$idCount);
            $this->setAttribute('id', self::IDENTIFIER.self::$idCount++);
            
			$this->filterArray = array();
			$this->setClass(self::DEFAULT_CLASS);

            $this->referenceArray = array();
		}
		/**
		 * Function to add filters to the calendar
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
        function getFilteredRecords() {
            return $this->filteredRecords;
        }
		function buildCalendar($data,$getSupplemental=false) {
			//Store the original data
			$this->data = $data;
			try {
				$records = $this->processCalendarData($data);
			}
			catch (Exception $e) {
				$msg = "Failed to process calendar data[[$data]]".$e->toString();
				throw new Exception($msg);
			}
			//Build Table Header
			$firstRecord = array_shift($records);
			$this->appendChild($this->createCalendarHeader($firstRecord));
			//$this->appendChild($this->buildCalendarHeader($firstRecord));                
			array_unshift($records,$firstRecord);
			
			//Build Table Body
			$bodyNode = $this->createNode('tbody');
			//$bodyNode = new ContentNode('tbody',$this->doc);
			try {
				$count = $this->buildCalendarBody($records,$bodyNode,$getSupplemental);
			}
			catch (Exception $e) {
				$msg = "Building calendar records failed at key($key). ".$e->toString();
				throw new Exception($msg);
			}
			$this->appendChild($bodyNode);
			$this->urlTemplates();
			return $count;
		}		
		/**
		 * Process Calendar Data
		 * The data is expected to be a tab-delimited
		 * file containing vehicle information
		 * @return 
		 * @param $data Object
		 */
		function processCalendarData($data) {
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
            foreach($data as $key => $record) {
                $this->processRecord($record);
            }
			return $data; //$recordsets;
		}
		function processRecord($recordArray) {
			$this->addUrlFieldsToRecord($recordArray);
			return $recordArray;
		}
        /**
         * Special method that puts in record fields to match the URI against
         */
        function addUrlFieldsToRecord($recordArray) {
            if (!isset($this->referenceArray['city'])) {
                $this->referenceArray['city'] = $recordArray['city'];
            }
            if (!isset($this->referenceArray['state'])) {
                $this->referenceArray['state'] = $recordArray['state'];
            }
            if (!isset($this->referenceArray['title'])) {
                $this->referenceArray['title'] = $recordArray['title'];
            }
            return $recordArray;
        }
        //Todo: Refactor for this class
        function getProperName($uriVersion) {
            $properName = (isset($this->referenceArray[$uriVersion])) ? $this->referenceArray[$uriVersion] : $uriVersion;
            return $properName;
        }
		function createCalendarHeader($fields) {
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
					case 'id':
						$name = 'ID';
					break;
					case 'title':
						$name = 'Title';
					break;
					case 'blurb':
						$name = 'Blurb';
					break;
					case 'description':
						$name = 'Description';
					break;
					case 'startTime':
						$name = 'Start Time';
					break;
					case 'endTime':
						$name = 'End Time';
					break;
					case 'date':
						$name = 'Date';
					break;
					case 'map':
						$name = 'Map';
					break;
					case 'locationName':
						$name = 'Location Name';
					break;
					case 'street':
						$name = 'Street';
					break;
					case 'city':
						$name = 'City';
					break;
					case 'state':
						$name = 'State';
					break;
					case 'zip':
						$name = 'ZIP';
					break;
					case 'thumb':
						$name = 'Thumb';
					break;
					case 'images':
						$name = 'Images';
					break;
					case 'dt':
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
				if($add){
					$cellNode = $this->createNode('td');
					$cellNode->setClass('header');
					$cellNodeText = $this->createTextNode($name);
					$cellNode->appendChild($cellNodeText);
					$headerTr->appendChild($cellNode);
				}
			}
			//$cellNode = $this->createNode('td');
			//$cellNode->setClass('header');
				
			//$cellNodeText = $this->createTextNode('Options');
				
			//$cellNode->appendChild($cellNodeText);
			//$headerTr->appendChild($cellNode);
			$headerNode->appendChild($headerTr);
			return $headerNode;
		}
		function buildCalendarBody($records,$bodyNode) {
			$results = $this->filterRecords($records);
            $this->filteredRecords = $results;
			$this->tLog->debug('record count: '.count($results));
			foreach($results as $key => $value) {
				
				try {
					$tempCn = $this->createNode('tr');
					$tempCn->setClass('calendarRow');
					$this->recordToTableCells($value,$tempCn);
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
		
		function getUrlFromRecord($record) {
			$d = split('/',$record['date']);
			return URL_SEPARATOR.'events'.URL_SEPARATOR.$d[2].URL_SEPARATOR.$d[0].URL_SEPARATOR.$d[1].URL_SEPARATOR.$record['id'];
		}
		function recordToTableCells($record,&$rowNode) {
			//Link Cell
			$optionsArray = array();
			$tempCn = $this->createNode('td');
			$innerNode = $this->createNode('a');
			$tempCn->setClass('url');
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
					case 'domain':
					case 'blnvalid':
					case 'visible':
					case 'pageDescription':
					case 'pageKeywords':
						$add = false;
					break;
					case 'thumb':
                        $src = $value;
						$innerNode = $this->createNode('img');
						$innerNode->setClass('photo');
						$innerNode->setAttribute('src',$src);
						$tempCn->appendChild($innerNode);
						break;
					case 'images':
						$photosArray = explode(',',$value);
						foreach ($photosArray as $aKey => $aValue) {
                            $src = $aValue;
							$innerNode = $this->createNode('img');
							$innerNode->setAttribute('src',$aValue);
							$tempCn->appendChild($innerNode);
						}
						break;
					case 'map':
						$innerNode = $this->createNode('div');
						$innerNode->setClass('googlemap');
						$img = $this->createNode('img');
						$a = $this->createNode('a');
						$a->setAttribute('href',$value);
						$img->setAttribute('src','http://maps.google.com/intl/en_us/images/maps_logo_small_blue.png');
						$a->appendChild($img);
						$innerNode->appendChild($a);
						$tempCn->appendChild($innerNode);
						break;
					default:
						$innerNodeText = $this->createTextNode($value);
						$tempCn->appendChild($innerNodeText);
				}
				if($add)
					$rowNode->appendChild($tempCn);
			}
			return $record['id'];
		}
		function urlTemplates() {
			$div = $this->createNode('div');
			$div->setClass('url_templates');
			
			
			$ul = $this->createNode('ul');
			$ul->setClass('template_list');
			
			$this->addUrlTemplate($ul,'map_logo','','http://maps.google.com/intl/en_us/images/maps_logo_small_blue.png');
			$this->addUrlTemplate($ul,'events_url','/events','');
			
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