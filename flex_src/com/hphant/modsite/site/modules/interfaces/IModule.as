package com.hphant.modsite.site.modules.interfaces
{
	import com.hphant.modsite.system.interfaces.IURIManager;
	
	import flash.text.StyleSheet;
	
	import mx.core.IUIComponent;

	public interface IModule extends IUIComponent
	{
		function set css(value:StyleSheet):void;
		function get uriManager():IURIManager;
		function set uriManager(value:IURIManager):void;
		function set xml(xml:XMLList):void;
		function get xml():XMLList;
		function get modId():String;
		function get suplimental():XMLList;
		function set suplimental(value:XMLList):void;
		function duplicate():IModule;
	}
}