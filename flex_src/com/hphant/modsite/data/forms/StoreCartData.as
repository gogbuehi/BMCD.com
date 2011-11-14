package com.hphant.modsite.data.forms
{
	public class StoreCartData extends FormData
	{
		public function StoreCartData()
		{
			super();
			super.formName = "ShoppingCartSubmitForm";
		}
		public var billing:Object = {};
		public var shipping:Object = {};
		public var items:String = "";
		public var total:String = "";
		public var vehicleMake:String = "";
		public var comment:String = "";
		public function toEmailData():Object{
			var i:String;
			var obj:Object = new Object();
			for(i in billing){
				/* if(i=="email"){
					obj[i] = billing[i];
				} else { */
					obj["billing_"+i] = billing[i];
				//}
			}
			for(i in shipping){
				obj["shipping_"+i] = shipping[i];
			}
			obj.items = items;
			obj.total = total;
			obj.comment = comment;
			obj.formName = formName;
			obj.vehicleMake = vehicleMake;
			obj.homepageLink = this.homepageLink;
			return obj;
		}
	}
}