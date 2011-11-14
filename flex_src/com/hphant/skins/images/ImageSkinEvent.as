package com.hphant.skins.images
{
	import flash.events.Event;

	public class ImageSkinEvent extends Event
	{
		public static const NEXT_CLICK:String = "nextClick";
		public static const PREVIOUS_CLICK:String = "previousClick";
		public function ImageSkinEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}