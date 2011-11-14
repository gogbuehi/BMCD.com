package com.hphant.remoting
{
	import mx.rpc.events.FaultEvent;
	import mx.rpc.events.ResultEvent;
	
	/**
	 * 	This interface aimed for services-calling commands.
	 * 	It mimics mx.rpc.IResponder, just narrowing methods' parameters 
	 * 	from Object to mx.rpc.events.ResultEvent and mx.rpc.events.FaultEvent
	 *  
	 */	
	public interface IServiceCommand extends IGeneralCommand
	{
		
 		function onResult(event : ResultEvent)	: void;
		function onFault (event : FaultEvent)	: void;
		
	}
}