<?php
/**
 *	This is a Value Object (VO) aka Data Transfer Object (DTO).
 *	For data exchanging with client application.
 *
 */
class SuggestionsRecord
{
	public $id;
	public $dt;
	public $blnvalid;
		
	public $url;
	public $imageURL;
	public $text;
	public $itemType;
	public $itemID;
	public $moduleID;
	public $page;
	
	public function __construct($i=-1) {
		$this->id = $i;
		$this->dt = $_SERVER['REQUEST_TIME'];
		$this->blnvalid = TRUE;
		
		$this->url		= "";
		$this->imageURL	= "";
		$this->text		= "";
		$this->itemType	= "";
		$this->itemID	= "";
		$this->moduleID	= "";
		$this->page		= "";
		
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
			'url' => &$this->url,
			'imageURL' => &$this->imageURL,
			'text' => &$this->text,
			'itemType' => &$this->itemType,
			'itemID' => &$this->itemID,
			'moduleID' => &$this->moduleID,
			'page' => &$this->page
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