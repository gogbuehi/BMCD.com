package com.hphant.modsite.data.forms
{
	public class CalendarEmailDealerFormData extends FormData
	{
		public function CalendarEmailDealerFormData()
		{
			super();
			super.formName = "CalendarEmailDealerForm";
		}
		public var firstName:String = "";
		public var lastName:String = "";
		public var email:String = "";
		public var phoneNumber:String = "";
		public var id:String = "";
		public var title:String = "";
		public var comment:String = "";
		public var eventData:String = "";
		public var linkToEvent:String = "";

		
	}
}