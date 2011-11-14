<?php
/**
 *	This is a Value Object (VO) aka Data Transfer Object (DTO).
 *	For data exchanging with client application.
 *
 */
class DataFilter
{
	public $id;
	public $dt;
	public $blnvalid;
	
	public $table;
	public $column;
	public $condition;
	public $operator;
	public $html_id;
	public $page_url;
	
	public function __construct($i=-1) {
		$this->id = $i;
		$this->dt = $_SERVER['REQUEST_TIME'];
		$this->blnvalid = TRUE;
	
	
		$this->table			= "";
		$this->column	        = "";
		$this->condition		= "";
		$this->operator			= "";
		$this->html_id			= "";
		$this->page_url			= "";
		
	}
	
	function loadData($dataArray) {
		$fields = $this->getFields();
		foreach($fields as $key => &$value) {
			if(isset($dataArray[$key])) {
				$value = $dataArray[$key];
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
			'blnvalid' => &$this->blnvalid,
			'table' => &$this->table,
			'column' => &$this->column,
			'condition' => &$this->condition,
			'operator' => &$this->operator,
			'html_id' => &$this->html_id,
			'page_url' => &$this->page_url
		);
	}
	
	function toString() {
		$toString = '';
		$dataArray = $this->getFields();
		foreach($dataArray as $key => $value) {
			$toString .= "$key: $value<br />\n";
		}
		return $toString;
	}
}
?>