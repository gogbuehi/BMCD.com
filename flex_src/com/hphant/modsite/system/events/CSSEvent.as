package com.hphant.modsite.system.events
{
	import flash.events.Event;

	public class CSSEvent extends Event
	{
		public static const CSS_COMPLETE:String = "CSSEvent_Complete";
		public static const CSS_CHANGED:String = "CSSEvent_Changed";
		public function CSSEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}