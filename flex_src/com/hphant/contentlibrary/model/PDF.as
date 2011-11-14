package com.hphant.contentlibrary.model
{
	import com.adobe.cairngorm.vo.ValueObject;


	[Bindable]
	[RemoteClass(alias="PDF")]
	public class PDF implements ValueObject
	{
		
		/**
		 *	properties
		 */
		public var id 		: int;
		public var blnvalid : Boolean = true;//	must be 
		public var dt		: int;
		
		public var location		: String;
		
		public var title		: String;
		
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
		
		public function PDF() {}

		public function toString() : String {
			return "PDF<"+id+"> '"+title+"'";
		}
		
		public function clone() : PDF {
			var clone : PDF = new PDF();
			
			clone.id 				= this.id;
			clone.blnvalid			= this.blnvalid;
			clone.dt				= this.dt;
			
			clone.location		= this.location;
			clone.title				= this.title;
			
			return clone;
		}
		
	}
}