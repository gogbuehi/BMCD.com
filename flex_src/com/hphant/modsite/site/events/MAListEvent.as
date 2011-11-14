package com.hphant.modsite.site.events
{
	import flash.events.Event;

	public class MAListEvent extends Event
	{
		public static const BUILD_COMPLETE:String = "MAListEvent_BuildComplete";
		public static const RESIZE_COMPLETE:String = "resizeComplete";
		public static const RESIZE_BEGIN:String = "resizeBegin";
		public function MAListEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}