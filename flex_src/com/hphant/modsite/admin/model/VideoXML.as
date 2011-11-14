package com.hphant.modsite.admin.model
{
	import flash.events.EventDispatcher;
	[Bindable]
	public class VideoXML extends EventDispatcher
	{
		public function VideoXML()
		{
			super(this);
		}
		public var source:String;	
		public var link:String;
		public var height:String;
		public var width:String;
		public var text:String;
		public var alternat:String;
		public var title:String;
		
		public function toXMLString():String{
			var xml:String = link ? '<a href="'+link+'">' : "";
			xml += '<embed src="'+source+'"'+
						(width ? ' width="'+width+'"' : '')+
						(height ? ' height="'+height+'"' : '')+
						' type="video/quicktime" pluginspage="http://www.apple.com/quicktime/download/" />';
			xml += link ? '</a>' : '';
			xml += text ? '<p>'+text+'</p>' : '';
			return xml;
		}
		public function parse(xml:XMLList):void{
			source = null;
			link = null;
			height = null;
			width = null;
			text = null;
			for each (var node:XML in xml){
				if(node.name().localName=="a" && !link){
					link = node.@href;
					getImgAtts(XML(node.embed));
				} else if(node.name().localName=="embed" && !source){
					getImgAtts(node);
				} else if(node.name().localName=="p"){
					if(!text){
						text = "";
					}
					text += ((text>"") ? " " : "" )+node.children().toXMLString();
				}
			}
		}
		private function getImgAtts(node:XML):void{
			source = node.@src;
			width = node.@width;
			height = node.@height;
		}
	}
}