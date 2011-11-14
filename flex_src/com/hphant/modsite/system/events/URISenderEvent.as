package com.hphant.modsite.system.events
{
	import flash.events.Event;
	import flash.system.System;

	public class URISenderEvent extends Event
	{
		public static function get SEND_COMPLETE():String{return "URLSenderSendComplete";}
		public static function get SEND_ERROR():String{return "URLSenderSendError";}
		private var _error:Error;
		public function URISenderEvent(type:String,error:Error=null, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			this._error = error;
		}
		public function get error():Error{
			return this._error;
		}
		
		public function clear():void{
			this._error = null;
		}
	}
}