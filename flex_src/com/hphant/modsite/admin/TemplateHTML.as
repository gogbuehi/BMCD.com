package com.hphant.modsite.admin
{
	import com.hphant.modsite.admin.events.TemplateHTMLEvent;
	
	import flash.events.EventDispatcher;
	import flash.external.ExternalInterface;

	[Event(name="loaded",type="com.hphant.modsite.admin.events.TemplateHTMLEvent")]
	[Event(name="error",type="com.hphant.modsite.admin.events.TemplateHTMLEvent")]
	public class TemplateHTML extends EventDispatcher
	{
		private static var _instance:TemplateHTML;
		private var _templates:Object = new Object();
		public function TemplateHTML()
		{
			super(this);
			if(_instance){
				throw new Error("use TemplateHTML.getInstance()");
			}
			ExternalInterface.addCallback("getModuleTemplateCallback",callback);
			ExternalInterface.addCallback("getModuleTemplateCallbackError",callbackError);
		}
		private function callback(html:String):void{
			try{
				this._templates[String(XML(html).@['id'])=='defaultContent' ? 'defaultContent' : String(XML(html).@['class'])] = html;
				this.dispatchEvent(new TemplateHTMLEvent(TemplateHTMLEvent.LOADED,html));
			} catch (e:Error){
				
			}
		}
		private function callbackError():void{
			this.dispatchEvent(new TemplateHTMLEvent(TemplateHTMLEvent.ERROR));
		}
		public static function getInstance():TemplateHTML{
			if(!_instance){
				_instance = new TemplateHTML();	
			}
			return _instance;
		}
		public function loadTemplate(name:String):void{
			this._templates[name] = "";
			ExternalInterface.call("getModuleTemplate",name);
		}
		public function getTemplate(name:String):String{ 
			return (this._templates[name]) ? String(this._templates[name]) : null;
		}
	}
}