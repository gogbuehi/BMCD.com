package com.hphant.modsite.data.forms
{
	
	
	public class EmailFriendFormData extends FormData
	{
		public function EmailFriendFormData()
		{
			super();
			super.formName = "EmailFriendForm";
		}
		public var friendsFirstName:String = "";
		public var yourName:String = "";
		public var friendsEmail:String = "";
		public var yourEmail:String = "";
		public var comment:String = "";
		public var vehicleData:String = "";
		public var vehicleTitle:String = "";
		public var price:String = "";
		public var vehicleMainImage:String = "";
		public var linkToVehicle:String = "";
		public var vehicleDescription:String = "";
		public var vehicleMake:String = "";
		 
	}
}