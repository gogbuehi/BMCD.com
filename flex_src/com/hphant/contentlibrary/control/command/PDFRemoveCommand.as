package com.hphant.contentlibrary.control.command
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.hphant.contentlibrary.control.*;
	import com.hphant.contentlibrary.control.delegate.*;
	import com.hphant.contentlibrary.control.event.*;
	import com.hphant.contentlibrary.model.PDF;
	import com.hphant.remoting.BaseServiceCommand;
	
	import mx.rpc.events.ResultEvent;
	

	public class PDFRemoveCommand extends BaseServiceCommand
	{
		private var modelLocator : ContentModelLocator = ContentModelLocator.getInstance();


		override public function execute(event:CairngormEvent):void
		{
			log(this + ".execute(): inside...");
			
			//	storing original event for callbacks 
			evt = event as PDFEvent;
			
			var delegate : PDFDelegate = new PDFDelegate(this);
			delegate.removePDF( modelLocator.sessionKey,PDF(evt.data));
		}
		public override function onResult(event:ResultEvent):void{
			super.onResult(event);
			var cevt:PDFEvent = new PDFEvent(PDFEvent.GET_ALL_PDFS);
			cevt.dispatch();
		}

	}
}