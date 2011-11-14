package com.hphant.modsite.data.interfaces
{
	import flash.events.IEventDispatcher;

	public interface ITableData extends IEventDispatcher
	{
		function get table():XMLList;
		function set table(value:XMLList):void;
		
		
		function get items():Array;
		function set items(value:Array):void;
		
		
		function get urlTemplates():XMLList;
		function set urlTemplates(value:XMLList):void;
	}
}