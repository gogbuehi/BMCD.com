package com.hphant.data.control.event
{
	import com.hphant.remoting.GeneralEvent;
	

	public class CalendarEvent extends GeneralEvent
	{
		
		public static const ADD_NEW			: String = "addNewCalendarRecord";
		public static const UPDATE			: String = "updateCalendarRecord";
		public static const REMOVE			: String = "removeCalendarRecord";
		public static const GET_ALL			: String = "getAllCalendarRecords";
		public static const GET_BY_ID		: String = "getCalendarRecordByID";
		public static const GET_BY_DATE		: String = "getCalendarRecordByDate";
		
		public function CalendarEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}