package com.hphant.data.model
{
	import com.adobe.cairngorm.vo.ValueObject;


	[Bindable]
	[RemoteClass(alias="CalendarRecord")]
	public class CalendarRecord implements ValueObject
	{
		
		/**
		 *	properties
		 */
		public var id 		: int;
		public var blnvalid : Boolean = true;//	must be 
		public var dt		: int;
		
		
		public var url			:String = "";
		public var title			: String = "";
		public var blurb			: String = "";
		public var description		: String = "";
		public var startTime		: String = "";
		public var endTime		: String = "";
		public var date		: String = "";
		public var map		: String = "";
		public var locationName		: String = "";
		public var street		: String = "";
		public var city		: String = "";
		public var state		: String = "";
		public var zip		: String = "";
		public var thumb		: String = "";
		public var images		: String = "";
		public var pageDescription		: String = "";
		public var pageKeywords		: String = "";
		public var visible		: uint = 1;
		
		public function CalendarRecord() {}

		public function toString() : String {
			return "CalendarRecord<"+id+">";
		}
		public function toXMLString():String{
			return '<tr><td><a class="url" href="'+url+'">'+url+'</a></td>' + 
			'<td>'+title+'</td>' + 
			'<td>'+blurb+'</td>' + 
			'<td>'+description+'</td>' + 
			'<td>'+startTime+'</td>' + 
			'<td>'+endTime+'</td>' + 
			'<td>'+date+'</td>' + 
			'<td>'+map+'</td>' + 
			'<td>'+locationName+'</td>' + 
			'<td>'+street+'</td>' + 
			'<td>'+city+'</td>' + 
			'<td>'+state+'</td>' + 
			'<td><img src="'+thumb+'"></img></td>' + 
			'<td><img src="'+images.split(',').join('"></img><img src="')+'"></img></td>' + 
			'<td>'+zip+'</td>' + 
			'</tr>';
		}
		
		public function clone() : CalendarRecord {
			var clone : CalendarRecord = new CalendarRecord();
			
			clone.id 				= this.id;
			clone.blnvalid			= this.blnvalid;
			clone.dt				= this.dt;
			
			clone.url				= this.url;
			clone.title		= this.title;
			clone.blurb			= this.blurb;
		    clone.description	= this.description;
		    clone.startTime			= this.startTime;
		    clone.date			= this.date;
		    clone.map			= this.map;
		    clone.locationName						= this.locationName;
		    clone.street					= this.street;
		    clone.city						= this.city;
		    clone.zip						= this.zip;
		    clone.thumb			= this.thumb;
		    clone.images			= this.images;
		    clone.pageDescription			= this.pageDescription;
		    clone.pageKeywords			= this.pageKeywords;
		    clone.visible					= this.visible;
		   
			return clone;
		}
		
	}
}