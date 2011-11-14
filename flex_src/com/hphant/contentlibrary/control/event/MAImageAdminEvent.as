package com.hphant.contentlibrary.control.event
{
	import flash.events.Event;

	public class MAImageAdminEvent extends Event
	{

		public static const CHANGE_PHOTO	: String = "change_photo";
		public static const ADD_PHOTO		: String = "add_photo";
		public static const EDIT_PHOTO		: String = "edit_photo";


		/**
		 * 	Member properties.
		 */		
		public var imageInfo : Object;/* format:
	
//	From "ContentLibraryInterfacing" at http://docs.google.com/Doc?id=dfj77dph_59cqfwz3hg
	
    public function get/set     imageInfo:Object        = null;
    
 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++    
    targetModClass:String                          = required;
                 //currentPhotoName:String      = required;
                //thumbName:String               = null;
                    --> new variables below will streamline the lookup process.<---
                new: cropID:Int                            = -1;
                new: masterID:Int                          = -1;
                imageBoxW:Number                       = -1;
                imageBoxH:Number                        = -1;
                imageBoxMaxH:Number                  = -1;
                imageBoxMaxW:Number                  = -1;
                imageBoxMinH:Number                   = -1;
                imageBoxMinW:Number                   = -1;
 ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++    
    targetModClass:String                          = required;
                currentPhotoName:String      = required;
                imageBoxW:Number            = required;
                imageBoxH:Number             = required;
                imageBoxMaxH:Number                        = null;
                imageBoxMaxW:Number       = null;
                imageBoxMinH:Number         = null;
                imageBoxMinW:Number        = null;
                thumbName:String               = null;
*/
		
		public function MAImageAdminEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}