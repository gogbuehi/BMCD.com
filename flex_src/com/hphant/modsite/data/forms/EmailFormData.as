package com.hphant.modsite.data.forms
{
	public class EmailFormData extends FormData
	{
		public function EmailFormData()
		{
			super();
			super.formName = "EmailForm";
		}
		public var toFirstName:String = "";
		public var toLastName:String = "";
		public var toEmail:String = "";
		public var fromFirstName:String = "";
		public var fromLastName:String = "";
		public var fromEmail:String = "";
		public var fromPhone:String = "";
		public var message:String = "";
		public var vehicleData:String = "";
		
		public function toString():String{
			return "{formName='"+this.formName+"',"+
					"toFirstName='"+this.toFirstName+"',"+
					"toLastName='"+this.toLastName+"',"+
					"toEmail='"+this.toEmail+"',"+
					"fromFirstName='"+this.fromFirstName+"',"+
					"fromLastName='"+this.fromLastName+"',"+
					"fromEmail='"+this.fromEmail+"',"+
					"fromPhone='"+this.fromPhone+"',"+
					"message='"+this.message+"'}"	
		}
		
	}
}