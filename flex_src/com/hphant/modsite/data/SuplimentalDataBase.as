package com.hphant.modsite.data
{
	public class SuplimentalDataBase extends Object
	{
		private static var _objects:Object = new Object();
		public static function getSuplimentalData(id:String):String{
			return _objects["div"+id];
		}
		public static function setSuplimentalData(id:String,data:String):void{
			_objects["div"+id] = data;
		}
		public function SuplimentalDataBase()
		{
			super();
		}
		
	}
}