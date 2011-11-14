package com.hphant.modsite.admin.process
{
	import com.hphant.contentlibrary.control.IResponder;
	import com.hphant.modsite.admin.TemplateHTML;
	import com.hphant.modsite.admin.model.ModuleContent;
	import com.hphant.modsite.site.modules.ModuleClassInfo;
	
	import flash.events.IEventDispatcher;
	
	public interface IModuleEditProcess extends IEventDispatcher, IResponder
	{
		function get hasImage():Boolean;
		function get hasImageList():Boolean;
		function get hasVideo():Boolean;
		function get hasVideoList():Boolean;
		function get hasBody():Boolean;
		function get hasTitle():Boolean;
		function get template():TemplateHTML;
		function get moduleClass():ModuleClassInfo;
		function get content():ModuleContent;
		function set content(value:ModuleContent);
	}
}