package com.hphant.modsite.data.forms
{
	public class PartsRequestFormData extends FormData
	{
		public function PartsRequestFormData()
		{
			super();
			super.formName = "PartsRequestForm";
		}
		public var title:String = "";
		public var vin:String = "";
		public var firstName:String = "";
		public var lastName:String = "";
		public var email:String = "";
		public var phone:String = "";
		public var comment:String = "";
		public var make:String = "";
		public var model:String = "";
		public var year:String = "";
		
		public function toString():String{
			return "{title='"+this.title+"',"+
					"vin='"+this.vin+"',"+
					"firstName='"+this.firstName+"',"+
					"lastName='"+this.lastName+"',"+
					"email='"+this.email+"',"+
					"phone='"+this.phone+"',"+
					"year='"+this.year+"',"+
					"make='"+this.make+"',"+
					"model='"+this.model+"',"+
					"comment='"+this.comment+"'}"	
		}
		
	}
}