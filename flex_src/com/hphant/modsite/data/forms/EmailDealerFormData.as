package com.hphant.modsite.data.forms
{
	public class EmailDealerFormData extends FormData
	{
		public function EmailDealerFormData()
		{
			super();
			super.formName = "EmailDealerForm";
		}
		public var firstName:String = "";
		public var lastName:String = "";
		public var email:String = "";
		public var phoneNumber:String = "";
		public var vin:String = "";
		public var stockNumber:String = "";
		public var comment:String = "";
		public var vehicleData:String = "";
		public var linkToVehicle:String = "";

		
	}
}