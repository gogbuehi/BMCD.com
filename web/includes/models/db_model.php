<?php
	require_once 'includes/config/globals.php';
	class DBModel {
		const AUTO_INCREMENT=1;
		const DATETIME=2;
		const BOOLEAN=3;
		const VARCHAR=4;
		const INT=5;
		const NUMBER=6;
		const TEXT=7;
		
		public $id;
		public $dt;
		public $blnvalid;
		protected $tLog;
		function __construct() {
			global $tLog;
			$this->tLog = &$tLog;
			$this->id = -1;
			$this->dt = $_SERVER['REQUEST_TIME'];
			$this->blnvalid = TRUE;
		}
		
		function loadData($dataArray) {
			$fields = $this->getFields();
			foreach($fields as $key => &$value) {
				if(isset($dataArray[$key])) {
                    $value = $this->revertValue($key, $dataArray[$key]);
				}
			}
		}
		
		function setData($field,$value) {
			switch($field) {
				//No special data cases
				default:
					//Do nothing
			}
			$this->loadData(array($field=>$value));
		}
		
		function getFields() {
			return array(
				'id' => &$this->id,
				'dt' => &$this->dt,
				'blnvalid' => &$this->blnvalid
			);
		}
		
		function tableFieldType($fieldName) {
			switch($fieldName) {
				case 'id':
					return self::AUTO_INCREMENT;
				case 'dt':
					return self::DATETIME;
				case 'blnvalid':
					return self::BOOLEAN;
				default:
					return self::VARCHAR;
			}
			
		}
		
		function toString() {
			$toString = '';
			$dataArray = $this->getFields();
			foreach($dataArray as $key => $value) {
				$toString .= "$key: $value<br />\n";
			}
			return $toString;
		}
		static function ts($objectModel) {
			$toString = '';
			$dataArray = $objectModel->getFields();
			foreach($dataArray as $key => $value) {
				$toString .= "$key: $value<br />\n";
			}
			return $toString;
		}
		
		function ev($code) {
			return eval($code);
		}
		function getConstant($varName) {
			return eval('return '.get_class($this).'::'.$varName.';');
		}

        function revertValue($key,$value) {
            switch($key) {
                case 'blnvalid':
                    if ($value == 0 || $value === false) {
                        return false;
                    }
                    else {
                        return true;
                    }
                    break;
                case 'dt':
                    return $this->convertMysqlDateToTimestamp($value);
                    break;
                default:
                    return $value;
            }
        }

        function convertMysqlDateToTimestamp($dt) {
            if (is_null($dt) || $dt == '') {
                $this->tLog->info('There is no date to convert to a timestamp.');
                return $dt;
            }
			$this->tLog->info('Converting MySQL date('.$dt.') to a timestamp');
			$year = (int) substr($dt,0,4);
			$month = (int) substr($dt,5,2);
			$day = (int) substr($dt,8,2);
			$hour = (int) substr($dt,11,2);
			$minute = (int) substr($dt,13,2);
			$second = (int) substr($dt,15,2);
			/*
			$this->tLog->debug("Year: $year");
			$this->tLog->debug("Month: $month");
			$this->tLog->debug("Day: $day");
			$this->tLog->debug("Hour: $hour");
			$this->tLog->debug("Minute: $minute");
			$this->tLog->debug("Second: $second");
			*/
			return mktime($hour,$minute,$second,$month,$day,$year);
		}
	}
?>