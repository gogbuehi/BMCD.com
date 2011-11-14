<?php
    class Log {
    	//Log levels
		const DEBUG=1;
		const INFO=2;
		const WARN=3;
		const ERROR=4;
		const FATAL=5;
        const NOTICE=6;
		
		//Log handler levels
		//This determines whether this will write to a file or somewhere else
		const LOG_TO_FILE=3;
		const LOG_ELSEWHERE=0;
		
		//Log file
		protected $log;
		protected $buffer;
		
		protected $logLevel;
		protected $logFilename;
		
    	function __construct($buffer=FALSE) {
    		$this->log = array();
			$this->logFilename = LOG_DIRECTORY.DIRECTORY_SEPARATOR.date("Ymd",time()).'_'.LOG_BASE_FILENAME;
			$this->buffer = $buffer;
			
			$this->logLevel = self::LOG_TO_FILE;
			
			if (!file_exists($this->logFilename)) {
				$thisFile = fopen($this->logFilename,'w') or FALSE;
				if ($thisFile !== FALSE) {
					fclose($thisFile);
				}
				else {
					$this->logLevel = self::LOG_ELSEWHERE;
				}
			}
    	}
		function addLog($level,$message) {
			if (LOG_LEVEL <= $level) {
				$this->log[] = new Event($level,$message);
				if (!$this->buffer) {
					$this->printAll();
				}
			} 
		}
		function debug($message) {
			$this->addLog(self::DEBUG,$message);
		}
		function info($message) {
			$this->addLog(self::INFO,$message);
		}
		function warn($message) {
			$this->addLog(self::WARN,$message);
		}
		function error($message) {
			$this->addLog(self::ERROR,$message);
		}
		function fatal($message) {
			$this->addLog(self::FATAL,$message);
		}
        function notice($message) {
            $this->addLog(self::NOTICE,$message);
        }
		function printAll() {
			foreach($this->log as $key => $value) {
				($this->logLevel == self::LOG_TO_FILE) ?
					error_log($value->toString()."\n",self::LOG_TO_FILE,$this->logFilename):
					error_log($value->toString());
				unset($this->log[$key]);
			}
		}
    }
	class Event {
		protected $dt;
		protected $level;
		protected $message;
		
		function __construct($level,$message) {
			$this->dt = date("Y-m-d G:i:s",time());
			$this->level = $level;
			$this->message = $message;
		}
		
		function toString() {
			return $this->dt.' '.
			$this->levelString().' '.
			$this->message;
		}
		
		function levelString() {
			switch($this->level) {
				case Log::DEBUG:
					return '[DEBUG]';
				case Log::INFO:
					return '[INFO]';
				case Log::WARN:
					return '[WARN]';
				case Log::ERROR:
					return '[ERROR]';
				case Log::FATAL:
					return '[FATAL]';
                case Log::NOTICE:
                    return '[NOTICE]';
				default:
					return '[INVALID]';
			}
		}
	}
?>