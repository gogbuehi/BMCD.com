package com.hphant.data.model
{
	import com.adobe.cairngorm.vo.ValueObject;
	
	import mx.collections.ArrayCollection;


	[Bindable]
	[RemoteClass(alias="StoreRecord")]
	public class StoreRecord implements ValueObject
	{
		
		/**
		 *	properties
		 */
		public var id 		: int;
		public var blnvalid : Boolean = true;//	must be 
		public var dt		: int;
		
		public var url			:String = "";
		public var productId	: String = "";
		public var brand			: String = "";
		public var productNumber	: String = "";
		public var title		: String = "";
		public var price		: String = "";
		public var size		: String = "";
		public var color		: String = "";
		public var mfca		: String = "";
		public var images		: String = "";
		public var thumb		: String = "";
		public var sale		: String = "";
		public var shortDescription		: String = "";
		public var longDescription		: String = "";
		public var category		: String = "";
		public var pageDescription		: String = "";
		public var pageKeywords		: String = "";
		public var visible		: uint = 1;
		
		public function StoreRecord() {}

		public function toString() : String {
			return "StoreRecord<"+id+">";
		}
		public function toXMLString():String{
			return '<tr><td><a class="url" href="'+url+'">'+url+'</a></td>' + 
			'<td>'+productId+'</td>' + 
			'<td>'+brand+'</td>' + 
			'<td>'+title+'</td>' + 
			'<td>'+price+'</td>' + 
			'<td>'+mfca+'</td>' + 
			'<td><img src="'+images.split(',').join('"></img><img src="')+'"></img></td>' + 
			'<td><img src="'+thumb+'"></img></td>' + 
			'<td>'+sale+'</td>' + 
			'<td>'+shortDescription+'</td>' + 
			'<td>'+longDescription+'</td>' + 
			'<td>'+category+'</td>' + 
			'<td>'+
			'<table><thead><tr><td>Item Number</td><td>Size</td><td>Color</td></tr></thead>' + 
			'<tbody><tr><td>'+productNumber+'</td>' + 
			'<td>'+size+'</td>' + 
			'<td>'+color+'</td></tr></tbody></table>'+
			'</td></tr>';
		}
		public function clone() : StoreRecord {
			var clone : StoreRecord = new StoreRecord();
			
			clone.id 				= this.id;
			clone.blnvalid			= this.blnvalid;
			clone.dt				= this.dt;
			
			clone.url				= this.url;
			clone.productId		= this.productId;
			clone.brand			= this.brand;
		    clone.productNumber	= this.productNumber;
		    clone.title			= this.title;
		    clone.price			= this.price;
		    clone.size			= this.size;
		    clone.color			= this.color;
		    clone.mfca						= this.mfca;
		    clone.images					= this.images;
		    clone.thumb						= this.thumb;
		    clone.sale						= this.sale;
		    clone.shortDescription			= this.shortDescription;
		    clone.longDescription			= this.longDescription;
		    clone.category					= this.category;
		    clone.pageDescription			= this.pageDescription;
		    clone.pageKeywords			= this.pageKeywords;
		    clone.visible					= this.visible;
		   
			return clone;
		}
		
	}
}