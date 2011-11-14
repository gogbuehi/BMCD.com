package com.hphant.modsite.site.assets.store.data
{
	public class Price
	{
		private var array:Array;
		private var string:String;
		public function Price(value:Object)
		{
			array = (value is String) ? String(value).replace(",","").split("$") : (value is Number) ? ["","0.00"] : null ;
			string = (value is String) ? String(value).replace(",","").replace("$","") : (value is Number) ? setDecamal(Number(value)) : null ;
			
		}
		public function toString():String{
			var tArray:Array = string.split(".");
			var head:String = tArray[0];
			var headExtend:String = "";
			var cnt:uint = 0;
			for(var i:uint=head.length;i>0;i--){
				var char:String = head.substr(i-1,1);
				headExtend = ((cnt<3) ? char : char + ",") + headExtend;
				cnt = (cnt==3) ? 1 : cnt + 1;
			}
			var tail:String = (tArray[1]) ? (String(tArray[1]).length==1) ? String(tArray[1])+"0" : (String(tArray[1]).length==0) ? "00" : String(tArray[1]) : "00";
			return "$" + headExtend + "." + tail;
		}
		public function toNumber():Number{
			return Number(array[1]);
		}
		private function setDecamal(num:Number):String{
			var tArray:Array = String(num).split(".");
			var head:String = tArray[0];
			var tail:String = (tArray[1]) ? (Number(tArray[1])<10) ? String(tArray[1])+"0" : String(tArray[1]) : "00";
			return head+ "." + tail;
		}
	}
}