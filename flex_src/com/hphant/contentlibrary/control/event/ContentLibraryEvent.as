package com.hphant.contentlibrary.control.event
{
	import com.hphant.remoting.GeneralEvent;

	public class ContentLibraryEvent extends GeneralEvent
	{
		//	Image events
		public static const IMAGE_SELECTED	: String = "IMAGE_SELECTED";
		public static const IMAGE_CANCELED	: String = "IMAGE_CANCELED";
		//	Video events
		public static const VIDEO_SELECTED	: String = "VIDEO_SELECTED";
		public static const VIDEO_CANCELED	: String = "VIDEO_CANCELED";

		/**
		 * 	Member properties.
		 */		
		public var contentInfo : Object;/* format:
	
//	From "ContentLibraryInterfacing" at http://docs.google.com/Doc?id=dfj77dph_59cqfwz3hg
	
public function get/set      contentInfo:Object        = null;
                contentPath:String         = imagePath;
                contentWidth:Int            = null;
                contentHeight:Int           = null;
                thumbPath:String           = thumbPath;
*/
		
		
		public function ContentLibraryEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}