package com.hphant.components.events
{
	import flash.events.Event;

	public class ListGroupEvent extends Event
	{
		public static const CLOSED:String = "closed";
		public static const OPENED:String = "opened";
		public static const EXPANDED:String = "expanded";
		
		public function ListGroupEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		
	}
}