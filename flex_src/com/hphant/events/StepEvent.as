package com.hphant.events
{
	import flash.events.Event;

	public class StepEvent extends Event
	{
		public function StepEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		public static const EXECUTE:String = "execute";
	}
}