package com.hphant.data.control.command
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.hphant.data.control.*;
	import com.hphant.data.control.delegate.*;
	import com.hphant.data.control.event.*;
	import com.hphant.remoting.BaseServiceCommand;
	
	import mx.collections.ArrayCollection;
	import mx.rpc.events.ResultEvent;
	

	public class InventoryAddNewCommand extends BaseServiceCommand
	{
		private var modelLocator : DataModelLocator = DataModelLocator.getInstance();
		
		
		override public function execute(event:CairngormEvent):void
		{
			log(this + ".execute(): inside...");
			
			//	storing original event for callbacks 
			evt = event as InventoryEvent;

			log("Inventory: " + evt.data);
			var delegate : InventoryDelegate = new InventoryDelegate(this);
			delegate.add( modelLocator.sessionKey, evt.data );
		}
		public override function onResult(event:ResultEvent):void{
			super.onResult(event);
			var cevt:InventoryEvent = new InventoryEvent(InventoryEvent.GET_ALL);
			cevt.dispatch();
		}
		
		
	}
}