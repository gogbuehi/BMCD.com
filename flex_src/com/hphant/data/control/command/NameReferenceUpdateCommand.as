package com.hphant.data.control.command
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.hphant.data.control.*;
	import com.hphant.data.control.delegate.*;
	import com.hphant.data.control.event.*;
	import com.hphant.remoting.BaseServiceCommand;
	
	import mx.collections.ArrayCollection;
	import mx.rpc.events.ResultEvent;
	

	public class NameReferenceUpdateCommand extends BaseServiceCommand
	{
		private var modelLocator : DataModelLocator = DataModelLocator.getInstance();
		
		
		override public function execute(event:CairngormEvent):void
		{
			log(this + ".execute(): inside...");
			
			//	storing original event for callbacks 
			evt = event as NameReferenceEvent;

			log("NameReference: " + evt.data);
			var delegate :NameReferenceDelegate = new NameReferenceDelegate(this);
			delegate.update( modelLocator.sessionKey, evt.data );
		}
		
		
	}
}