<?php
	require_once 'includes/config/globals.php';
    class Filter {
    	protected $column;
		protected $values;
		protected $limit;
		protected $random;
		protected $not;
		
		protected $andFilters;

        protected $isNot;
		
		protected $tLog;
		
		public function __construct($column,$value,$limit=false,$random=false,$not=false) {
			global $tLog;
			$this->tLog = &$tLog;
			
			$this->column = $column;
			$this->values = array();
			$this->addValue($value);
			$this->limit = $limit;
			$this->random = $random;
			$this->not = $not;
			$this->andFilters = array();

            $this->isNot = false;
		}
		
		public function addValue($value) {
			array_push($this->values,$value);
		}
		public function andFilter($column,$value,$limit=false,$random=false,$not=false) {
			array_push($this->andFilters,new Filter($column,$value,$limit,$random,$not));
		}
        public function setNot($is=true) {
            $this->isNot=$is;
        }
		
		public function passesFilter($record,$ignoreLimit=false) {
			//$this->tLog->debug('Testing filter('.$this->toString().')...');
			if ($ignoreLimit || $this->limit === FALSE || $this->limit > 0) {
				//$this->tLog->debug('Passed LIMIT test');
				$value = $record[$this->column];
				
				foreach($this->values as $aKey => $aValue) {
					if (($this->not===TRUE && $value != $aValue) || ($this->not===FALSE && $value == $aValue) || is_null($aValue)) {
						$this->limit--;
						$this->tLog->debug('Passed test');
						return (true && $this->passesAndFilters($record));
					}
					else {
						$this->tLog->debug("Match Failure: COLUMN: {$this->column} - VALUE: $value - AVALUE: $aValue");
					}
				}
			}
			//$this->tLog->debug('Failed test');
			return false;
		}
		
		function passesAndFilters($record) {
			foreach ($this->andFilters as $key => $value) {
				if (!$value->passesFilter($record))
					return false;
			}
			return true;
		}
		
		
		
		public function getFilterSet($records) {
			$results = array();
			if ($this->random) {
				shuffle($records);
			}
			foreach ($records as $key => $record) {
				if ($this->passesFilter($record)) {
					array_push($results,$record);
				}
				if ($this->limit !== false && $this->limit == 0)
					break;
			}
			//$this->tLog->debug('getFilterSet result count: '.count($results));
			return $results;
		}
		
		public function toString() {
			return 'Column: '.$this->column."\n".
			'Values: '.($this->isNot ? '[NOT] ' : '').implode(',',$this->values)."\n".
			'Limit: '.(($this->limit===false) ? 'FALSE' : $this->limit)."\n".
			'Random: '.(($this->random === false) ? 'FALSE' : $this->random);
		}
    }
?>