package com.hphant.modsite.system.interfaces
{
	import flash.events.IEventDispatcher;
	
	public interface IURIManager extends IEventDispatcher
	{
		function goToURI(uri:String,data:Object=null,session_id:String="",hasDynamicContent:Boolean=false):void;
		function get current():String;
		function get enabled():Boolean;
		function set enabled(value:Boolean):void;
	}
}