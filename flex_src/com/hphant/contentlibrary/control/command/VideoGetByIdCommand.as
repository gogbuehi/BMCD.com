package com.hphant.contentlibrary.control.command
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.hphant.contentlibrary.control.*;
	import com.hphant.contentlibrary.control.delegate.*;
	import com.hphant.contentlibrary.control.event.*;
	import com.hphant.remoting.BaseServiceCommand;
	
	import mx.rpc.events.ResultEvent;
	

	public class VideoGetByIdCommand extends BaseServiceCommand
	{
		private var modelLocator : ContentModelLocator = ContentModelLocator.getInstance();


		override public function execute(event:CairngormEvent):void
		{
			log(this + ".execute(): inside...");
			
			//	storing original event for callbacks 
			evt = event as VideoEvent;
			 
			var delegate : VideoDelegate = new VideoDelegate(this);
			delegate.getById( modelLocator.sessionKey, evt.data );
		}

		override public function onResult(event:ResultEvent):void
		{
 			//trace( "event.result: " + event.result );
 			
			var res : Array;
			res = event.result as Array;
			log("RESULT: "+res);
			
			modelLocator.selectedVideo = res[0];

			resultToResponder( event.result );
		}
	}
}