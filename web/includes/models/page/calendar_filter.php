<?php
	require_once 'includes/config/globals.php';
	require_once 'includes/models/filter.php';
    class CalendarFilter extends Filter {
		protected $range;
		public function __construct($column,$year,$month,$range,$limit=false,$random=false,$not=false) {
			parent::__construct($column,$month.'/01/'.$year,$limit,$random,$not);
			$this->range = $range;
		}
		public function passesFilter($record,$ignoreLimit=false) {
			//$this->tLog->debug('Testing filter('.$this->toString().')...');
			if ($ignoreLimit || $this->limit === false || $this->limit > 0) {
				//$this->tLog->debug('Passed LIMIT test');
				$value = $record[$this->column];
				$dateArray = explode('/',$value);
				$value = $dateArray[2].$this->zeropad($dateArray[0],2);
				foreach($this->values as $aKey => $aValue) {
					$aDateArray = explode('/',$aValue);
					$lowMonth = $aDateArray[0]-floor($this->range/2);
					$highMonth = $aDateArray[0]+floor($this->range/2);
					$min = ($lowMonth<1) ? ($aDateArray[2]-1).($this->zeropad(12+$lowMonth,2)) : $aDateArray[2].($this->zeropad($lowMonth,2)) ;
					$max = ($highMonth>12) ? ($aDateArray[2]+1).($this->zeropad($highMonth-12,2)) : $aDateArray[2].($this->zeropad($highMonth,2)) ;
					if (($this->not===true && ($value < $min || $value > $max)) || ($this->not===false && ($value >= $min && $value <= $max)) || is_null($aValue)) {
						$this->limit--;
						return ($this->isNot !== (true && $this->passesAndFilters($record)));
					}
					else {
						//$this->tLog->debug("VALUE: $value - AVALUE: $aValue");
					}
				}
			}
			//$this->tLog->debug('Failed test');
			return ($this->isNot !== false);
		}
		protected function zeropad($number, $limit) {
		  return (strlen($number) >= $limit) ? $number : $this->zeropad("0" . $number, $limit);
		}

    }
?>