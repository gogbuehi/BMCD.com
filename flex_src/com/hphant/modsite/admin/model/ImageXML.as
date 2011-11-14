package com.hphant.modsite.admin.model
{
	import flash.events.EventDispatcher;
	[Bindable]
	public class ImageXML extends EventDispatcher
	{
		public function ImageXML()
		{
			super();
		}
		
		public var source:String;	
		public var link:String;
		public var alternat:String;
		public var height:String;
		public var width:String;
		public var text:String;
		public var title:String;
		
		
		public function toXMLString():String{
			var xml:String = link ? '<a href="'+link+'">' : "";
			xml += '<img src="'+source+'"'+
						(width ? ' width="'+width+'"' : '')+
						(height ? ' height="'+height+'"' : '')+
						(alternat ? ' alt="'+alternat+'"' : '')+
						(title ? ' title="'+title+'"' : '')+' />';
			xml += link ? '</a>' : '';
			xml += text ? '<p>'+text+'</p>' : '';
			return xml;
		}
		public function parse(xml:XMLList):void{
			source = null;
			link = null;
			alternat = "";
			height = null;
			width = null;
			text = "";
			title = "";
			for each (var node:XML in xml){
				if(node.nodeKind()=="element"){
					if(node.name().localName=="a" && !link){
						link = node.@href;
						getImgAtts(XML(node.img));
					} else if(node.name().localName=="img" && !source){
						getImgAtts(node);
					} else if(node.name().localName=="p"){
						if(!text){
							text = "";
						}
						text += ((text>"") ? " " : "" )+node.children().toXMLString();
					}
				}
			}
		}
		private function getImgAtts(node:XML):void{
			source = node.@src;
			width = node.@width;
			height = node.@height;
			alternat = node.@alt;
			title = node.@title;
		}
	}
}