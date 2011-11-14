package com.hphant.components.events
{
	import flash.events.Event;

	public class PalletEvent extends Event
	{
		public function PalletEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		public static const CLOSE:String = "close";
		public static const OPEN:String = "open";
		public static const START_DRAG:String = "startDrag";
		public static const STOP_DRAG:String = "stopDrag";
		public static const PALLET_CLICK:String = "palletClick";
		
	}
}