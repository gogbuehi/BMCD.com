package com.hphant.contentlibrary.control.event
{
	import com.hphant.remoting.GeneralEvent;
	

	public class CropEvent extends GeneralEvent
	{
		
		public static const GET_SUGGESTED_CROPS	: String = "get_suggested_crops";
		public static const ADD_CROP			: String = "add_crop";
		public static const UPDATE_CROP			: String = "update_crop";
		public static const REMOVE_CROP			: String = "remove_crop";
		public static const GET_ALL_CROPS		: String = "get_all_crops";
		public static const GET_CROP_BY_ID		: String = "get_crop_by_id";
		
		public function CropEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}