package com.hphant.modsite.data.forms
{
	import mx.core.Application;
	import mx.utils.URLUtil;
	
	
	public class StoreEmailFriendFormData extends FormData
	{
		public function StoreEmailFriendFormData()
		{
			super();
			super.formName = "StoreEmailFriendForm";
		}
		public var friendsFirstName:String = "";
		public var yourName:String = "";
		public var friendsEmail:String = "";
		public var yourEmail:String = "";
		public var comment:String = "";
		public var itemData:String = "";
		public var title:String = "";
		public var price:String = "";
		public var itemMainImage:String = "";
		public var linkToItem:String = "";
		public var long:String = "";
		public var vehicleMake:String = "";
		 
	}
}