package com.hphant.contentlibrary.model
{
	import com.adobe.cairngorm.vo.ValueObject;


	[Bindable]
	[RemoteClass(alias="Crop")]
	public class Crop implements ValueObject
	{
		
		/**
		 *	properties
		 */
		public var id 		: int;
		public var blnvalid : Boolean = true;//	must be 
		public var dt		: int;
		
		public var cropLocation		: String;
		public var shortDescription	: String;
		public var dimensionWidth	: int;
		public var dimensionHeight	: int;
		
		public var title			: String;
		public var alternate		: String;
		
		public var scale	: int = 100;
		public var rotation	: Number = 0;
		public var offsetX	: Number = 0;
		public var offsetY	: Number = 0;
		
		public var masterId	: int;
		
/*
	//	Crop.php
	
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
	
	public $dt;
	public $blnvalid;

*/
		
		public function Crop() {}

		public function toString() : String {
			return "Crop<"+id+"> '"+shortDescription+"'";
		}
		
		public function clone() : Crop {
			var clone : Crop = new Crop();
			
			clone.id 				= this.id;
			clone.blnvalid			= this.blnvalid;
			clone.dt				= this.dt;
			
			clone.cropLocation		= this.cropLocation;
			clone.shortDescription	= this.shortDescription;
			clone.dimensionWidth	= this.dimensionWidth;
			clone.dimensionHeight	= this.dimensionHeight;
			
			clone.alternate			= this.alternate;
			clone.title				= this.title;
			
			clone.scale				= this.scale;
			clone.rotation			= this.rotation;
			clone.offsetX			= this.offsetX;
			clone.offsetY			= this.offsetY;
			
			clone.masterId			= this.masterId;
			
			return clone;
		}
		
	}
}