<?php
/**
 *	This is a Value Object (VO) aka Data Transfer Object (DTO).
 *	For data exchanging with client application.
 *
 *	Corresponds to 'masters' table, as described at http://spreadsheets.google.com/ccc?key=ppWO4WjtdJsjZvjQh78HwAQ
 */
class Master
{
	
	public $id;
	public $masterLocation;
	public $thumbnailLocation;
	public $dimensionWidth;
	public $dimensionHeight;
	public $shortDescription;
	public $scale;
	public $rotation;
	public $offsetX;
	public $offsetY;
	
	public $alternate;
	public $title;
	
	//Dates will be stored as UNIX timestamps (in seconds)
	public $dt;//	date_added required 
	public $blnvalid;
	
	
	public function __construct($i=-1,$mL='',$tL='',$dW=0,$dH=0,$sD='',$s=100,$r=0,$oX=0,$oY=0,$a='',$t='') {
		$this->id = $i;
		$this->masterLocation=$mL;
		$this->thumbnailLocation=$tL;
		$this->dimensionWidth=$dW;
		$this->dimensionHeight=$dH;
		$this->shortDescription=$sD;
		$this->scale=$s;
		$this->rotation=$r;
		$this->offsetX=$oX;
		$this->offsetY=$oY;
		$this->alternate=$a;
		$this->title=$t;
		$this->dt = $_SERVER['REQUEST_TIME'];
		$this->blnvalid = true;
		
	}
	//Todo: Move URL creation out of this class
	public function generateMasterFileName() {
		return 'http://'.CONTENT.URL_SEPARATOR.IMAGE_DIRECTORY.URL_SEPARATOR.'master_'.$this->id.'.png';
	}
	public function generateThumbnailFileName() {
		return 'http://'.CONTENT.URL_SEPARATOR.IMAGE_DIRECTORY.URL_SEPARATOR.'thumb_'.$this->id.'.png';
	}
	
	public function setProperNames() {
		$this->masterLocation = $this->generateMasterFileName();
		$this->thumbnailLocation = $this->generateThumbnailFileName();
	}
	
	public function hasProperMasterName() {
		return ($this->masterLocation == $this->generateMasterFileName());
	}
	public function hasProperThumbnailName() {
		return ($this->thumbnailLocation == $this->generateThumbnailFilename());
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
			'location' => &$this->masterLocation,
			'thumbnail_location' => &$this->thumbnailLocation,
			'height' => &$this->dimensionHeight,
			'width' => &$this->dimensionWidth,
            'title' => &$this->title,
            'alternate' => &$this->alternate,
			'description' => &$this->shortDescription,
			'scale' => &$this->scale,
			'rotation' => &$this->rotation,
			'offset_x' => &$this->offsetX,
			'offset_y' => &$this->offsetY,
			'dt' => &$this->dt,
			'blnvalid' => &$this->blnvalid
		);
	}
	/*
	function getFields() {
		return array(
			'id' => &$this->id,
			'master_location' => &$this->masterLocation,
			'thumbnail_location' => &$this->thumbnailLocation,
			'dimension_height' => &$this->dimensionHeight,
			'dimension_width' => &$this->dimensionWidth,
			'short_description' => &$this->shortDescription,
			'scale' => &$this->scale,
			'rotation' => &$this->rotation,
			'offset_x' => &$this->offsetX,
			'offset_y' => &$this->offsetY,
            'alternate' => &$this->alternate,
            'title' => &$this->title,
			'dt' => &$this->dt,
			'blnvalid' => &$this->blnvalid
		);
	}
     *
     */
	
	function toString() {
		$toString = '';
		$dataArray = $this->getFields();
		foreach($dataArray as $key => $value) {
			$toString .= "$key: $value<br />\n";
		}
		return $toString;
	}
}
