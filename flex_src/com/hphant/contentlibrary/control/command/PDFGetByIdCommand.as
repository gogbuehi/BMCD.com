package com.hphant.contentlibrary.control.command
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.hphant.contentlibrary.control.*;
	import com.hphant.contentlibrary.control.delegate.*;
	import com.hphant.contentlibrary.control.event.*;
	import com.hphant.contentlibrary.model.PDF;
	import com.hphant.remoting.BaseServiceCommand;
	
	import mx.rpc.events.ResultEvent;
	

	public class PDFGetByIdCommand extends BaseServiceCommand
	{
		private var modelLocator : ContentModelLocator = ContentModelLocator.getInstance();


		override public function execute(event:CairngormEvent):void
		{
			log(this + ".execute(): inside...");
			
			//	storing original event for callbacks 
			evt = event as PDFEvent;
			
			var delegate : PDFDelegate = new PDFDelegate(this);
			delegate.getPDFById( modelLocator.sessionKey,int(evt.data) );
		}

		override public function onResult(event:ResultEvent):void
		{
 			modelLocator.selectedPDF = PDF( event.result );
			log("result: "+event.result);
			resultToResponder( event.result );
		}

	}
}