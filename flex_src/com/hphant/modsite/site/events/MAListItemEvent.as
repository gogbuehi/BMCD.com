package com.hphant.modsite.site.events
{
	import flash.events.Event;

	public class MAListItemEvent extends Event
	{
		public static const EXPAND_CLICK:String = "expandClick";
		public static const COLAPSE_CLICK:String = "colapseClick";
		public static const GROUP_EXPAND_CLICK:String = "groupExpandClick";
		public static const GROUP_COLAPSE_CLICK:String = "groupColapseClick";
		
		public function MAListItemEvent(type:String, item:Object, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			this._item = item;
		}
		public function get item():Object{return this._item;}
		private var _item:Object;
		
	}
}