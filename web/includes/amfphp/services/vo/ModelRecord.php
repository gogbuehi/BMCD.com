<?php
/**
 *	This is a Value Object (VO) aka Data Transfer Object (DTO).
 *	For data exchanging with client application.
 *
 */
class ModelRecord
{
	public $id;
	public $dt;
	public $blnvalid;
	
	public $url;
	public $make;
	public $model;
	public $submodel;
	public $description;
	public $images;
	public $videos;
	public $engine;
	public $displacement;
	public $horsepower;
	public $acceleration;
	public $topSpeed;
	public $msrp;
	public $brochure;
	public $configurator;
	public $manufacture;
	public $pageDescription;
	public $pageKeywords;
	public $visible;
	
	public function __construct($i=-1) {
		$this->id = $i;
		$this->dt = $_SERVER['REQUEST_TIME'];
		$this->blnvalid = TRUE;
	
	
		$this->url			= "";
		$this->make	= "";
		$this->model			= "";
		$this->submodel			= "";
		$this->description		= "";
		$this->images		= "";
		$this->videos		= "";
		$this->engine		= "";
		$this->displacement		= "";
		$this->horsepower		= "";
		$this->acceleration		= "";
		$this->topSpeed		= "";
		$this->msrp		= "";
		$this->brochure		= "";
		$this->configurator		= "";
		$this->manufacture		= "";
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
			'make' => &$this->make,
			'model' => &$this->model,
			'submodel' => &$this->submodel,
			'description' => &$this->description,
			'images' => &$this->images,
			'videos' => &$this->videos,
			'engine' => &$this->engine,
			'displacement' => &$this->displacement,
			'horsepower' => &$this->horsepower,
			'acceleration' => &$this->acceleration,
			'topSpeed' => &$this->topSpeed,
			'msrp' => &$this->msrp,
			'brochure' => &$this->brochure,
			'configurator' => &$this->configurator,
			'manufacture' => &$this->manufacture,
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