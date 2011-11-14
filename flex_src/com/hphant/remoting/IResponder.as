package com.hphant.remoting
{
	import mx.rpc.Fault; 
	
	public interface IResponder
	{
		function handleResult(event:GeneralEvent, result:Object)	: void;
		function handleFault (event:GeneralEvent, fault:Fault)	: void;
	}
}