package com.hphant.modsite.system
{
	import com.hphant.modsite.system.interfaces.ICSSLoader;
	import com.hphant.utils.Logger;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IEventDispatcher;
	import flash.events.IOErrorEvent;
	import flash.events.ProgressEvent;
	import flash.utils.getDefinitionByName;
	
	import mx.events.StyleEvent;
	import mx.styles.CSSStyleDeclaration;
	import mx.styles.StyleManager;
	[Event(name="complete",type="flash.events.Event")]
	[Event(name="ioError",type="flash.events.IOErrorEvent")]
	[Event(name="progress",type="flash.events.ProgressEvent")]
	public class CSSLoader extends Object implements ICSSLoader
	{
		private var _url:String;
		private var _dispatcher:EventDispatcher
		public function CSSLoader()
		{
			super();
			this._dispatcher = new EventDispatcher(this);
		}
		private static var _instance:CSSLoader;
		public static function getInstance():CSSLoader{
			if(!_instance){
				Logger.log("CSS loader instance created");
				_instance= new CSSLoader();
			}
			return _instance;
		}
		private function loadProgress(e:StyleEvent):void{
			log("CSS load progress : loaded="+e.bytesLoaded+" : total="+e.bytesTotal);
			this.dispatchEvent(new ProgressEvent(ProgressEvent.PROGRESS,false,false,e.bytesLoaded,e.bytesTotal));
		}
		private function loadError(e:StyleEvent):void{
			log("CSS load Failed : "+e.errorText,3);
			this.dispatchEvent(new IOErrorEvent(IOErrorEvent.IO_ERROR,false,false,e.errorText));
		}
		private function loadComplete(e:StyleEvent):void{
			/* for(var i:uint=0;i<StyleManager.selectors.length;i++){
				var style:CSSStyleDeclaration = StyleManager.getStyleDeclaration(String(StyleManager.selectors[i]));
				try{
					var cls:Class = flash.utils.getDefinitionByName(String(StyleManager.selectors[i])) as Class;
					if(cls){
						cls.logging = style.getStyle('logging');
					}
				} catch (e:Error){
					Logger.log("CSS not able to set logging for "+StyleManager.selectors[i] +" : "+e.message);
				}
			} */
			log("CSS load Complete");
			this.dispatchEvent(new Event(Event.COMPLETE));
		}
		public function set url(value:String):void{
			log("CSS load started from "+value);
			var e:IEventDispatcher = StyleManager.loadStyleDeclarations(value,true,true);
				e.addEventListener(StyleEvent.COMPLETE,this.loadComplete);
				e.addEventListener(StyleEvent.ERROR,this.loadError);
				e.addEventListener(StyleEvent.PROGRESS,this.loadProgress);
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
			// Logger.log(this+" "+String(message),level);
		}
		
	}
}