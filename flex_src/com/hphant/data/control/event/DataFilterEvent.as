package com.hphant.data.control.event
{
	import com.hphant.remoting.GeneralEvent;
	

	public class DataFilterEvent extends GeneralEvent
	{
		
		public static const ADD_NEW			: String = "addNewDataFilterRecord";
		public static const UPDATE			: String = "updateDataFilterRecord";
		public static const REMOVE			: String = "removeDataFilterRecord";
		public static const GET_ALL			: String = "getAllDataFilterRecords";
		public static const GET_BY_ID		: String = "getDataFilterRecordByID";
		
		public function DataFilterEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}