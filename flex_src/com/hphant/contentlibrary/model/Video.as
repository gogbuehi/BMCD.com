package com.hphant.contentlibrary.model
{
	import com.adobe.cairngorm.vo.ValueObject;


	[Bindable]
	[RemoteClass(alias="Video")]
	public class Video implements ValueObject
	{
		
		/**
		 *	properties goes here
		 */
		public var id : uint;
		public var description : String;
		public var location : String;
		public var thumbnailLocation	: String;
		public var width		: int;
		public var height		: int;
		
		public var title			: String;
		public var alternate		: String;
		
		public var scale	: int = 100;
		public var rotation	: Number = 0;
		public var offsetX	: Number = 0;
		public var offsetY	: Number = 0;
		public var offsetSeconds	: Number = 0;
		
		public var blnvalid : Boolean = true;//	must be 
		
		//	TODO
		//	Use Date as type.
		//
		// 	date of creation
		//public var dt		: String;
		public var dt		: int;
		
		
		
		public function Video()
		{
		}

		public function toString() : String {
			return "Video<"+id+"> '"+description+"'";
		}
		
		public function clone() : Video {
			var clone : Video = new Video();
			
			clone.id 				= this.id;
			clone.blnvalid			= this.blnvalid;
			clone.dt				= this.dt;
			
			clone.location 			= this.location;
			clone.thumbnailLocation = this.thumbnailLocation;
			clone.width				= this.width;
			clone.height			= this.height;
			clone.description		= this.description;
			
			
			clone.alternate			= this.alternate;
			clone.title				= this.title;
			
			clone.scale				= this.scale;
			clone.rotation			= this.rotation;
			clone.offsetX			= this.offsetX;
			clone.offsetY			= this.offsetY;
			clone.offsetSeconds				= this.offsetSeconds;
			
			return clone;
		}
	}
}