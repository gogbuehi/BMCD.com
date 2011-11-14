package com.hphant.modsite.site.assets.inventory.data
{
	import com.hphant.modsite.data.inventory.BMCDInventoryItemData;
	
	import flash.events.EventDispatcher;
	
	public class MAInventoryModelData extends EventDispatcher
	{
		private var _cars:Array = new Array();
		private var _name:String;
		public function MAInventoryModelData(name:String)
		{
			super(this);
			this._name = name;
		}
		public function addCar(car:BMCDInventoryItemData):uint{
			var carFound:Boolean = false;
			for each(var c:BMCDInventoryItemData in this._cars){
				if(c.stockNumber.data==car.stockNumber.data){
					carFound = true;
					break;
				}
			}
			if(!carFound){this._cars.push(car);}
			return this._cars.length;
		}
		public function get name():String {
			return this._name;
		}
		public function get cars():Array{
			return this._cars;
		}
		public override function toString():String{
			return this._name+" ("+this._cars.length+")";
		}
	}
}