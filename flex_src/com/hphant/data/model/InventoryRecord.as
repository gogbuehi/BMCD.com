package com.hphant.data.model
{
	import com.adobe.cairngorm.vo.ValueObject;
	import com.hphant.utils.StringUtils;


	[Bindable]
	[RemoteClass(alias="InventoryRecord")]
	public class InventoryRecord implements ValueObject
	{
		
		/**
		 *	properties
		 */
		public var id 		: int;
		public var blnvalid : Boolean = true;//	must be 
		public var dt		: int;
		
		public var url			:String;
		public var dealership	: String;
		public var description	: String;
		public var uniqueID	: String;
		public var year			: Number;
		public var make			: String;
		public var model		: String;
		public var vin		: String;
		public var color		: String;
		public var stockNumber		: String;
		public var engine		: String;
		public var transmission		: String;
		public var mileage		: Number;
		public var price		: String;
		public var dealerAddress		: String;
		public var dealerCity		: String;
		public var dealerState		: String;
		public var dealerZipcode		: String;
		public var dealerPhone		: String;
		public var emailLeadsTo		: String;
		public var equipment		: String;
		public var dealerMessage		: String;
		public var dealerBlurb		: String;
		public var certified		: String;
		public var retailPrice		: String;
		public var multiplePhotos		: String;
		public var highOctane		: String;
		public var highOctane360		: String;
		public var highOctaneMultiPhotos		: String;
		public var addDate		: String;
		public var photoURL		: String;
		
		public function InventoryRecord() {}

		public function toString() : String {
			return "InventoryRecord<"+id+">";
		}
		public function toXMLString():String{
			return '<tr><td><a class="url" href="'+url+'">'+url+'</a></td>' + 
			'<td>'+dealership+'</td>' + 
			'<td>'+uniqueID+'</td>' + 
			'<td>'+year+'</td>' + 
			'<td>'+make+'</td>' + 
			'<td>'+model+'</td>' +
			'<td>'+vin+'</td>' + 
			'<td>'+stockNumber+'</td>' +
			'<td>'+engine+'</td>' +
			'<td>'+transmission+'</td>' +
			'<td>'+description+'</td>' +
			'<td>'+mileage+'</td>' +
			'<td>'+price+'</td>' +
			'<td>'+color+'</td>' +
			'<td>'+dealerAddress+'</td>' +
			'<td>'+dealerCity+'</td>' +
			'<td>'+dealerState+'</td>' +
			'<td>'+dealerZipcode+'</td>' +
			'<td>'+dealerPhone+'</td>' +
			'<td>'+emailLeadsTo+'</td>' +
			'<td><img src="'+photoURL+'"></img></td>' + 
			'<td>'+equipment+'</td>' +
			'<td>'+dealerMessage+'</td>' +
			'<td>'+certified+'</td>' +
			'<td></td>' +
			'<td></td>' +
			'<td></td>' +
			'<td>'+retailPrice+'</td>' +
			'<td>'+dealerBlurb+'</td>' +
			'<td><img src="'+multiplePhotos.split(',').join('"></img><img src="')+'"></img></td>' + 
			'<td>'+addDate+'</td>' + 
			'</tr>';
		}
		
		
		public function clone() : InventoryRecord {
			var clone : InventoryRecord = new InventoryRecord();
			
			clone.id 				= this.id;
			clone.blnvalid			= this.blnvalid;
			clone.dt				= this.dt;
			
			clone.url				= this.url;
			clone.dealership		= this.dealership;
			clone.uniqueID			= this.uniqueID;
			clone.description			= this.description;
			clone.year				= this.year;
		    clone.make				= this.make;
		    clone.color				= this.color;
		    clone.model				= this.model;
		    clone.vin				= this.vin;
		    clone.stockNumber		= this.stockNumber;
		    clone.engine			= this.engine;
		    clone.transmission		= this.transmission;
		    clone.mileage			= this.mileage;
		    clone.price				= this.price;
		    clone.dealerAddress		= this.dealerAddress;
		    clone.dealerCity		= this.dealerCity;
		    clone.dealerState		= this.dealerState;
		    clone.dealerZipcode		= this.dealerZipcode;
		    clone.dealerPhone		= this.dealerPhone;
		    clone.emailLeadsTo		= this.emailLeadsTo;
		    clone.equipment			= this.equipment;
		    clone.dealerMessage		= this.dealerMessage;
		    clone.dealerBlurb		= this.dealerBlurb;
		    clone.certified			= this.certified;
		    clone.retailPrice		= this.retailPrice;
		    clone.multiplePhotos	= this.multiplePhotos;
		    clone.addDate			= this.addDate;
		    clone.photoURL			= this.photoURL;
		    clone.highOctane		= this.highOctane;
		    clone.highOctane360		= this.highOctane360;
		    clone.highOctaneMultiPhotos		= this.highOctaneMultiPhotos;
			
			
			
			return clone;
		}
		
	}
}