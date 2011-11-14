package com.dhmpire.Events
{
	import flash.events.Event;

	public class CalendarEvent extends Event
	{
		public static function get DAY_SELECT():String{return "daySelect";}
		public static function get MONTH_PREVIOUS():String{return "monthPrevious";}
		public static function get MONTH_NEXT():String{return "monthNext";}
		public static function get LOADED():String{return "loaded";}
		
		private var _month:String;
		public function get month():String{return this._month;}
		private var _day:String;
		public function get day():String{return this._day;}
		private var _year:String;
		public function get year():String{return this._year;}
		private var _data:Object;
		public function get data():Object{return this._data;}
		public function CalendarEvent(type:String,year:String=null,month:String=null,day:String=null, data:Object=null, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			this._data = data;
			this._month = month;
			this._year = year;
			this._day = day;
			
		}
		public override function toString():String{
			return ((this._month) ? this._month : "_")+"/"+((this._day) ? this._day : "_")+"/"+((this._year) ? this._year : "_")+" data="+this._data;
		}
	}
}