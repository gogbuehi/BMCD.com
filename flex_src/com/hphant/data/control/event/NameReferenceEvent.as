package com.hphant.data.control.event
{
	import com.hphant.remoting.GeneralEvent;
	

	public class NameReferenceEvent extends GeneralEvent
	{
		
		public static const ADD_NEW			: String = "addNewNameReferenceRecord";
		public static const UPDATE			: String = "updateNameReferenceRecord";
		public static const REMOVE			: String = "removeNameReferenceRecord";
		public static const GET_ALL			: String = "getAllNameReferenceRecords";
		public static const GET_BY_ID		: String = "getNameReferenceRecordByID";
		
		public function NameReferenceEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}