package com.hphant.modsite.admin.model
{
	import flash.events.EventDispatcher;
	import flash.events.IEventDispatcher;
	[Bindable]
	public class VideoListXML extends EventDispatcher
	{
		public function VideoListXML(target:IEventDispatcher=null)
		{
			super(target);
		}
		[ArrayElementType("com.hphant.modsite.admin.model.VideoXML")]
		public var videos:Array = new Array();
		public var listType:String = "ul";
		public var liClass:String = "Video";
		public function addVideo(video:VideoXML):void{
			videos.push(video);
		}
		public function parse(xml:XMLList):void{
			images = new Array();
			listType = null;
			for each(var node:XML in xml){
				if(!listType && (node.name().localName=="ul" || node.name().localName=="ol")){
					listType = node.name().localName;
					for each(var li:XML in node.li){
						liClass = li.@['class'];
						var video:VideoXML = new VideoXML();
						video.parse(li.children());
						this.addVideo(video);
					}
				}
			}
		}
		public function toXMLString():String{
			var xml:String = '<'+listType+'>';
			for each (var video:VideoXML in videos){
				xml += '<li class="'+this.liClass+'">'+video.toXMLString()+'</li>'; 
			}
			xml += '</'+listType+'>';
			return xml;
		}
		public function toString():String{
			
		}
	}
}