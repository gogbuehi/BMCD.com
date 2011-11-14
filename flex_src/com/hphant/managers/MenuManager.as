package com.hphant.managers
{
	import com.hphant.interfaces.IMenuConverter;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;

	public class MenuManager extends EventDispatcher
	{
		public function MenuManager()
		{
			super(this);
			if(instance){
				throw new Error("Singleton, Call MenuManager.getInstance()");
			}
		}
		private static var instance:MenuManager;
		
		public static function getInstance():MenuManager{
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
		
		private var _converter:IMenuConverter;
		[Bindable]
		[Inspectable]
		public function set converter(value:IMenuConverter):void{
			_converter = value;
			convert();
		}
		public function get converter():IMenuConverter{
			return _converter;
		}
		
		private function convert():void{
			if(_converter)
				_tree = _converter.toTreeXMLList(_menu);
			this.dispatchEvent(new Event("treeChanged"));
		}
	}
}