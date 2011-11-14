package com.hphant.services.js
{
	import flash.events.Event;

	public class JavascriptServiceEvent extends Event
	{
		public function JavascriptServiceEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		public static const ERROR:String = "error";
		public static const SUCCESS:String = "success";
	}
}