package com.hphant.modsite.system.events
{
	import flash.events.Event;
	import flash.system.System;

	public class URIParserEvent extends Event
	{
		public static function get PARSE_COMPLETE():String{return "URLParserParseComplete";}
		public static function get PARSE_ERROR():String{return "URLParserParseError";}
		private var _success:Boolean;
		private var _message:String;
		public function get succes():Boolean{return this._success;}
		public function get message():String{return this._message;}
		public function URIParserEvent(type:String, success:Boolean, message:String="", bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			this._message = message;
			this._success = success;
		}
		public function clear():void{
			this._success = false;
			this._message = "";
		}
		
	}
}