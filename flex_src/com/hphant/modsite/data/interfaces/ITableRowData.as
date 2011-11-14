package com.hphant.modsite.data.interfaces
{
	import flash.events.IEventDispatcher;

	public interface ITableRowData extends IEventDispatcher
	{
		function get row():XML;
		function set row(value:XML):void;
	}
}