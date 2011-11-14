package com.hphant.data.control.command
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.hphant.data.control.*;
	import com.hphant.data.control.delegate.*;
	import com.hphant.data.control.event.*;
	import com.hphant.remoting.BaseServiceCommand;
	
	import mx.collections.ArrayCollection;
	import mx.rpc.events.ResultEvent;
	

	public class ModelGetAllCommand extends BaseServiceCommand
	{
		private var modelLocator : DataModelLocator = DataModelLocator.getInstance();
		
		
		override public function execute(event:CairngormEvent):void
		{
			log(this + ".execute(): inside...");
			
			//	storing original event for callbacks 
			evt = event as ModelEvent;

			log("Models: " + evt.data);
			var delegate : ModelDelegate = new ModelDelegate(this);
			delegate.getAll( modelLocator.sessionKey);
		}
		
		override public function onResult(event:ResultEvent):void
		{
 			//trace( "event.result: " + event.result );
 			
			var res : Array;
			res = event.result as Array;
			log("RESULT: "+res);
			modelLocator.models = new ArrayCollection( res.reverse() );

			resultToResponder( event.result );
		}
		
	}
}