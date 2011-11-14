package com.hphant.modsite.site.assets.store.events
{
	import flash.events.Event;

	public class MAStoreEvent extends Event
	{
		public static const SORT_SELECTED:String = "sortSelected";
		public static const FILTER_SELECTED:String = "filterSelected";
		public static const ITEM_SELECTED:String = "itemSelected";
		public static const VIEW_CART:String = "viewCart";
		public static const CLOSE_CART:String = "closeCart";
		public static const SUBMIT_CART:String = "submitCart";
		
		public static const ADD_TO_CART:String = "addToCart";
		public static const REMOVE_FROM_CART:String = "removeFromCart";
		public static const CLEAR_CART:String = "clearCart";
		
		private var _item:XML;
		public function MAStoreEvent(type:String,item:XML,bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			this._item = item;
		}
		public function get item():XML{return this._item;}
		
	}
}