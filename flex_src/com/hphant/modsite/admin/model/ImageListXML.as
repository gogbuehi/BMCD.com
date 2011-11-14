package com.hphant.modsite.admin.model
{
	import flash.events.Event;
	import flash.events.EventDispatcher;
	
	public class ImageListXML extends EventDispatcher
	{
		public function ImageListXML()
		{
			super(this);
		}
		[ArrayElementType("com.hphant.modsite.admin.model.ImageXML")]
		[Bindable(event="imagesChanged")]
		public var images:Array = new Array();
		[Bindable]
		public var listType:String = "ul";
		[Bindable]
		public var liClass:String = "Image";
		public function addImage(image:ImageXML):void{
			images.push(image);
			this.dispatchEvent(new Event("imagesChanged"));
		}
		public function parse(xml:XMLList):void{
			images = new Array();
			listType = null;
			var image:ImageXML = new ImageXML();
			for each(var node:XML in xml){
				if(node.nodeKind()=="element"){
				if(!listType && (node.name().localName=="ul" || node.name().localName=="ol")){
					listType = node.name().localName;
					for each(var li:XML in node.li){
						image = new ImageXML();
						liClass = li.@['class'];
						image.parse(li.children());
						this.addImage(image);
					}
				} else if(node.name().localName=="li"){
					liClass = node.@['class'];
					image = new ImageXML();
					image.parse(node.children());
					this.addImage(image);
				}
				}
			}
		}
		public function toXMLString():String{
			var xml:String = '';//'<'+listType+'>';
			for each (var image:ImageXML in images){
				xml += '<li class="'+this.liClass+'">'+image.toXMLString()+'</li>'; 
			}
			//xml += '</'+listType+'>';
			return xml;
		}
	}
}