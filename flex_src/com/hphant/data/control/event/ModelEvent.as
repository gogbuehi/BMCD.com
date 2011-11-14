package com.hphant.data.control.event
{
	import com.hphant.remoting.GeneralEvent;
	

	public class ModelEvent extends GeneralEvent
	{
		
		public static const ADD_NEW			: String = "addNewModelRecord";
		public static const UPDATE			: String = "updateModelRecord";
		public static const REMOVE			: String = "removeModelRecord";
		public static const GET_ALL			: String = "getAllModelRecords";
		public static const GET_BY_ID		: String = "getModelRecordByID";
		public static const GET_BY_MODEL		: String = "getModelRecordByModel";
		
		public function ModelEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}