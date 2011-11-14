package com.hphant.contentlibrary.control.event
{
	import com.hphant.remoting.GeneralEvent;
	

	public class PDFEvent extends GeneralEvent
	{
		
		public static const ADD_PDF				: String = "add_PDF";
		public static const UPDATE_PDF			: String = "update_PDF";
		public static const REMOVE_PDF			: String = "remove_PDF";
		public static const GET_ALL_PDFS		: String = "get_all_PDFs";
		public static const GET_PDF_BY_ID		: String = "get_PDF_by_id";
		
		public function PDFEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}