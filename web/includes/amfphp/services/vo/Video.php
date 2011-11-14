<?php
/**
 *	This is a Value Object (VO) aka Data Transfer Object (DTO).
 *	For data exchanging with client application.
 */
class Video
{
	public $id;
	public $location;
	public $thumbnailLocation;
	public $width;
	public $height;
	public $description;
	public $scale;
	public $rotation;
	public $offsetX;
	public $offsetY;
    public $offsetSeconds;
	
	public $alternate;
	public $title;
	
	//Dates will be stored as UNIX timestamps (in seconds)
	public $dt;//	date_added required 
	public $blnvalid;
	
	public function __construct($id=-1,$location='',$thumbnailLocation='',$width=0,$height=0,$description='',$scale=1,$rotation=0,$offsetX=0,$offsetY=0,$offsetSeconds=0,$a='',$t='') {
        $this->id=$id;
        $this->location=$location;
        $this->thumbnailLocation=$thumbnailLocation;
        $this->width=$width;
        $this->height=$height;
        $this->description=$description;
        $this->scale=$scale;
        $this->rotation=$rotation;
        $this->offsetX=$offsetX;
        $this->offsetY=$offsetY;
        $this->offsetSeconds=$offsetSeconds;
		$this->alternate=$a;
		$this->title=$t;
        $this->dt = $_SERVER['REQUEST_TIME'];
        $this->blnvalid=true;
    }
	//Todo: Move URL creation out of this class
	public function generateFileName() {
		return 'http://'.CONTENT.URL_SEPARATOR.VIDEO_DIRECTORY.URL_SEPARATOR.'video_'.$this->id.'.flv';
	}
	public function generateThumbnailFileName() {
		return 'http://'.CONTENT.URL_SEPARATOR.VIDEO_DIRECTORY.URL_SEPARATOR.'thumb_'.$this->id.'.png';
	}
	
	public function setProperNames() {
		$this->location = $this->generateFileName();
		$this->thumbnailLocation = $this->generateThumbnailFileName();
	}
	
	public function hasProperName() {
		return ($this->location == $this->generateFileName());
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
			'location' => &$this->location,
			'thumbnail_location' => &$this->thumbnailLocation,
			'height' => &$this->height,
			'width' => &$this->width,
            'title' => &$this->title,
            'alternate' => &$this->alternate,
			'description' => &$this->description,
			'scale' => &$this->scale,
			'rotation' => &$this->rotation,
			'offset_x' => &$this->offsetX,
			'offset_y' => &$this->offsetY,
            'offset_seconds' => &$this->offsetSeconds,
			'dt' => &$this->dt,
			'blnvalid' => &$this->blnvalid
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
