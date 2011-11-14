package com.hphant.events
{
	import flash.events.Event;

	public class BrowserScrollEvent extends Event
	{
		public static const CHANGE:String = "change";
		public function BrowserScrollEvent(type:String, width:Number, height:Number, verticle:Number, horizontal:Number, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			_w = width;
			_h = height;
			_v = verticle;
			_hz = horizontal;
		}
		private var _w:Number;
		private var _h:Number;
		private var _v:Number;
		private var _hz:Number;
		
		public function get width():Number{return _w;}
		public function get height():Number{return _h;}
		public function get vertical():Number{return _v;}
		public function get horizontal():Number{return _hz;}
	}
}