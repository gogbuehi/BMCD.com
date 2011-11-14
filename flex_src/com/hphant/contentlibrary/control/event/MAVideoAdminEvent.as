package com.hphant.contentlibrary.control.event
{
	import flash.events.Event;

	public class MAVideoAdminEvent extends Event
	{
		public static const CHANGE_VIDEO	: String = "change_video";
		public static const NEW_VIDEO		: String = "new_video";


		public function MAVideoAdminEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}