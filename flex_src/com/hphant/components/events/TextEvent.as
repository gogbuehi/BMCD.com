package com.hphant.components.events
{
	import flash.events.Event;

	public class TextEvent extends Event
	{
		public function TextEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		public static const TEXT_CHANGE:String = "textChange";
	}
}