package com.hphant.skins.video
{
	import flash.events.Event;

	public class VideoSkinEvent extends Event
	{
		public static const NEXT_CLICK:String = "nextClick";
		public static const PREVIOUS_CLICK:String = "previousClick";
		public static const SOUND_ON_CLICK:String = "soundOnClick";
		public static const SOUND_OFF_CLICK:String = "soundOffClick";
		public function VideoSkinEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}