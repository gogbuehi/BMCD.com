package com.hphant.contentlibrary.control.command
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.hphant.contentlibrary.control.*;
	import com.hphant.contentlibrary.control.delegate.*;
	import com.hphant.contentlibrary.control.event.*;
	import com.hphant.contentlibrary.model.Crop;
	import com.hphant.remoting.BaseServiceCommand;
	
	import mx.rpc.events.ResultEvent;
	

	public class CropUpdateCommand extends BaseServiceCommand
	{
		private var modelLocator : ContentModelLocator = ContentModelLocator.getInstance();


		override public function execute(event:CairngormEvent):void
		{
			log(this + ".execute(): inside...");
			
			//	storing original event for callbacks 
			evt = event as CropEvent;
			
			var delegate : CropDelegate = new CropDelegate(this);
			delegate.updateCrop( modelLocator.sessionKey,Crop(evt.data));
		}

	}
}