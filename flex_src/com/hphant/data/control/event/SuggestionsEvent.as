package com.hphant.data.control.event
{
	import com.hphant.remoting.GeneralEvent;
	

	public class SuggestionsEvent extends GeneralEvent
	{
		
		public static const ADD_NEW			: String = "addNewSuggestionsRecord";
		public static const UPDATE			: String = "updateSuggestionsRecord";
		public static const REMOVE			: String = "removeSuggestionsRecord";
		public static const GET_ALL			: String = "getAllSuggestionsRecords";
		public static const GET_BY_ID		: String = "getSuggestionsRecordByID";
		
		public function SuggestionsEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}