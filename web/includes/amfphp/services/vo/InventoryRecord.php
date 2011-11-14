<?php
/**
 *	This is a Value Object (VO) aka Data Transfer Object (DTO).
 *	For data exchanging with client application.
 *
 */
class InventoryRecord
{
	public $id;
	public $dt;
	public $blnvalid;
	
	public $url;
	public $dealership;
	public $uniqueID;
	public $year;
	public $make;
	public $model;
	public $vin;
	public $stockNumber;
	public $engine;
	public $transmission;
	public $description;
	public $mileage;
	public $price;
	public $color;
	public $dealerAddress;
	public $dealerCity;
	public $dealerState;
	public $dealerZipcode;
	public $dealerPhone;
	public $emailLeadsTo;
	public $equipment;
	public $dealerMessage;
	public $dealerBlurb;
	public $certified;
	public $retailPrice;
	public $multiplePhotos;
	public $highOctane;
	public $highOctane360;
	public $highOctaneMultiPhotos;
	public $addDate;
	public $photoURL;
	
	public function __construct($i=-1) {
		$this->id = $i;
		$this->dt = $_SERVER['REQUEST_TIME'];
		$this->blnvalid = TRUE;
	
		$this->url			= "";
		$this->dealership	= "";
		$this->uniqueID	= "";
		$this->year			= 0;
		$this->make			= "";
		$this->model		= "";
		$this->vin		= "";
		$this->stockNumber		= "";
		$this->engine		= "";
		$this->transmission		= "";
		$this->description		= "";
		$this->mileage		= 0;
		$this->price		= "";
		$this->color		= "";
		$this->dealerAddress		= "";
		$this->dealerCity		= "";
		$this->dealerState		= "";
		$this->dealerZipcode		= "";
		$this->dealerPhone		= "";
		$this->emailLeadsTo		= "";
		$this->equipment		= "";
		$this->dealerMessage		= "";
		$this->dealerBlurb	= "";
		$this->certified		= "";
		$this->retailPrice		= "";
		$this->multiplePhotos		= "";
		$this->highOctane             = "";
		$this->highOctane360          = "";
		$this->highOctaneMultiPhotos  = "";
		$this->addDate		= "";
		$this->photoURL		= "";
		
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
			'Dealership' => &$this->dealership,
			'UniqueID' => &$this->uniqueID,
			'Year' => &$this->year,
			'Make' => &$this->make,
			'Model' => &$this->model,
			'VIN' => &$this->vin,
			'StockNumber' => &$this->stockNumber,
			'Engine' => &$this->engine,
			'Transmission' => &$this->transmission,
			'Description' => &$this->description,
			'Mileage' => &$this->mileage,
			'Price' => &$this->price,
			'Color' => &$this->color,
			'DealerAddress' => &$this->dealerAddress,
			'DealerCity' => &$this->dealerCity,
			'DealerState' => &$this->dealerState,
			'DealerZipcode' => &$this->dealerZipcode,
			'DealerPhone' => &$this->dealerPhone,
			'EmailLeadsTo' => &$this->emailLeadsTo,
			'Equipment' => &$this->equipment,
			'DealerMessage' => &$this->dealerMessage,
			'Certified' => &$this->certified,
			'HighOctane' => &$this->highOctane,
			'HighOctane360' => &$this->highOctane360,
			'HighOctaneMultiPhotos' => &$this->highOctaneMultiPhotos,
			'RetailPrice' => &$this->retailPrice,
			'DealerBlurb' => &$this->dealerBlurb,
			'MultiplePhotos' => &$this->multiplePhotos,
			'AddDate
' => &$this->addDate,
			'PhotoURL' => &$this->photoURL
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