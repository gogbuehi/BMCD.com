package com.hphant.modsite.data.forms
{
	import com.hphant.modsite.data.interfaces.IFormData;
	import mx.core.Application;
	import mx.utils.URLUtil;

	public class FormData extends Object implements IFormData
	{
		public function FormData()
		{
			super();
			this.homepageLink = "http://"+URLUtil.getServerName(Application.application.url);
		}
		
		public function get formName():String
		{
			return this._name;
		}
		public function set formName(value:String):void
		{
			this._name = value;
		}
		private var _name:String = "FormData";
		public var homepageLink:String = "";
		
	}
}