package com.hphant.contentlibrary.control
{
	import com.adobe.cairngorm.business.ServiceLocator;
	
	import flash.events.EventDispatcher;
	
	import mx.rpc.remoting.RemoteObject;
	
	public class ContentServices extends EventDispatcher
	{
		public function ContentServices(){
			super(this);
			if(_instance){
				throw new Error("Only one ContentServices is allowed. use getInstance().");
			}
			var serviceLocator:ServiceLocator = ServiceLocator.getInstance();
			for each(var info:Object in servicesInfo){
				var rObject:RemoteObject = serviceLocator.getRemoteObject(info.id);
				rObject.source = info.source;
				rObject.destination = info.destination;
			}
		}
		public static function getInstance():ContentServices{
			if(!_instance){
				_instance = new ContentServices();
			}
			return _instance;
		}
		
		private static var _instance:ContentServices;
		private static const servicesInfo:Array = [
			{id:"mastersManager",		destination:"PHPServices",		source:"MastersService"},
			{id:"cropsManager",			destination:"PHPServices",		source:"CropsService"},
			{id:"pdfManager",			destination:"PHPServices",		source:"PDFService"},
			{id:"videoManager",			destination:"PHPServices",		source:"VideoService"}
		]
	}
}