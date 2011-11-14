package com.hphant.utils
{
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.external.ExternalInterface;
	[Event(name="change",type="flash.events.Event")]
	public class BrowserScrollController extends EventDispatcher
	{
		private static var _instance:BrowserScrollController;
		public function BrowserScrollController()
		{
			super(this);
			if(_instance){
				throw new Error("Only one instance of Scroll Manager allowed. Use BrowserScrollController.getInstance()");
			}
			ExternalInterface.addCallback('setScrollPositionCallback',setScrollPositionCallback);
		}
		public static function getInstance():BrowserScrollController{
			if(!_instance){
				_instance = new BrowserScrollController();
			}
			return _instance;
		}
		public function setVScrollPosition(value:Number):void{
			ExternalInterface.call("setVScrollPosition",value);
		}
		public function setHScrollPosition(value:Number):void{
			ExternalInterface.call("setHScrollPosition",value);
		}
		private function setScrollPositionCallback(x:Number,y:Number,width:Number,height:Number):void{
			this._vscroll = y;
			this._hscroll = x;
			this._w = width;
			this._h = height;
			this.dispatchEvent(new Event(Event.CHANGE));
		}
		private var _hscroll:Number = 0;
		private var _vscroll:Number = 0;
		private var _w:Number = 0;
		private var _h:Number = 0;
		
		[Bindable]
		public function get horizontal():Number{return this._hscroll;}
		public function set horizontal(value:Number):void{
			this._hscroll = value;
			this.setHScrollPosition(value);
		}
		
		[Bindable]
		public function get vertical():Number{return this._vscroll;}
		public function set vertical(value:Number):void{
			this._vscroll = value;
			this.setVScrollPosition(value);
		}
		
		[Bindable]
		public function get width():Number{return this._w;}
		public function set width(value:Number):void{
			this._w = value;
			this.dispatchEvent(new Event(Event.CHANGE));
		}
		
		[Bindable]
		public function get height():Number{return this._h;}
		public function set height(value:Number):void{
			this._h = value;
			this.dispatchEvent(new Event(Event.CHANGE));
		}
	}
}