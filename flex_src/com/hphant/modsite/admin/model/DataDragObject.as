package com.hphant.modsite.admin.model
{
	import flash.events.EventDispatcher;
	[Bindable]
	public class DataDragObject extends EventDispatcher
	{
		public function DataDragObject()
		{
			super(this);
		}
		
		public var data:Object;
		public var image:String;
		public var source:String;
		public var label:String;
		public var tr:XML;
	}
}