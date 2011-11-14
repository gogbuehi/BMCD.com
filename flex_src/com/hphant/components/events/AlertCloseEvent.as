package com.hphant.components.events
{
	import mx.events.CloseEvent;

	public class AlertCloseEvent extends CloseEvent
	{
		public function AlertCloseEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false, detail:int=-1)
		{
			super(type, bubbles, cancelable, detail);
		}
		public static const ALERT_CLOSE:String = "alertClose";
	}
}