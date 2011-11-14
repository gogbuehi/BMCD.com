package com.hphant.modsite.admin.process
{
	import com.hphant.contentlibrary.control.GeneralEvent;
	import com.hphant.modsite.admin.model.ModuleContent;
	import com.hphant.modsite.admin.TemplateHTML;
	import flash.events.Event;
	import mx.rpc.Fault;
	import com.hphant.modsite.site.modules.ModuleClassInfo;

	public class ArticleProcess implements IModuleEditProcess
	{
		public function ArticleProcess()
		{
		}

		public function handleResult(event:GeneralEvent, result:Object):void
		{
		}
		
		public function handleFault(event:GeneralEvent, fault:Fault):void
		{
		}
		
		public function get hasImage():Boolean
		{
			return false;
		}
		
		public function get hasImageList():Boolean
		{
			return false;
		}
		
		public function get hasVideo():Boolean
		{
			return false;
		}
		
		public function get hasVideoList():Boolean
		{
			return false;
		}
		
		public function get hasBody():Boolean
		{
			return true;
		}
		
		public function get hasTitle():Boolean
		{
			return true;
		}
		
		public function get template():TemplateHTML
		{
			return null;
		}
		
		public function get moduleClass():ModuleClassInfo
		{
			return null;
		}
		private var _content:ArticleContent;
		public function get content():ModuleContent
		{
			return _content;
		}
		
		public function set content(value:ModuleContent)
		{
			if(value is ArticleContent){
				_content = value;
			} else {
				_content =
			}
		}
		
		public function addEventListener(type:String, listener:Function, useCapture:Boolean=false, priority:int=0, useWeakReference:Boolean=false):void
		{
		}
		
		public function removeEventListener(type:String, listener:Function, useCapture:Boolean=false):void
		{
		}
		
		public function dispatchEvent(event:Event):Boolean
		{
			return false;
		}
		
		public function hasEventListener(type:String):Boolean
		{
			return false;
		}
		
		public function willTrigger(type:String):Boolean
		{
			return false;
		}
		
	}
}