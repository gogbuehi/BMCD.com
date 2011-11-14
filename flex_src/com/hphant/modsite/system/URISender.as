package com.hphant.modsite.system
{
	import com.hphant.modsite.system.events.URISenderEvent;
	import com.hphant.utils.Logger;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IEventDispatcher;
	import flash.external.ExternalInterface;
	[Event(name="sendComplete",type="com.hphant.modsite.system.events.URISenderEvent")]
	[Event(name="sendError",type="com.hphant.modsite.system.events.URISenderEvent")]
	public class URISender extends Object implements IEventDispatcher
	{
		private var _dispatcher:EventDispatcher;
		public function URISender()
		{
			super();
			this._dispatcher = new EventDispatcher(this);
		}
		public function send(uri:String,data:Object=null,session_id:String="",hasDynamicContent:Boolean=false):void{
			try{
				if(data is String && data!=""){
					log("Session "+session_id+" setting page "+uri+" to:");
					log(data);
					ExternalInterface.call("setPage",uri,data,session_id,hasDynamicContent ? "true" : "false");
					log("page "+uri+" set");
				} else {
					ExternalInterface.call("getPage",uri,data);
				}
			} catch (e:Error){
				this.dispatchEvent(new URISenderEvent(URISenderEvent.SEND_ERROR,e));
				return;
			}
			this.dispatchEvent(new URISenderEvent(URISenderEvent.SEND_COMPLETE));
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
			 Logger.log("[URISender] "+String(message),level);
		}
	}
}