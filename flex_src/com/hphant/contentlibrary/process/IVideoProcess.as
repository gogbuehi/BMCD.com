package com.hphant.contentlibrary.process
{
	import com.hphant.contentlibrary.view.EditVideoPallet;
	
	import flash.events.Event;
	import flash.events.IEventDispatcher;
	
	public interface IVideoProcess extends IEventDispatcher
	{
		function selectStep(event:Event):void;
		function loadStep(event:Event):void;
		function cropStep(event:Event):void;
		function thumbStep(event:Event):void;
		function saveStep(event:Event):void;
		function resetStep(event:Event):void;
		function set pallet(value:EditVideoPallet):void;
		function get pallet():EditVideoPallet;
	}
}