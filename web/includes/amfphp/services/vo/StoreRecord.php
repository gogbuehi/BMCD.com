<?php
/**
 *	This is a Value Object (VO) aka Data Transfer Object (DTO).
 *	For data exchanging with client application.
 *
 */
class StoreRecord
{
	public $id;
	public $dt;
	public $blnvalid;
	
	public $url;
	public $productId;
	public $brand;
	public $productNumber;
	public $title;
	public $price;
	public $size;
	public $color;
	public $mfca;
	public $images;
	public $thumb;
	public $sale;
	public $shortDescription;
	public $longDescription;
	public $category;
	public $pageDescription;
	public $pageKeywords;
	public $visible;
	
	public function __construct($i=-1) {
		$this->id = $i;
		$this->dt = $_SERVER['REQUEST_TIME'];
		$this->blnvalid = TRUE;
	
		$this->url			= "";
		$this->productId	= "";
		$this->brand			= "";
		$this->productNumber			= "";
		$this->title		= "";
		$this->price		= "";
		$this->size		= "";
		$this->color		= "";
		$this->mfca		= "";
		$this->images		= "";
		$this->thumb		= "";
		$this->sale		= "";
		$this->shortDescription		= "";
		$this->longDescription		= "";
		$this->category		= "";
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
			'productId' => &$this->productId,
			'brand' => &$this->brand,
			'productNumber' => &$this->productNumber,
			'title' => &$this->title,
			'price' => &$this->price,
			'size' => &$this->size,
			'color' => &$this->color,
			'mfca' => &$this->mfca,
			'images' => &$this->images,
			'thumb' => &$this->thumb,
			'sale' => &$this->sale,
			'shortDescription' => &$this->shortDescription,
			'longDescription' => &$this->longDescription,
			'category' => &$this->category,
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