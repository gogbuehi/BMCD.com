<?php
/**
 *	This is a Value Object (VO) aka Data Transfer Object (DTO).
 *	For data exchanging with client application.
 *
 */
class PDF
{
	/*	
		TODO:
		
		$dt - to be added
		Note: Mod Class Needs To be Added To Crops Table.
	*/
	
	public $id;
	public $location;
	public $title;
	
	public $dt;
	public $blnvalid;
	
	public function __construct($i=-1,$cL='',$t='') {
		$this->id = $i;
		$this->location=$cL;
		$this->title=$t;
		
		$this->dt = $_SERVER['REQUEST_TIME'];
		$this->blnvalid = TRUE;
		
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
			'location' => &$this->location,
            'title' => &$this->title,
			'dt' => &$this->dt,
			'blnvalid' => &$this->blnvalid
		);
	}
	//Todo move filename generation out of here; preferably a URL generator class
	public function generatePDFFileName() {
		return 'http://'.CONTENT.URL_SEPARATOR.PDF_DIRECTORY.URL_SEPARATOR.PDF_BASE_FILENAME.'_'.$this->id.'.'.PDF_EXTENSION;
	}
	
	public function setProperNames() {
		$this->location = $this->generatePDFFileName();
	}
	
	public function hasProperPDFName() {
		return ($this->location == $this->generatePDFFileName());
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