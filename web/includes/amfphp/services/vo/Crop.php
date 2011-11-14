<?php
/**
 *	This is a Value Object (VO) aka Data Transfer Object (DTO).
 *	For data exchanging with client application.
 *
 *	Corresponds to 'crops' table, as described at http://spreadsheets.google.com/ccc?key=ppWO4WjtdJsjZvjQh78HwAQ
 */
class Crop
{
	/*	
		TODO:
		
		$dt - to be added
		Note: Mod Class Needs To be Added To Crops Table.
	*/
	
	public $id;
	public $cropLocation;
	public $shortDescription;
	public $dimensionWidth;
	public $dimensionHeight;
	public $scale;
	public $rotation;
	public $offsetX;
	public $offsetY;
	public $masterId;
	
	public $alternate;
	public $title;
	
	public $dt;
	public $blnvalid;
	
	public function __construct($i=-1,$cL='',$dW=0,$dH=0,$sD='',$s=100,$r=0,$oX=0,$oY=0,$mI=0,$a='',$t='') {
		$this->id = $i;
		$this->cropLocation=$cL;
		$this->dimensionWidth=$dW;
		$this->dimensionHeight=$dH;
		$this->shortDescription=$sD;
		$this->scale=$s;
		$this->rotation=$r;
		$this->offsetX=$oX;
		$this->offsetY=$oY;
		$this->masterId=$mI;
		$this->alternate=$a;
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
			'location' => &$this->cropLocation,
			'height' => &$this->dimensionHeight,
			'width' => &$this->dimensionWidth,
            'title' => &$this->title,
            'alternate' => &$this->alternate,
			'description' => &$this->shortDescription,
			'scale' => &$this->scale,
			'rotation' => &$this->rotation,
			'offset_x' => &$this->offsetX,
			'offset_y' => &$this->offsetY,
			'content_library_master' => &$this->masterId,
			'dt' => &$this->dt,
			'blnvalid' => &$this->blnvalid
		);
	}
	//Todo move filename generation out of here; preferably a URL generator class
	public function generateCropFileName() {
		return 'http://'.CONTENT.URL_SEPARATOR.IMAGE_DIRECTORY.URL_SEPARATOR.'crop_'.$this->masterId.'_'.$this->id.'.png';
	}
	
	public function setProperNames() {
		$this->cropLocation = $this->generateCropFileName();
	}
	
	public function hasProperCropName() {
		return ($this->cropLocation == $this->generateCropFileName());
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