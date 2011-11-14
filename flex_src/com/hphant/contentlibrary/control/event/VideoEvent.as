package com.hphant.contentlibrary.control.event
{
	import com.hphant.remoting.GeneralEvent;
	

	public class VideoEvent extends GeneralEvent
	{
		
		public static const ADD_VIDEO			: String = "add_video";
		public static const UPDATE_VIDEO		: String = "update_video";
		public static const REMOVE_VIDEO		: String = "remove_video";
		public static const GET_ALL_VIDEOS		: String = "get_all_videos";
		public static const GET_VIDEO_BY_ID		: String = "get_video_by_id";
		public static const GET_UPLOADED_FILES	: String = "get_uploaded_videos";
		
		public function VideoEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}