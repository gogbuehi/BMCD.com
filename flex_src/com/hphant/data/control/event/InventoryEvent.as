package com.hphant.data.control.event
{
	import com.hphant.remoting.GeneralEvent;
	

	public class InventoryEvent extends GeneralEvent
	{
		
		public static const ADD_NEW			: String = "addNewInventoryRecord";
		public static const UPDATE			: String = "updateInventoryRecord";
		public static const REMOVE			: String = "removeInventoryRecord";
		public static const GET_ALL			: String = "getAllInventoryRecords";
		public static const GET_BY_ID		: String = "getInventoryRecordByID";
		public static const GET_BY_VIN		: String = "getInventoryRecordByVIN";
		public static const GET_BY_STOCK	: String = "getInventoryRecordByStock";
		
		public function InventoryEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}