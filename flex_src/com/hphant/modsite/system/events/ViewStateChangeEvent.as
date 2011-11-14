package com.hphant.modsite.system.events
{
	import flash.events.Event;

	public class ViewStateChangeEvent extends Event
	{
		public static const STATE_REACHED:String = "ViewStateChangeEvent_StateReached";
		public static const CHANGE_COMPLETE:String = "ViewStateChangeEvent_ChangeComplete";
		private var _items:Array;
		private var _state:uint = 0;
		public function ViewStateChangeEvent(type:String, state:uint, items:Array=null, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			this._state = state;
			this._items = items;
		}
		public function get state():uint{return this._state;}
		
	}
}