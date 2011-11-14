package com.hphant.modsite.data.forms
{
	public class StoreEmailDealerFormData extends FormData
	{
		public function StoreEmailDealerFormData()
		{
			super();
			super.formName = "StoreEmailDealerForm";
		}
		public var firstName:String = "";
		public var lastName:String = "";
		public var email:String = "";
		public var phoneNumber:String = "";
		public var itemID:String = "";
		public var title:String = "";
		public var comment:String = "";
		public var itemData:String = "";
		public var linkToItem:String = "";

		
	}
}