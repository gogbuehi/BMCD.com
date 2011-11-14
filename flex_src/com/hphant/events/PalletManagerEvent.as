package com.hphant.events
{
	import com.hphant.components.containers.Pallet;
	
	import flash.events.Event;

	public class PalletManagerEvent extends Event
	{
		public function PalletManagerEvent(type:String, pallet:Pallet, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			this._pallet = pallet;
		}
		private var _pallet:Pallet;
		public function get pallet():Pallet{
			return this._pallet;
		}
		public static const CLOSE:String = "close";
		public static const START_DRAG:String = "startDrag";
		public static const STOP_DRAG:String = "stopDrag";
	}
}