package com.hphant.modsite.system
{
	import com.hphant.modsite.system.events.URIRequesterEvent;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IEventDispatcher;
	import flash.external.ExternalInterface;
	[Event(name="requestMade",type="com.hphant.modsite.system.events.URLRequesterEvent")]
	[Event(name="requestError",type="com.hphant.modsite.system.events.URLRequesterEvent")]
	[Event(name="requestReceived",type="com.hphant.modsite.system.events.URLRequesterEvent")]
	public class URIRequester extends Object implements IEventDispatcher
	{
		private var _dispatcher:EventDispatcher;
		public function URIRequester()
		{
			super();
			this._dispatcher = new EventDispatcher(this);
			ExternalInterface.addCallback("getPageCallback",this.request);
			ExternalInterface.addCallback("getPageCallbackError",this.error);
			ExternalInterface.addCallback("setPageCallback",this.request);
			ExternalInterface.addCallback("setPageCallbackError",this.error);
		}
		private function request(uri:String,page:Object):void{
			var p:String = (page is String) ? String(page) : page.page;
			var s:Array = (page is String) ? [] :(page.supplemental || page.suplimental);
			try{
				var xml:XML = new XML(p);
				log("URIRequest Received : "+uri);//+" : " +xml.toXMLString());
				this.dispatchEvent(new URIRequesterEvent(URIRequesterEvent.REQUEST_RECEIVED,uri,p,s,true));
			} catch(e:Error){
				var message:String = e.message+": \n===================================\n"+p+"\n===================================\n";
				this.error(uri,message);
			}
		}
		private function error(uri:String,message:String):void{
			log("URIRequest Error : "+uri+" : " +message,1);
			this.dispatchEvent(new URIRequesterEvent(URIRequesterEvent.REQUEST_ERROR,uri,message,[],false));
		}
		public function addEventListener(type:String, listener:Function, useCapture:Boolean=false, priority:int=0, useWeakReference:Boolean=false):void
		{ this._dispatcher.addEventListener(type,listener,useCapture,priority,useWeakReference);
		}
		
		public function removeEventListener(type:String, listener:Function, useCapture:Boolean=false):void
		{ this._dispatcher.removeEventListener(type,listener,useCapture);
		}
		
		public function dispatchEvent(event:Event):Boolean
		{
			return this._dispatcher.dispatchEvent(event);
		}
		
		public function hasEventListener(type:String):Boolean
		{
			return this._dispatcher.hasEventListener(type);
		}
		
		public function willTrigger(type:String):Boolean
		{
			return this._dispatcher.willTrigger(type);
		}
		
		private function log(message:Object,level:int=0):void{
			// Logger.log("[URIRequester]"+String(message),level);
		}
	}
}