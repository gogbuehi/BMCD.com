package com.hphant.modsite.admin.events
{
	import flash.events.Event;

	public class TemplateHTMLEvent extends Event
	{
		
		public static const LOADED:String = "loaded";
		public static const ERROR:String = "error";
		public function TemplateHTMLEvent(type:String, classname:String=null, html:String=null, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			this._html = html;
			this._classname = classname;
			
		}
		private var _classname:String;
		private var _html:String;
		public function get classname():String{return this._classname;}
		public function get html():String{return this._html;}
		
	}
}