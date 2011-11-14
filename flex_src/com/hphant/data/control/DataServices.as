package com.hphant.data.control
{
	import com.adobe.cairngorm.business.ServiceLocator;
	
	import flash.events.EventDispatcher;
	
	import mx.rpc.remoting.RemoteObject;
	
	public class DataServices extends EventDispatcher
	{
		public function DataServices(){
			super(this);
			if(_instance){
				throw new Error("Only one DataServices is allowed. use getInstance().");
			}
			var serviceLocator:ServiceLocator = ServiceLocator.getInstance();
			for each(var info:Object in servicesInfo){
				var rObject:RemoteObject = serviceLocator.getRemoteObject(info.id);
				rObject.source = info.source;
				rObject.destination = info.destination;
			}
		}
		public static function getInstance():DataServices{
			if(!_instance){
				_instance = new DataServices();
			}
			return _instance;
		}
		
		private static var _instance:DataServices;
		private static const servicesInfo:Array = [
			{id:"inventoryManager",		destination:"PHPServices",		source:"InventoryService"},
			{id:"modelManager",			destination:"PHPServices",		source:"ModelService"},
			{id:"storeManager",			destination:"PHPServices",		source:"StoreService"},
			{id:"calendarManager",		destination:"PHPServices",		source:"CalendarService"},
			{id:"suggestionManager",	destination:"PHPServices",		source:"SuggestionsService"},
			{id:"nameReferenceManager",	destination:"PHPServices",		source:"NameReferenceService"}
			{id:"dataFilterManager",	destination:"PHPServices",		source:"DataFilterService"} 
		]
	}
}