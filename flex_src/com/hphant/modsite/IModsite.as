package com.hphant.modsite
{
	import com.hphant.modsite.site.assets.containers.interfaces.ISiteBody;
	import com.hphant.modsite.site.modules.interfaces.IModule;
	import com.hphant.modsite.site.modules.interfaces.IModuleLibrary;
	import com.hphant.modsite.system.interfaces.IURIManager;
	
	import mx.core.IUIComponent;
	
	public interface IModsite extends IUIComponent
	{
		function get pageBody():ISiteBody;
		function get moduleLibrary():IModuleLibrary;
		function get uriManager():IURIManager;
		function replaceModule(moduleIn:IModule,moduleOut:IModule):void;
		function insertModule(moduleIn:IModule,index:uint):void;
		function getPage():XML;
		function endAdmin():void;
		function get headerClass():String;
		function set headerClass(value:String):void;
		function get footerClass():String;
		function set footerClass(value:String):void;
	}
}