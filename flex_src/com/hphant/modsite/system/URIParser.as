package com.hphant.modsite.system
{
	import com.hphant.modsite.system.events.URIParserEvent;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IEventDispatcher;
	
	[Event(name="parseError",type="hphant.events.URLParserEvent")]
	[Event(name="parseComplete",type="hphant.events.URLParserEvent")]
	public class URIParser extends Object implements IEventDispatcher
	{
		private var _dispatcher:EventDispatcher;
		private var _result:URIParse;
		public function URIParser()
		{
			super();
			this._result = null;
			this._dispatcher = new EventDispatcher(this);
		}
		public function parse(uri:String):void{
			var split:Array = uri.split("/");
			if(split.length==1){
				this.dispatchEvent(new URIParserEvent(URIParserEvent.PARSE_ERROR,false,"Incorrect URI Format"));
				return;
			}
			this._result = new URIParse(String(split[1]),String(split[2]),String(split[3]),String(split[4]),String(split[5]));
			this.dispatchEvent(new URIParserEvent(URIParserEvent.PARSE_COMPLETE,true));
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
		
	}
}