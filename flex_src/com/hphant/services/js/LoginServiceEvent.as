package com.hphant.services.js
{
	import flash.events.Event;

	public class LoginServiceEvent extends Event
	{
		public function LoginServiceEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		public static const LOGIN:String = "login";
	}
}