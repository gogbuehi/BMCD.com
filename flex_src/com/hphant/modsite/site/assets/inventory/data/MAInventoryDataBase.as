package com.hphant.modsite.site.assets.inventory.data
{
	import com.hphant.modsite.data.inventory.BMCDInventoryItemData;
	
	import flash.events.EventDispatcher;

	public class MAInventoryDataBase extends EventDispatcher
	{
		private var _makes:Array = new Array();
		public function MAInventoryDataBase()
		{
			super(this);
		}
		public function addMake(car:BMCDInventoryItemData):uint{
			var makeFound:Boolean = false;
			var c:MAInventoryMakeData;
			for each(c in this._makes){
				if(c.name==String(car.make.data)){
					makeFound = true;
					break;
				}
			}
			if(!makeFound){
				c = new MAInventoryMakeData(String(car.make.data));
				this._makes.push(c);
			}
			c.addModle(car);
			return this._makes.length;
		}
		public function get makes():Array{
			return this._makes;
		}
		public override function toString():String{
			return "[MAInventoryDataBase {"+this._makes+"}]";
		}
		public function getCars(models:Array):Array{
			var cars:Array = new Array();
			for each (var s:String in models){
				for each (var make:MAInventoryMakeData in this.makes){
					for each (var model:MAInventoryModelData in make.models){
						if(s==model.toString()){
							cars = cars.concat(model.cars);
						}
					}
				}
			}
			return cars;
		}
	}
}