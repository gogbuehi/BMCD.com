package com.hphant.modsite.site.modules
{
	import com.hphant.modsite.site.modules.interfaces.IModule;
	import com.hphant.modsite.system.interfaces.IURIManager;
	
	import flash.text.StyleSheet;
	
	import mx.containers.Canvas;
	import mx.core.ScrollPolicy;

	public class ModuleCanvas extends Canvas implements IModule
	{
		protected var _xml:XMLList;
		protected var _css:StyleSheet;
		protected var cssChanged:Boolean;
		protected var xmlChanged:Boolean;
		protected var _uriManager:IURIManager;
		public function ModuleCanvas()
		{
			super();
			this.autoLayout = true;
			this.verticalScrollPolicy= ScrollPolicy.OFF;
			this.horizontalScrollPolicy = ScrollPolicy.OFF;	
		}
		
		
	}
}