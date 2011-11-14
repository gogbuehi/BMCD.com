package com.hphant.modsite.data.forms
{
	import mx.core.Application;
	import mx.utils.URLUtil;
	
	
	public class CalendarEmailFriendFormData extends FormData
	{
		public function CalendarEmailFriendFormData()
		{
			super();
			super.formName = "CalendarEmailFriendForm";
		}
		public var friendsFirstName:String = "";
		public var yourName:String = "";
		public var friendsEmail:String = "";
		public var yourEmail:String = "";
		public var comment:String = "";
		public var eventData:String = "";
		public var title:String = "";
		public var date:String = "";
		public var description:String = "";
		public var linkToEvent:String = "";
		public var map:String = "";
		public var start:String = "";
		public var end:String = "";
		public var blurb:String = "";
		public var image:String = "";
		public var address:String = "";
		 
	}
}