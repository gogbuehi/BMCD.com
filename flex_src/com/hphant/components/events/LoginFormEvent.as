package com.hphant.components.events
{
	import flash.events.Event;

	public class LoginFormEvent extends Event
	{
		public function LoginFormEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		public static const FORGOT:String = "forgot";
	}
}