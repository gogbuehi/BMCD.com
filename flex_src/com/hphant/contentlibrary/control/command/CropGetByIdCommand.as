package com.hphant.contentlibrary.control.command
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.hphant.contentlibrary.control.*;
	import com.hphant.contentlibrary.control.delegate.*;
	import com.hphant.contentlibrary.control.event.*;
	import com.hphant.contentlibrary.model.Crop;
	import com.hphant.remoting.BaseServiceCommand;
	
	import mx.rpc.events.ResultEvent;
	

	public class CropGetByIdCommand extends BaseServiceCommand
	{
		private var modelLocator : ContentModelLocator = ContentModelLocator.getInstance();


		override public function execute(event:CairngormEvent):void
		{
			log(this + ".execute(): inside...");
			
			//	storing original event for callbacks 
			evt = event as CropEvent;
			
			var delegate : CropDelegate = new CropDelegate(this);
			delegate.getCropById( modelLocator.sessionKey,int(evt.data) );
		}

		override public function onResult(event:ResultEvent):void
		{
 			modelLocator.selectedCrop = Crop( event.result );
			log("result: "+event.result);
			resultToResponder( event.result );
		}

	}
}