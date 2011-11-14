package com.hphant.modsite.site.modules.interfaces
{
	import com.hphant.modsite.site.modules.ModuleClassInfo;
	import com.hphant.modsite.system.interfaces.ICSSLoader;
	import com.hphant.modsite.system.interfaces.IURIManager;
	
	public interface IModuleLibrary
	{
		function get uriManager():IURIManager;
		function set uriManager(value:IURIManager):void;
		function set css(cssLoader:ICSSLoader):void;
		[ArrayElementType("com.hphant.modsite.site.modules.ModuleClassInfo")]
		function get classes():Array;
		function getModuleInstancesOf(classname:String):Array;
		function createInstanceOf(classname:String):IModule;
		function getClassInfoByName(className:String):ModuleClassInfo;
		function get versionMajor():uint;
		function get versionMinor():uint;
		function get versionRevision():uint;
		function getSupplementalData(id:String):String;
		function setSupplementalData(id:String,data:String):void;
	}
}