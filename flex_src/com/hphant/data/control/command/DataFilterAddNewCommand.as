package com.hphant.data.control.command
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.hphant.data.control.*;
	import com.hphant.data.control.delegate.*;
	import com.hphant.data.control.event.*;
	import com.hphant.remoting.BaseServiceCommand;
	
	import mx.collections.ArrayCollection;
	import mx.rpc.events.ResultEvent;
	

	public class DataFilterAddNewCommand extends BaseServiceCommand
	{
		private var modelLocator : DataModelLocator = DataModelLocator.getInstance();
		
		
		override public function execute(event:CairngormEvent):void
		{
			log(this + ".execute(): inside...");
			
			//	storing original event for callbacks 
			evt = event as DataFilterEvent;

			log("DataFilter: " + evt.data);
			var delegate : DataFilterDelegate = new DataFilterDelegate(this);
			delegate.add( modelLocator.sessionKey, evt.data );
		}
		public override function onResult(event:ResultEvent):void{
			super.onResult(event);
			var cevt:DataFilterEvent = new DataFilterEvent(DataFilterEvent.GET_ALL);
			cevt.dispatch();
		}
		
		
	}
}