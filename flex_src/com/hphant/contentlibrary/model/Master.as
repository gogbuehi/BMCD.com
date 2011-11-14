package com.hphant.contentlibrary.model
{
	import com.adobe.cairngorm.vo.ValueObject;


	[Bindable]
	[RemoteClass(alias="Master")]
	public class Master implements ValueObject
	{
		
		/**
		 *	Properties.
		 *  Refers to 'masters' table, as described at: 
		 * 	@see http://spreadsheets.google.com/ccc?key=ppWO4WjtdJsjZvjQh78HwAQ
		 * 
		 * 	For specific property types, see: 
		 * 	@see http://docs.google.com/Doc?id=djfhmk9_4gbfcdfd9
		 * 
		 */
		public var id : int;
		
		public var masterLocation		: String;
		public var thumbnailLocation	: String;
		public var dimensionWidth		: int;
		public var dimensionHeight		: int;
		public var shortDescription		: String;
		
		public var title			: String;
		public var alternate		: String;
		
		public var scale	: int = 100;
		public var rotation	: Number = 0;
		public var offsetX	: Number = 0;
		public var offsetY	: Number = 0;
		
		public var blnvalid : Boolean = true;//	must be 
		
		//	TODO
		//	Use Date as type.
		//
		// 	date of creation
		//public var dt		: String;
		public var dt		: int;
		/*
		public var dt		: Date;	// - reports  TypeError: Error #1034: Type Coercion failed: cannot convert "2008-09-10 10:32:39" to Date.
									//			TypeError: Error #1034: Type Coercion failed: cannot convert Object@3ed12e1 to Date.
									//			TypeError: Error #1034: Type Coercion failed: cannot convert 1221559205 to Date.
		*/
		
		
		
/*	
//	Master.php
	
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
*/		
		
/*
'masters' table, as described at: http://spreadsheets.google.com/ccc?key=ppWO4WjtdJsjZvjQh78HwAQ
For specific property types, see: http://docs.google.com/Doc?id=djfhmk9_4gbfcdfd9

id
master_location
thumbnail_location
[crops; not in the photos table]
dimension_width
dimension_height
short_description
scale
rotation
offset_x
offset_y
*/
		
		
		
		public function Master() {}
		
		public function toString() : String {
			return "Master<"+id+"> '"+shortDescription+"'";
		}

		public function clone() : Master {
			var clone : Master = new Master();
			
			clone.id 				= this.id;
			clone.blnvalid			= this.blnvalid;
			clone.dt				= this.dt;
			
			clone.masterLocation	= this.masterLocation;
			clone.thumbnailLocation = this.thumbnailLocation;
			clone.dimensionWidth	= this.dimensionWidth;
			clone.dimensionHeight	= this.dimensionHeight;
			clone.shortDescription	= this.shortDescription;
			
			clone.alternate			= this.alternate;
			clone.title				= this.title;
			
			clone.scale				= this.scale;
			clone.rotation			= this.rotation;
			clone.offsetX			= this.offsetX;
			clone.offsetY			= this.offsetY;
			
			return clone;
		}
		
	}
}