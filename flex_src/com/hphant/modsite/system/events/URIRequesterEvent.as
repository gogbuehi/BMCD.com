package com.hphant.modsite.system.events
{
	import flash.events.Event;
	import flash.system.System;

	public class URIRequesterEvent extends Event
	{
		public static function get REQUEST_MADE():String{return "URLRequesterRequestMade";}
		public static function get REQUEST_RECEIVED():String{return "URLRequesterRequestReceived";}
		public static function get REQUEST_ERROR():String{return "URLRequesterRequestError";}
		private var _success:Boolean;
		private var _uri:String;
		private var _html:String;
		private var _supplemental:Array;
		public function get success():Boolean{return this._success;}
		public function get uri():String{return this._uri;}
		public function get html():String{return this._html;}
		public function get supplemental():Array{return this._supplemental;}
		public function URIRequesterEvent(type:String, uri:String, html:String, supplemental:Array ,success:Boolean, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			this._success = success;
			this._html = html;
			this._uri = uri;
			this._supplemental = supplemental;
		}
		public function clear():void{
			this._html = "";
			this._uri = "";
			this._success = false;
			this._supplemental = [];
		}
		
	}
}