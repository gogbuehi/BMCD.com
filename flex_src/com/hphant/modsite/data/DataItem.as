package com.hphant.modsite.data
{
	import flash.events.EventDispatcher;

	public class DataItem extends EventDispatcher
	{
		public function DataItem()
		{
			super(this);
		}
		
		[Inspectable]
		[Bindable]
		public function get label():String{return this._label;}
		public function set label(value:String):void{this._label = value;}
		private var _label:String;
		
		[Inspectable]
		[Bindable]
		public function get data():Object{return this._data;}
		public function set data(value:Object):void{this._data = value;}
		private var _data:Object
		
		public override function toString():String{
			return "[DataItem {label:"+_label+", data:"+_data+"}]";
		}
	}
}