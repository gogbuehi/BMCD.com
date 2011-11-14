package com.hphant.modsite.site.events
{
	import com.hphant.modsite.data.interfaces.IFormData;
	
	import flash.events.Event;

	public class MAFormEvent extends Event
	{
		public static const SEND_EMAIL:String = "sendEmail";
		public static const CLEAR_FORM:String = "clearForm";
		public static const CANCEL:String = "cancel";
		public function MAFormEvent(type:String, formData:IFormData, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			this._formData = formData;
		}
		
		private var _formData:IFormData;
		public function get formData():IFormData{
			return this._formData;
		}
	}
}