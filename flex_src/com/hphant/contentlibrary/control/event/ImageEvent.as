package com.hphant.contentlibrary.control.event
{
	import com.hphant.remoting.GeneralEvent;


	public class ImageEvent extends GeneralEvent
	{
		
		public static const ADD_MASTER_IMAGE		: String = "add_master_image";
		public static const UPDATE_MASTER_IMAGE		: String = "update_master_image";
		public static const REMOVE_MASTER_IMAGE		: String = "remove_master_image";
		public static const GET_ALL_MASTERS			: String = "get_all_masters";
		public static const GET_MASTER_BY_ID		: String = "get_master_by_id";
		
		
		public function ImageEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}