<?php
    class SqlUtils {
		static function insert($table,$valuesArray) {
			$comma = '';
			$fields = '';
			$values = '';
			foreach($valuesArray as $key => $value) {
				//Fields builder
				$fields .= "$comma`$key`";
				//Need logic for building VALUES part of query
				if ($value === TRUE)
					$value = 1;
				if ($value === FALSE)
					$value = 0;
				if ($key == 'dt') {
					if ($value == '')
						$tempValue = 'NOW()';
					else
						$tempValue = "'$value'";
				}
				else {
					$tempValue = is_numeric($value) ? $valuesArray[$key] : '\''.mysql_real_escape_string($value).'\'';
				}
				$values .= $comma.$tempValue;
				$comma = ',';
			}
			return "INSERT INTO `$table` ($fields) VALUES($values);";
		}
		
		static function update($table,$valuesArray,$where='1=1') {
			$comma = '';
			$updates = '';
			foreach($valuesArray as $key => $value) {
				//Fields builder
				$field = "`$key`";
				//Need logic for building VALUES part of query
				if ($value === TRUE)
					$value = 1;
				if ($value === FALSE)
					$value = 0;
				if ($key == 'dt') {
					$value = 'NOW()';
				}
				else {
					$value = is_numeric($value) ? $valuesArray[$key] : '\''.mysql_real_escape_string($value).'\'';
				}
				$updates .= "$comma$field=$value";
				$comma = ',';
			}
			return "UPDATE `$table` SET $updates WHERE $where;";
		}
	}
?>