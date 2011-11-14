<?php
/**
 *	This is a Value Object (VO) aka Data Transfer Object (DTO).
 *	For data exchanging with client application.
 *
 */
class CalendarRecord
{
	public $id;
	public $dt;
	public $blnvalid;
	
	public $url;
	public $title;
	public $blurb;
	public $description;
	public $startTime;
	public $endTime;
	public $date;
	public $map;
	public $locationName;
	public $street;
	public $city;
	public $state;
	public $zip;
	public $thumb;
	public $images;
	public $pageDescription;
	public $pageKeywords;
	public $visible;
	
	public function __construct($i=-1) {
		$this->id = $i;
		$this->dt = $_SERVER['REQUEST_TIME'];
		$this->blnvalid = TRUE;
	
	
		$this->url = "";
		$this->title = "";
		$this->blurb = "";
		$this->description = "";
		$this->startTime = "";
		$this->endTime = "";
		$this->date = "";
		$this->map = "";
		$this->locationName = "";
		$this->street = "";
		$this->city = "";
		$this->state = "";
		$this->zip = "";
		$this->thumb = "";
		$this->images = "";
		$this->pageDescription = "";
		$this->pageKeywords = "";
		$this->visible = TRUE;
		
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
			'title' => &$this->title,
			'blurb' => &$this->blurb,
			'description' => &$this->description,
			'startTime' => &$this->startTime,
			'endTime' => &$this->endTime,
			'date' => &$this->date,
			'map' => &$this->map,
			'locationName' => &$this->locationName,
			'street' => &$this->street,
			'city' => &$this->city,
			'state' => &$this->state,
			'zip' => &$this->zip,
			'thumb' => &$this->thumb,
			'images' => &$this->images,
			'pageDescription' => &$this->pageDescription,
			'pageKeywords' => &$this->pageKeywords,
			'visible' => &$this->visible
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