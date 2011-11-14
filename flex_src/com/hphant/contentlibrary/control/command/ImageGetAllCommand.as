package com.hphant.contentlibrary.control.command
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.hphant.contentlibrary.control.*;
	import com.hphant.contentlibrary.control.delegate.*;
	import com.hphant.contentlibrary.control.event.*;
	import com.hphant.remoting.BaseServiceCommand;
	
	import mx.collections.ArrayCollection;
	import mx.rpc.events.ResultEvent;
	

	public class ImageGetAllCommand extends BaseServiceCommand
	{
		private var modelLocator : ContentModelLocator = ContentModelLocator.getInstance();


		override public function execute(event:CairngormEvent):void
		{
			log(this + ".execute(): inside...");
			
			//	storing original event for callbacks 
			evt = event as ImageEvent;
			 
			var delegate : ImageDelegate = new ImageDelegate(this);
			delegate.getAllMasters( modelLocator.sessionKey );
		}

		override public function onResult(event:ResultEvent):void
		{
 			//trace( "event.result: " + event.result );
 			
			var res : Array;
			res = event.result as Array;
			log("RESULT: "+res);
			
			modelLocator.masters = new ArrayCollection( res.reverse() );

			resultToResponder( event.result );
		}
	}
}