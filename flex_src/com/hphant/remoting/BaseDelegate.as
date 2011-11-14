package com.hphant.remoting
{
	import com.adobe.cairngorm.business.ServiceLocator;
	import com.hphant.utils.Logger;
	
	import mx.rpc.AsyncToken;
	import mx.rpc.Responder;
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;
	import mx.rpc.remoting.RemoteObject;


	/**
	 * 	This is a base 'abstract' class for all delegates aimed at calling back-end services.
	 * 	Should be extended by particular delegates. 
	 */
	public class BaseDelegate
	{

		protected var command:IServiceCommand;
		protected var manager:RemoteObject;
		public var className:String;
		
		public function BaseDelegate( pCommand:IServiceCommand, serviceID:String ) {
			command = pCommand;
			className = "BaseDelegate";
			manager = ServiceLocator.getInstance().getRemoteObject( serviceID );
		}
		
		protected function handleResult(pEvent:ResultEvent):void {
			command.onResult(pEvent);
			command = null;			
		}
		
		protected function handleFault(pEvent:FaultEvent):void {
			command.onFault(pEvent);
			command = null;
		}

		protected function registerCallbacks( asyncToken : AsyncToken ):void {
			asyncToken.addResponder( new Responder(handleResult, handleFault) );
		}
		protected function log(message:Object,level:uint=0):void{
			Logger.log("["+this.className+"} "+message,level);
		}
	}
}