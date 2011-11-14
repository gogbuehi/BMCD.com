package com.hphant.modsite.data.forms
{
	public class QuoteRequestEmailFormData extends FormData
	{
		public function QuoteRequestEmailFormData()
		{
			super();
			super.formName = "QuoteRequestEmailForm";
		}
		public var firstName:String = "";
		public var lastName:String = "";
		public var email:String = "";
		public var phoneNumber:String = "";
		public var vin:String = "";
		public var comment:String = "";
		public var vehicleData:String = "";
		public var vehicleMake:String = "";
		public var vehicleModel:String = "";

		
	}
}