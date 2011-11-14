package com.hphant.modsite.site.assets.calendar.events
{
	import flash.events.Event;

	public class CalendarMonthEvent extends Event
	{
		public static const MONTH_CREATED:String = "CalendarMonthEvent_MonthCreated";
		public function CalendarMonthEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}