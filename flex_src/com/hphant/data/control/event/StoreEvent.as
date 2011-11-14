package com.hphant.data.control.event
{
	import com.hphant.remoting.GeneralEvent;
	

	public class StoreEvent extends GeneralEvent
	{
		
		public static const ADD_NEW			: String = "addNewStoreRecord";
		public static const UPDATE			: String = "updateStoreRecord";
		public static const REMOVE			: String = "removeStoreRecord";
		public static const GET_ALL			: String = "getAllStoreRecords";
		public static const GET_BY_ID		: String = "getStoreRecordByID";
		public static const GET_BY_PRODUCT_ID		: String = "getStoreRecordByProductID";
		
		public function StoreEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}