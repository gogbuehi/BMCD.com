package com.hphant.data.control
{
	import com.hphant.remoting.GeneralEvent;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	
	import mx.collections.ArrayCollection;
	
	public class DataOrderChanger extends EventDispatcher
	{
		public function DataOrderChanger()
		{
			super(this);
		}
		private var _data:ArrayCollection;
		private var _ids:Array = new Array();
		private var _changed:Array = new Array();
		public function set data(value:ArrayCollection):void{
			_data = value;
			_ids = new Array();
			for each(var obj:Object in _data){
				_ids.push(obj.id);
			}
		}
		public function get data():ArrayCollection{
			return _data;
		}
		
		public function applyOrder():void{
			_changed = new Array();
			for(var i:uint=0; i<_ids.length; i++){
				if(_ids[i]!=_data.getItemAt(i).id){
					_changed.push(_data.getItemAt(i));
					_data.getItemAt(i).id = _ids[i];
				}
			}
			if(_changed.length)
				this.dispatchEvent(new Event('changedItemsChange'));
		}
		[Bindable('changedItemsChange')]
		public function get changedItems():Array{
			return _changed;
		}
	}
}