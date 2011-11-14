package com.hphant.services
{
	import flash.events.ErrorEvent;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	[Event(name="complete",type="flash.events.Event")]
	[Event(name="error",type="flash.events.ErrorEvent")]
	[Bindable]
	public class LinkGeneratorService extends EventDispatcher
	{
		public function LinkGeneratorService()
		{
			super(this);
		}
		public var label:String = "Choose Data Type";
		public var idLabel:String = "Item ID";
		public var lastGenerated:String = "";
		public function generate(id:Object):void{
			/* this.dispatchEvent(new Event(Event.COMPLETE));
			this.dispatchEvent(new ErrorEvent(ErrorEvent.ERROR)); */
			//ExternalInterface.call("PermissionManager.sendLoginRequest",form.user,form.password,domain);
			errorCallback({message:"generate() needs to be overriden"});
		}
		public function successCallback(callbackObject:Object):void{
			lastGenerated = String(callbackObject.message);
			this.dispatchEvent(new Event(Event.COMPLETE));
		}
		public function errorCallback(callbackObject:Object):void{
			lastGenerated = String(callbackObject.message);
			this.dispatchEvent(new ErrorEvent(ErrorEvent.ERROR));
		}
	}
}