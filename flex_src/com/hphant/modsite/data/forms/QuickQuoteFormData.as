package com.hphant.modsite.data.forms
{
	public class QuickQuoteFormData extends FormData
	{
		public function QuickQuoteFormData()
		{
			super();
			super.formName = "QuickQuoteForm";
		}
		public var extColor:String = "";
		public var intColor:String = "";
		public var tradeInYear:String = "";
		public var tradeInMake:String = "";
		public var tradeInModel:String = "";
		public var firstName:String = "";
		public var lastName:String = "";
		public var email:String = "";
		public var phone:String = "";
		public var comment:String = "";
		public var make:String = "";
		public var model:String = "";
		public var year:String = "";
		
		public function toString():String{
			return "{extColor='"+this.extColor+"',"+
					"intColor='"+this.intColor+"',"+
					"tradeInYear='"+this.tradeInYear+"',"+
					"tradeInMake='"+this.tradeInMake+"',"+
					"tradeInModel='"+this.tradeInModel+"',"+
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