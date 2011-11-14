<?php
	require_once 'includes/config/globals.php';
	/*
	 * WARNING: Serveral "Services" classes rely on this base class.
	 * DO NOT alter the functionality in here, unless you intend to
	 * ensure that it does not cause issues for all child classes.
	 */
    class SqlServices {
		
		protected static $sLink;
		protected $link;
		
		protected $tLog;
		
		function __construct($database=null) {
			global $tLog;
			$this->tLog = &$tLog;
			if (!isset(self::$sLink)) {
				//Set the link to the mysql server
				self::$sLink = mysql_connect(MYSQL_SERVER,MYSQL_ROOT_USER,MYSQL_ROOT_PASSWORD);
				if (!self::$sLink) {
					$msg = 'Failed to connect to "'.MYSQL_SERVER.'": '.mysql_error();
					$this->tLog->error($msg);
					throw new Exception($msg);
				}
				//$this->tLog->debug(get_class($this).' Successfully connected to "'.MYSQL_SERVER.'"');
			}
			//Make sure the local member can access the connection
			$this->link = &self::$sLink;
			$database = (is_null($database)) ? MYSQL_DEFAULT_DB : $database;
			if (!mysql_select_db($database,$this->link)) {
				$msg = 'Failed to select database "'.$database.'": '.mysql_error();
				$this->tLog->error($msg);
				throw new Exception($msg);
			}
			//$this->tLog->debug('Successfully selected database "'.$database.'"');
			return TRUE;
		}
		
		function getConnection() {
			return $this->link;
		}
		
		function closeConnection() {
			//$this->tLog->debug('Closing connection to the DB');
			mysql_close($this->link);
		}
		
		function query($sql) {
			//$this->tLog->debug('Running query: '.$sql);
			$result = mysql_query($sql,$this->link);
			if ($result===FALSE) {
				$msg = 'Query failed for "'.$sql.'": '.mysql_error();
				$this->tLog->warn($msg);
				throw new Exception($msg);
			}
			return $result;
		}
		function insert($sql) {
			//$this->tLog->debug('Running insert: '.$sql);
			$temp = mysql_query($sql,$this->link);
			if ($temp===FALSE) {
				$msg = 'Insert failed for "'.$sql.'": '.mysql_error();
				$this->tLog->warn($msg);
				throw new Exception($msg);
			}
			return mysql_insert_id($this->link);
		}
		
		function createObjectRecord($table,$object) {
			$sql = $this->insertStatement($table,$object->getFields());
			return $this->insert($sql);
		}
        /**
         * Inserts an object, using the object's provided ID
         * @param <String> $table
         * @param <DBObject> $object
         * @return <mixed>      The ID provided for this object,
         *                      or FALSE, if the insert failed
         */
        function createExactObjectRecord($table,$object) {
            $sql = $this->insertStatement($table, $object->getFields(), true);
            return $this->insert($sql);
        }
		
		function removeObjectRecord($table,$object) {
			$sql = $this->deleteStatemente($table,$object->id);
			return $this->query($sql);
		}
		
		function loadObjectByField($table,$field,$value,$object) {
			$sql = "SELECT * FROM `$table` WHERE `$field`='".mysql_real_escape_string($value)."';";
			$rs = $this->query($sql);
			$row = mysql_fetch_assoc($rs);
			//Convert `dt` to a timestamp
			$object->loadData($row);
            //Todo: No need to return the object; the object is being updated already
			return $object;
		}

        function loadObjectMatch($table,$object) {
            $valuesArray = $object->getFields();
            $sql = $this->matchStatement($table, $valuesArray);
            //$this->tLog->debug("Running MATCH SQL: $sql");
            $rs = $this->query($sql);

            if ($rs === false) {
                return false;
            }
            $row = mysql_fetch_assoc($rs);

            return $object->loadData($row);
        }
		
		function loadObjectsByField($table,$field,$value,$object,$count=null) {
            //SELECT `id` FROM `page_event` WHERE `session` LIKE 'bake9vo9shcam3tt482nb0sm42' ORDER BY `id` DESC LIMIT 0,3
			$objectsArray = array();
            $sql = "SELECT * FROM `$table` WHERE `$field`=".$this->validateValue($field, $value)." ORDER BY `id` DESC".(is_null($count) ? '' : " LIMIT 0,$count").";";
			$rs = $this->query($sql);
			while($row = mysql_fetch_assoc($rs)) {
				$count = count($objectsArray);
				//Convert `dt` to a timestamp
				//if (isset($row['dt'])) {
				//	$row['dt'] = $this->convertMysqlDateToTimestamp($row['dt']);
				//}
				$className = get_class($object);
				$objectsArray[$count] = &new $className($row);
				//$objectsArray[$count]->loadData($row);
			}
			return $objectsArray;
		}
        function loadObjectsByFields($table,$fieldsAndValues,$object,$count=null) {
            $objectsArray = array();
            $whereClause = '';
            $andDelimiter = '';
            foreach ($fieldsAndValues as $field => $value) {
                $whereClause .= " $andDelimiter `$field`=".$this->validateValue($field, $value);
                $andDelimiter = 'AND';
            }

            if ($whereClause == '') {
                //Do not load any objects; No WHERE parameters provided
                $whereClause = '1 = 2';
            }
            $sql = "SELECT * FROM `$table` WHERE $whereClause ORDER BY `id` DESC".(is_null($count) ? '' : " LIMIT 0,$count").";";
            //$this->tLog->debug("Running SQL: $sql");
			$rs = $this->query($sql);
			while($row = mysql_fetch_assoc($rs)) {
				$count = count($objectsArray);
				$className = get_class($object);
				$objectsArray[$count] = &new $className($row);
			}
			return $objectsArray;
        }
		
		function updateObjectByField($table,$object,$field) {
			$dataArray = $object->getFields();
			$where="`$field`='".mysql_real_escape_string($dataArray[$field])."'";
			$sql = $this->updateStatement($table,$dataArray,$where);
			
			$rs = $this->query($sql);
		}

        function cleanupObjectsByDate($table,$dt) {
            $sql = $this->cleanupStatement($table, $dt);
            $this->tLog->notice("SQL for Cleanup is: $sql");
            $this->query($sql);
        }
		
		//Utilites
		function insertStatement($table,$valuesArray,$allowId = false) {
			$comma = '';
			$fields = '';
			$values = '';
			foreach($valuesArray as $key => $value) {
				if ($key != 'id' || $allowId) {
					//Fields builder
					$fields .= "$comma`$key`";
					
					$values .= $comma.$this->validateValue($key,$value);
					$comma = ',';
				}
			}
			return "INSERT INTO `$table` ($fields) VALUES($values);";
		}
		
		function deleteStatement($table,$id) {
			return "DELTE FROM `$table` WHERE `id` = $id;";
		}

        function cleanupStatement($table,$dt) {
            return "DELETE FROM `$table` WHERE `dt` < $dt;";
        }
		
		
		function updateStatement($table,$valuesArray,$where='1=0') {
			$comma = '';
			$updates = '';
			foreach($valuesArray as $key => $value) {
				if ($key != 'id' && $key != 'dt') {
					//Fields builder
					$field = "`$key`";
				
					$updates .= "$comma$field=".$this->validateValue($key,$value);
					$comma = ',';
				}
			}
			return "UPDATE `$table` SET $updates WHERE $where;";
		}

        function matchStatement($table,$valuesArray) {
            $where = '';
            $and = '';
            foreach($valuesArray as $key => $value) {
                $value = $this->validateValue($key, $value);
                if ($key != 'dt' && $value!='null') {
                    $where .= $and.'`'.$key.'` = '. $value;
                    $and = ' AND ';
                }
            }
            if ($where == '') {
                $where = '1 = 2';

            }
            $sql = 'SELECT * FROM `'.$table.'` WHERE '.$where.';';
            if ($where == '1 = 2')
                $this->tLog->info('Match statement does not have any non-null values: '.$sql);
            return $sql;
        }
		
		function convertMysqlDateToTimestamp($dt) {
            if (is_null($dt) || $dt == '') {
                $this->tLog->info('There is no date to convert to a timestamp.');
                return $dt;
            }
			//$this->tLog->debug('Converting MySQL date('.$dt.') to a timestamp');
			$year = (int) substr($dt,0,4);
			$month = (int) substr($dt,5,2);
			$day = (int) substr($dt,8,2);
			$hour = (int) substr($dt,11,2);
			$minute = (int) substr($dt,14,2);
			$second = (int) substr($dt,17,2);
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
		
		function validateValue($key,$value) {
			switch($key) {
				case 'blnvalid':
					return ($value) ? 1 : 0;
				case 'dt':
                    if ($value == '') {
                        $value = $_SERVER['REQUEST_TIME'];
                    }
					if (is_numeric($value)) {
                        //$this->tLog->debug("A Date: '".date("Y-m-d G:i:s",(integer)$value)."'");
						return "'".date("Y-m-d G:i:s",(integer)$value)."'";
					}
				default:
					if (is_null($value)) {
						return 'null';
					}
					else if (is_numeric($value)) {
						return $value;
					}
					else {
						return "'".mysql_real_escape_string($value)."'";
					}
			}
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
        /**
         * A translator for the key used in the object
         * This is for objects that use different field identifiers for linked
         * objects
         * @param <String> $key The key that is trying to be used
         * @return <String> The appropriate key to use for this object
         */
        function revertKey($key) {
            return $key;
        }
        static function getBooleanValue($value) {
            return (is_null($value)? 'NULL' : "[$value]".($value ? 'TRUE' : 'FALSE'));
        }
	}
?>
