package com.hphant.modsite.system.events
{
	import flash.events.Event;
	import flash.system.System;

	public class URIManagerEvent extends Event
	{
		public static function get URI_CHANGED():String{return "URLManagerURIChanged";}
		private var _uri:String;
		private var _html:String;
		private var _supplemental:Array;
		public function get uri():String{return this._uri;}
		public function get html():String{return this._html;}
		public function get supplemental():Array{return this._supplemental;}
		public function URIManagerEvent(type:String, uri:String, html:String, supplemental:Array, bubbles:Boolean=false, cancelable:Boolean=false)
		{
			super(type, bubbles, cancelable);
			this._html = html;
			this._uri = uri;
			this._supplemental = supplemental;
		}
		public function clear():void{
			this._html = "";
			this._uri = "";
			this._supplemental = [];
		}
	}
}