package com.hphant.data.control.command
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.hphant.data.control.*;
	import com.hphant.data.control.delegate.*;
	import com.hphant.data.control.event.*;
	import com.hphant.remoting.BaseServiceCommand;
	
	import mx.collections.ArrayCollection;
	import mx.rpc.events.ResultEvent;
	

	public class CalendarGetAllCommand extends BaseServiceCommand
	{
		private var modelLocator : DataModelLocator = DataModelLocator.getInstance();
		
		
		override public function execute(event:CairngormEvent):void
		{
			log(this + ".execute(): inside...");
			
			//	storing original event for callbacks 
			evt = event as CalendarEvent;

			log("Calendar: " + evt.data);
			var delegate : CalendarDelegate = new CalendarDelegate(this);
			delegate.getAll( modelLocator.sessionKey );
		}
		
		override public function onResult(event:ResultEvent):void
		{
 			//trace( "event.result: " + event.result );
 			
			var res : Array;
			res = event.result as Array;
			log("RESULT: "+res);
			modelLocator.calendar = new ArrayCollection( res.reverse() );

			resultToResponder( event.result );
		}
		
	}
}