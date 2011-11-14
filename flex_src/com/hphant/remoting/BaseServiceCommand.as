package com.hphant.remoting
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.hphant.utils.Logger;
	
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;


	/**
	 * 	This is a base 'abstract' class for all service commands.
	 * 	Should be extended by particular command. 
	 */
	public class BaseServiceCommand implements IServiceCommand
	{
		
		/**
		 * 	Original event on which commands was fired.
		 * 	Used for responder's callbacks.
		 * 
		 * 	@see execute(event:CairngormEvent)
		 */
		private var _evt:GeneralEvent;
		protected function get evt() : GeneralEvent{
			return this._evt;
		} 
		protected function set evt(value:GeneralEvent):void{
			log("Storing origional event:");
			log("\tpreviousValue="+this._evt);
			log("\tnewValue="+value);
			this._evt = value;
		}
		
		/**
		 *	To be overriden in successor implementation.
		 */
		public function execute(event:CairngormEvent):void
		{
			log(this + ".execute():  YOU  MUST  OVERRIDE  THIS  METHOD  IN  YOUR  CUSTOM  COMMAND'S  IMPLEMENTATION.\n",1);
			//	storing original event for callbacks 
			evt = event as GeneralEvent;
		}
		
		/**
		 *	To be overriden in successor implementation.
		 */
		public function onResult(event:ResultEvent):void
		{
			log("RESULT: " + event.result+"\n");
			//	mandatory, to hook responder
			resultToResponder( event.result );
		}
		
		public function onFault(event:FaultEvent):void
		{
			log("FAULT:",2);
			log("\t"+event.fault,2);
			log("\t"+event.message+"\n",2);
			//	Pushing to responder
			if (evt && evt.responder) {
				evt.responder.handleFault(evt, event.fault);
			} else {
				log("\t"+(evt ? "No Responder." : "No origional event saved"),2);
			}
		}
		
		protected function resultToResponder( result:Object ):void
		{
			//	Pushing to responder
			if (evt.responder) {
				evt.responder.handleResult(evt, result);
			}
		}
		protected function log(message:Object,level:uint=0):void{
			Logger.log("["+this+"] "+message,level);
		}
	}
}