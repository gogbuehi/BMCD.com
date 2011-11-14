<?php
	require_once 'includes/models/page/content_node.php';
	require_once 'includes/models/filter.php';
    class DataManager extends ContentNode {
    	const DEFAULT_CLASS='data';
		const HEADER_CLASS='header';
		const BODY_ROW_CLASS='row';
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
		protected $data;
		protected $records;
		
		function __construct(&$doc,$tag='table') {
			parent::__construct($tag,$doc);
			$this->filterArray = array();
			$this->setClass($this->getConstant('DEFAULT_CLASS'));
		}
		
		/**
		 * Function to add filters to the inventory
		 * Uses delimeter to add multiple values for a single field
		 * Multiple values are treated as "OR" values
		 * @return void
		 * @param $field String		The column to filter by
		 * @param $value String		The value being sought
		 */
		function addFilter(Filter $filter) {
			array_push($this->filterArray,$filter);
			$this->tLog->debug('Filter added...'.$filter->toString());
		}
		function clearFilters() {
			$this->filterArray = array();
		}
		function buildData($data) {
			//Store the original data
			$this->data = data;
			try {
				$records = $this->processData($data);
			}
			catch (Exception $e) {
				$msg = "Failed to process data [[$data]].\n\t".$e->getMessage();
				$this->tLog->error($msg);
				throw new Exception($msg);
			}
			//Build Table Header
			$firstRecord = array_shift($records);
			$this->appendChild($this->createHeader($firstRecord));
			array_unshift($records,$firstRecord);
			
			//Build Table Body
			$bodyNode = $this->createNode('tbody');
			try {
				$this->buildBody($records,$bodyNode);
			}
			catch (Exception $e) {
				$msg = "Building inventory records failed at key($key). ".$e->getMessage();
				throw new Exception($msg);
			}
			$this->appendChild($bodyNode);
		}
		/**
		 * Process Data
		 * The data is expected to be a tab-delimited
		 * columns, with newline delimited rows
		 * @return 
		 * @param $data Object
		 */
		function processData($data) {
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
					if (count($fields) >= count($values))
						$recordsets[$key] = $this->processRecord($fields,$values);
				}
			}
			$this->records = $recordsets;
			return $recordsets;
		}
		function processRecord($fieldArray,$valueArray) {
			$recordArray = array();
            $reportString = 'Report: ';
			foreach($fieldArray as $key => $value) {
                $key = trim($key);
                $value = trim($value);
                //$reportString .= "[".($value)."],";
				if (!isset($valueArray[$key])) {
					//$msg = "Value array does not have a value for key($key). Value Array DUMP:\n";
					//foreach($valueArray as $aKey => $aValue)
					//	$msg.= "$aKey : $aValue\n";
					//$this->tLog->info($msg);
					//throw new Exception($msg);
					$valueArray[$key] = '';
				}
				$recordArray[$value] = trim($valueArray[$key]);
                //if ($value == 'manufacture')
                    //$this->tLog->debug("PROCESSED RECORD($key): $value - ".$valueArray[$key]);
			}

                //$this->tLog->debug($reportString);
			return $recordArray;
		}
		function createHeader($fields,$additionalFields=null) {
			$headerNode = $this->createNode('thead');
			$headerTr = $this->createNode('tr');
			$this->appendChild($headerNode);
			
			foreach($fields as $key => $value) {
				
				$cellNode = $this->createNode('td');
				$cellNode->setClass($this->getConstant('HEADER_CLASS'));
				
				$cellNodeText = $this->createTextNode($key);
				
				$cellNode->appendChild($cellNodeText);
				$headerTr->appendChild($cellNode);
			}
			
			$headerNode->appendChild($headerTr);
			return $headerNode;
		}
		function buildBody($records,$bodyNode) {
			$results = $this->filterRecords($records);
			
			foreach($results as $key => $value) {
				try {
					$tr = $this->createNode('tr');
					$tr->setClass($this->getConstant('BODY_ROW_CLASS'));
					$this->recordToTableCells($value,$tr);
					$bodyNode->appendChild($tr);
				}
				catch (Exception $e) {
					$msg = 'Adding records failed because of an Error('.$e->toString().')';
					$this->tLog->error($msg);
					throw new Exception($msg);
				}
			}
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
            //$this->tLog->debug('Of the '.count($records).' records provided, '.count($results).' are available after filtering.');
            if (count($results)==0) {
                //
                //$this->tLog->debug(self::recrodsToString($records));
            }
			$this->records = $results;

			return $results;
		}
		/**
		 * Converts a record array into "<td>" nodes with the content inside it
		 * Note: This class will generally need to be overriden, so each data set may
		 * require certain fields have special formatting applied.
		 * @return 			void
		 * @param $record 	Array			An array containing the the fields 
		 * 									and values of a data record
		 * @param $rowNode 	ContentNode		The "<tr>" node to contain the record
		 * 									cells ("<td"> nodes).
		 */
		function recordToTableCells($record,&$rowNode) {
			foreach($record as $key => $value) {
				$td = $this->createNode('td');
				$td->setClass($key);
				$td->addText($value);
			}
			$rowNode->appendChild($td);
		}
		function getRecords() {
			return $this->records;
		}

        static function recordToString($record) {
            $recordString = 'Record fields('.count($record).") {\n";
            $delimiter = '';
            foreach ($record as $key => $value) {
                $recordString .= "$delimiter\t[$key]:".substr($value, 0, 25);
                $delimiter = "\n";
            }
            return $recordString."\n}";
        }
        static function recrodsToString($records) {
            $recordsString = "RecordSet:\n";
            $delimiter = '';
            foreach ($records as $key => $value) {
                $recordsString .= $delimiter.self::recordToString($value);
                $delimiter = "\n";
            }
            return $recordsString;
        }
    }
?>