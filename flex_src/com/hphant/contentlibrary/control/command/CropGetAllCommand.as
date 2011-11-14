package com.hphant.contentlibrary.control.command
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.hphant.contentlibrary.control.*;
	import com.hphant.contentlibrary.control.delegate.*;
	import com.hphant.contentlibrary.control.event.*;
	import com.hphant.remoting.BaseServiceCommand;
	
	import mx.collections.ArrayCollection;
	import mx.rpc.events.ResultEvent;
	

	public class CropGetAllCommand extends BaseServiceCommand
	{
		private var modelLocator : ContentModelLocator = ContentModelLocator.getInstance();


		override public function execute(event:CairngormEvent):void
		{
			log(this + ".execute(): inside...");
			
			//	storing original event for callbacks 
			evt = event as CropEvent;
			
			var delegate : CropDelegate = new CropDelegate(this);
			delegate.getAllCrops( modelLocator.sessionKey );
		}

		override public function onResult(event:ResultEvent):void
		{
 			var res : Array;
			res = event.result as Array;
			log("result: "+res);
			
			modelLocator.crops = new ArrayCollection( res.reverse() );

			resultToResponder( event.result );
		}

	}
}