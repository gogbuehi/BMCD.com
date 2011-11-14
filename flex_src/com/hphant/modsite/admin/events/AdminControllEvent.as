package com.hphant.modsite.admin.events
{
	import flash.events.Event;

	public class AdminControllEvent extends Event
	{
		public function AdminControllEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		public static const LOGOUT:String = "logout";
		public static const PAGE_EDIT_CLICK:String = "pageEditClick";
		public static const MODULE_EDIT_CLICK:String = "moduleEditClick";
		public static const MODULE_REMOVE_CLICK:String = "moduleRemoveClick";
		public static const MODULE_CHANGE_CLICK:String = "moduleChangeClick";
		public static const MODULE_ADD_CLICK:String = "moduleAddClick";
		public static const MODULE_TYPE_CHANGE:String = "moduleTypeChange";
		public static const ACCOUNT_CLICK:String = "accountClick";
	}
}