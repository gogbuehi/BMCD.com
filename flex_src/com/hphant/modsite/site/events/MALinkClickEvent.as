package com.hphant.modsite.site.events
{
	import flash.events.Event;

	public class MALinkClickEvent extends Event
	{
		public static const LINK_CLICKED:String = "linkClicked";
		public static const BUTTON_CLICKED:String = "buttonClicked";
		private var _item:Object
		public function MALinkClickEvent(type:String, item:Object, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			this._item = item;
		}
		public function get item():Object{return this._item;}
		
	}
}