package com.hphant.managers
{
	import com.hphant.components.LinkGenerator;
	import com.hphant.services.LinkGeneratorService;
	
	import flash.events.ErrorEvent;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.utils.Dictionary;
	
	import mx.core.ClassFactory;
	
	[Event(name="complete",type="flash.events.Event")]
	[Event(name="error",type="flash.events.ErrorEvent")]

	public class LinkGeneratorManager extends EventDispatcher
	{
		public function LinkGeneratorManager()
		{
			super(this);
			if(instance){
				throw new Error("Singleton, Call LinkMenuManager.getInstance()");
			}
			this._generator = new LinkGenerator();
			this.addGeneratorService(LinkGeneratorService);
		}
		private static var instance:LinkGeneratorManager;
		private var _generator:LinkGenerator;
		public function get generator():LinkGenerator{
			return this._generator;
		}
		public static function getInstance():LinkGeneratorManager{
			if(!instance){
				instance = new LinkGeneratorManager();
			}
			return instance;
		}
		[Bindable("servicesChanged")]
		[ArrayElementType(name="com.hphant.services.LinkGeneratorService")]
		public function get services():Array{
			return this._services;
		}
		private var _services:Array = [];
		private var _serviceDictionary:Dictionary = new Dictionary();
		public function addGeneratorService(service:Class):void{
			if(!this._serviceDictionary[service]){
				var factory:ClassFactory = new ClassFactory(service);
				var instance:Object = factory.newInstance();
				if(instance is LinkGeneratorService){
					this._serviceDictionary[service] = factory;
					this._services.push(instance);
					LinkGeneratorService(instance).addEventListener(Event.COMPLETE,serviceSuccess);
					LinkGeneratorService(instance).addEventListener(ErrorEvent.ERROR,serviceError);
				}
			}
		}
		[Bindable]
		public var lastGenerated:String = "";
		private function serviceSuccess(event:Event):void{
			this.lastGenerated = LinkGeneratorService(event.currentTarget).lastGenerated;
			this.dispatchEvent(new Event(Event.COMPLETE));
		}
		private function serviceError(event:ErrorEvent):void{
			this.lastGenerated = LinkGeneratorService(event.currentTarget).lastGenerated;
			this.dispatchEvent(new ErrorEvent(ErrorEvent.ERROR));
		}
	}
}