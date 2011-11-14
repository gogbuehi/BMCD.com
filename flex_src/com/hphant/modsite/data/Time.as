package com.hphant.modsite.data
{
	import mx.formatters.NumberFormatter;
	
	public class Time
	{
		
		public function Time(h:uint=0,m:uint=0,s:uint=0)
		{
			this.hour = h;
			this.minute = m;
			this.second = s;
		}

		private var _hour:uint;
		public function get hour():uint{
			return this._hour
		}
		public function set hour(value:uint):void{
			this._hour = (value<24) ? value : 0;
		}
		
		private var _minute:uint = 0;
		public function get minute():uint{
			return this._minute;
		}
		public function set minute(value:uint):void{
			this._minute = (value<60) ? value : 0;
		}
		
		private var _second:uint = 0;
		public function get second():uint{
			return this._second;
		}
		public function set second(value:uint):void{
			this._second = (value<60) ? value : 0;
		}
		
		public function set usTime(value:String):void{
			var time:Array = value.split(" ");
			var hms:Array = time[0].split(":");
			var ap:String = (time.length==2) ? String(time[1]).toLowerCase() : "am";
			var h:uint = (hms && hms.length>0) ? uint(Number(hms[0])) : 0;
			if(h>12){h=0;}
			this.hour = (ap!="pm") ? h : h + 12;
			this.minute = 	(hms && hms.length>1) ? uint(Number(hms[1])) : 0;
			this.second = 	(hms && hms.length>2) ? uint(Number(hms[2])) : 0;
		}
		public function get usTime():String{
			var ap:String = (this._hour < 12) ? "am" : "pm";
			var h:uint = (this._hour < 13) ? this._hour : this._hour - 12;
			return  ""+leadingZero(h)+":"+leadingZero(this._minute)+":"+leadingZero(this._second)+" "+ap; 
		}
		private function leadingZero(value:uint):String{
			return (value<10) ? String("0"+value) : String(value);
		}
		public function toNumber():Number{
			return Number(leadingZero(this._hour)+""+leadingZero(this._minute)+""+leadingZero(this._second));
		}
	}
}