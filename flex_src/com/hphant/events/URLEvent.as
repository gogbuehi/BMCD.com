package com.hphant.events
{
	import flash.display.InteractiveObject;
	import flash.events.Event;

	public class URLEvent extends Event
	{
		public function URLEvent(type:String, data:Object=null, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			this._data = data;
		}
		private var _data:Object;
		public function get data():Object{
			return this._data;
		}
		public function set data(value:Object):void{
			this._data = value;
		}
		public static const URL_SELECT:String = "urlSelect";
	}
}