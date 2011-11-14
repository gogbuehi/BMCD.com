package com.hphant.data.model
{
	import com.adobe.cairngorm.vo.ValueObject;
	
	import mx.collections.ArrayCollection;


	[Bindable]
	[RemoteClass(alias="ModelRecord")]
	public class ModelRecord implements ValueObject
	{
		
		/**
		 *	properties
		 */
		public var id 		: int;
		public var blnvalid : Boolean = true;//	must be 
		public var dt		: int;
		
		public var url			:String = "";
		public var make	: String = "";
		public var model			: String = "";
		public var submodel			: String = "";
		public var description		: String = "";
		public var images		: String = "";
		public var videos		: String = "";
		public var engine		: String = "";
		public var displacement		: String = "";
		public var horsepower		: String = "";
		public var acceleration		: String = "";
		public var topSpeed		: String = "";
		public var msrp		: String = "";
		public var brochure		: String = "";
		public var configurator		: String = "";
		public var manufacture		: String = "";
		public var pageDescription		: String = "";
		public var pageKeywords		: String = "";
		public var visible		: uint = 1;
		
		public function ModelRecord() {}

		public function toString() : String {
			return "ModelRecord<"+id+">";
		}
		public function toXMLString():String{
			return '<tr><td><a class="url" href="'+url+'">'+url+'</a></td>' + 
			'<td>'+make+'</td>' + 
			'<td>'+model+'</td>' + 
			'<td>'+submodel+'</td>' + 
			'<td>'+description+'</td>' +
			'<td><a href="'+videos.split(',').join('">Video</a><a href="')+'">Video</a></td>' + 
			'<td><img src="'+images.split(',').join('"></img><img src="')+'"></img></td>' + 
			'<td>'+engine+'</td>' + 
			'<td>'+displacement+'</td>' + 
			'<td>'+horsepower+'</td>' + 
			'<td>'+acceleration+'</td>' + 
			'<td>'+topSpeed+'</td>' + 
			'<td>'+msrp+'</td>' +  
			'<td><a class="url" href="'+brochure+'">'+brochure+'</a></td>' + 
			'<td><a class="url" href="'+configurator+'">'+configurator+'</a></td>' + 
			'<td><a class="url" href="'+manufacture+'">'+manufacture+'</a></td>' + 
			'</tr>';
		}
		
		public function clone() : ModelRecord {
			var clone : ModelRecord = new ModelRecord();
			
			clone.id 				= this.id;
			clone.blnvalid			= this.blnvalid;
			clone.dt				= this.dt;
			
			clone.url				= this.url;
			clone.make		= this.make;
			clone.model			= this.model;
		    clone.submodel	= this.submodel;
		    clone.description			= this.description;
		    clone.images			= this.images;
		    clone.videos			= this.videos;
		    clone.engine			= this.engine;
		    clone.displacement						= this.displacement;
		    clone.horsepower					= this.horsepower;
		    clone.acceleration						= this.acceleration;
		    clone.topSpeed						= this.topSpeed;
		    clone.msrp			= this.msrp;
		    clone.brochure			= this.brochure;
		    clone.configurator					= this.configurator;
		    clone.manufacture					= this.manufacture;
		    clone.pageDescription			= this.pageDescription;
		    clone.pageKeywords			= this.pageKeywords;
		    clone.visible					= this.visible;
		   
			return clone;
		}
		
	}
}