package com.hphant.services.js
{
	import flash.events.Event;

	public class LogoutServiceEvent extends Event
	{
		public function LogoutServiceEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		public static const LOGOUT:String = "logout";
	}
}