package com.hphant.contentlibrary.control.command
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.hphant.contentlibrary.control.*;
	import com.hphant.contentlibrary.control.delegate.*;
	import com.hphant.contentlibrary.control.event.*;
	import com.hphant.remoting.BaseServiceCommand;
	
	import mx.rpc.events.ResultEvent;
	
	
	public class ImageRemoveMasterCommand extends BaseServiceCommand
	{
		private var modelLocator : ContentModelLocator = ContentModelLocator.getInstance();


		override public function execute(event:CairngormEvent):void
		{
			log(this + ".execute(): inside...");
			
			//	storing original event for callbacks 
			evt = event as ImageEvent;
			log("Master: " + evt.data);
			var delegate : ImageDelegate = new ImageDelegate(this);
			delegate.removeMaster( modelLocator.sessionKey, evt.data );
		}
		public override function onResult(event:ResultEvent):void{
			super.onResult(event);	
			var cevt:CropEvent = new CropEvent(CropEvent.GET_ALL_CROPS);
			cevt.dispatch();
			var ievt:ImageEvent = new ImageEvent(ImageEvent.GET_ALL_MASTERS);
			ievt.dispatch();
		}
	}
}