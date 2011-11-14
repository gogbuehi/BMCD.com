package com.hphant.managers
{
	import com.hphant.interfaces.IMenuConverter;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;

	public class DataURLManager extends EventDispatcher
	{
		public function DataURLManager()
		{
			super(this);
			if(instance){
				throw new Error("Singleton, Call DataURLManager.getInstance()");
			}
		}
		private static var instance:DataURLManager;
		
		public static function getInstance():DataURLManager{
			if(!instance){
				instance = new MenuManager();
			}
			return instance;
		}
		
		public function set menu(value:XMLList):void{
			_menu = value;
			convert();
		}
		private var _menu:XMLList;
		
		[Bindable("treeChanged")]
		public function get tree():XMLList{
			return _tree;
		}
		private var _tree:XMLList;
		
		private var _converters:Array = [];
		[Bindable]
		[Inspectable]
		public function addConverter(value:IConverter):void{
			_converter = value;
			convert();
		}
		
		private function convert():void{
			for each(var converter:IConverter in this._converters){
				_tree = _converter.convert();
			}
			this.dispatchEvent(new Event("treeChanged"));
		}
	}
}