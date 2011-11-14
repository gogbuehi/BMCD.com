package com.hphant.modsite.site.events
{
	import flash.events.Event;
	
	import mx.core.UIComponent;

	public class SiteBodyDropEvent extends Event
	{
		public static const DROP_COMPLETE:String = "dropComplete";
		public function SiteBodyDropEvent(type:String, dropedObject:Object, dropedOnItem:UIComponent, targetIndex:uint, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			this._doi = dropedOnItem;
			this._do = dropedObject;
			this._idx = targetIndex;
		}
		public function get dropedOnItem():UIComponent{
			return this._doi;
		}
		private var _doi:UIComponent;
		
		public function get dropedObject():Object{
			return this._do;
		}
		private var _do:Object;
		
		public function get targetIndex():uint{
			return this._idx;
		}
		private var _idx:uint;
	}
}