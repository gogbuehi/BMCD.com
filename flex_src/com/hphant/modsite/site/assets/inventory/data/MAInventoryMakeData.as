package com.hphant.modsite.site.assets.inventory.data
{
	import com.hphant.modsite.data.inventory.BMCDInventoryItemData;
	
	import flash.events.EventDispatcher;

	public class MAInventoryMakeData extends EventDispatcher
	{
		private var _models:Array = new Array();
		private var _name:String;
		public function MAInventoryMakeData(name:String)
		{
			super(this);
			this._name = name;
		}
		public function addModle(car:BMCDInventoryItemData):uint{
			var modleFound:Boolean = false;
			var c:MAInventoryModelData
			for each(c in this._models){
				if(c.name==String(car.model.data)){
					modleFound = true;
					break;
				}
			}
			if(!modleFound){
				c = new MAInventoryModelData(String(car.model.data))
				this._models.push(c);
			}
			c.addCar(car);
			return this._models.length;
		}
		public function get name():String {
			return this._name;
		}
		public function get models():Array{
			return this._models;
		}
		public override function toString():String{
			return this._name+" ["+this._models.toString()+"]";
		}
	}
}