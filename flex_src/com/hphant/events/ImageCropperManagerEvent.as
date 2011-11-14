package com.hphant.events
{
	import com.hphant.utils.Logger;
	
	import flash.events.Event;

	public class ImageCropperManagerEvent extends Event
	{
		
		public static const MASTER_SELECTED 				: String = "masterSelected";
		public static const MASTER_UPLOAD_START 			: String = "masterUploadStart";
		public static const MASTER_UPLOAD_ERROR 			: String = "masterUploadError";
		public static const MASTER_UPLOAD_COMPLETE 			: String = "masterUploadComplete";
		public static const MASTER_LOAD_START 				: String = "masterLoadStart";
		public static const MASTER_LOAD_ERROR 				: String = "masterLoadError";
		public static const MASTER_LOAD_COMPLETE 			: String = "masterLoadComplete";
		public static const CROP_READY 						: String = "cropReady";
		public static const CROP_UPLOAD_STARTED 			: String = "cropUploadStarted";
		public static const CROP_UPLOAD_ERROR 				: String = "cropUploadError";
		public static const CROP_UPLOAD_COMPLETE 			: String = "cropUploadComplete";

		
		private var _imageCropperInfo:Object = new Object();
		
		
		
		public function ImageCropperManagerEvent(type:String,bubbles:Boolean = false, 
									cancelable:Boolean = false)
		{
			super(type,bubbles,cancelable);
			Logger.log("[ImageCropperManagerEvent] "+type+" event created.");
		}	
	}
}	
