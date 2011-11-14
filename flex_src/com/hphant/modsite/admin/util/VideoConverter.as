package com.hphant.modsite.admin.util
{
	import com.hphant.contentlibrary.model.Video;
	import com.hphant.modsite.admin.model.ImageXML;
	import com.hphant.modsite.admin.model.VideoXML;
	
	
	public class VideoConverter
	{
		public function VideoConverter()
		{ throw new Error("VideoConverter is a utillity class and is not to be instantiated.");
		}
		public static function toImageXML(video:Video):ImageXML{
			var imageXML:ImageXML = new ImageXML();
			imageXML.text = video.description;
			imageXML.alternat = video.alternate;
			imageXML.title = video.title;
			imageXML.source = video.location;
			return imageXML;
		}
		public static function toVideoXML(video:Video):VideoXML{
			var imageXML:VideoXML = new VideoXML();
			imageXML.text = video.description;
			imageXML.alternat = video.alternate;
			imageXML.title = video.title;
			imageXML.source = video.location;
			return imageXML;
		}

		public static function toImageListXMLItem(video:Video):ImageXML{
			var imageXML:ImageXML = new ImageXML();
			imageXML.text = video.description;
			imageXML.alternat = video.alternate;
			imageXML.title = video.title;
			imageXML.link = video.location;
			imageXML.source = video.thumbnailLocation;
			return imageXML;
		}
		public static function toImageXMLList(videos:Object):Array{
			var imageXMLs:Array= new Array();
			for each(var video:Video in videos){
				imageXMLs.push(toImageXML(video));
			}
			return imageXMLs;
		}
		public static function toVideoXMLList(videos:Object):Array{
			var imageXMLs:Array= new Array();
			for each(var video:Video in videos){
				imageXMLs.push(toVideoXML(video));
			}
			return imageXMLs;
		}
		public static function toImageListXMLItemList(videos:Object):Array{
			var imageXMLs:Array = new Array();
			for each(var video:Video in videos){
				imageXMLs.push(toImageListXMLItem(video));
			}
			return imageXMLs;
		}
	}
}