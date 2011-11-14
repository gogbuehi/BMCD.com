package com.hphant.events
{
	import com.hphant.utils.Logger;
	
	import flash.events.Event;

	public class PDFUploadManagerEvent extends Event
	{
		
		public static const PDF_SELECTED 				: String = "pdfSelected";
		public static const PDF_UPLOAD_START 			: String = "pdfUploadStart";
		public static const PDF_UPLOAD_ERROR 			: String = "pdfUploadError";
		public static const PDF_UPLOAD_COMPLETE 			: String = "pdfUploadComplete";

		
		public function PDFUploadManagerEvent(type:String,bubbles:Boolean = false, 
									cancelable:Boolean = false)
		{
			super(type,bubbles,cancelable);
			Logger.log("[PDFUploadManagerEvent] "+type+" event created.");
		}	
	}
}	
