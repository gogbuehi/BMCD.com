package com.hphant.modsite.admin
{
	import com.hphant.modsite.IModsite;
	import com.hphant.modsite.site.modules.interfaces.IModuleLibrary;
	
	import flash.events.IEventDispatcher;
	import flash.events.MouseEvent;
	
	public interface IAdminManager extends IEventDispatcher
	{
		function start():void;
		function set site(value:IModsite):void;
		function get site():IModsite;
		function set moduleLibrary(value:IModuleLibrary):void;
	}
} 