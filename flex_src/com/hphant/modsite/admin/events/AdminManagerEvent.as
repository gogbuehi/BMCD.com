package com.hphant.modsite.admin.events
{
	import flash.events.Event;

	public class AdminManagerEvent extends Event
	{
		public function AdminManagerEvent(type:String, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
		}
		public static const START_PAGE_EDIT:String = "startPageEdit";
		public static const END_PAGE_EDIT:String = "endPageEdit";
		public static const START_MODULE_EDIT:String = "startModuleEdit";
		public static const END_MODULE_EDIT:String = "endModuleEdit";
		public static const START_ADMIN:String = "startAdmin";
		public static const END_ADMIN:String = "endAdmin";
		public static const TEMPLATES_LOADED:String = "templatesLoaded";
		public static const CHANGE_MODULE_TYPE:String = "changeModuleType";
	}
}