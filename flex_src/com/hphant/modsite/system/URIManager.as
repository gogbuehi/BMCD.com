package com.hphant.modsite.system
{
	import com.hphant.modsite.system.events.URIManagerEvent;
	import com.hphant.modsite.system.events.URIRequesterEvent;
	import com.hphant.modsite.system.events.URISenderEvent;
	import com.hphant.modsite.system.interfaces.IURIManager;
	import com.hphant.utils.Logger;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IEventDispatcher;
	import flash.external.ExternalInterface;
	[Event(name="uriChanged",type="com.hphant.modsite.system.events.URIManagerEvent")]
	[Event(name="requestMade",type="com.hphant.modsite.system.events.URIRequesterEvent")]
	[Event(name="requestError",type="com.hphant.modsite.system.events.URIRequesterEvent")]
	[Event(name="requestComplete",type="com.hphant.modsite.system.events.URIRequesterEvent")]
	[Event(name="sendComplete",type="com.hphant.modsite.system.events.URISenderEvent")]
	[Event(name="sendError",type="com.hphant.modsite.system.events.URISenderEvent")]
	public class URIManager extends Object implements IEventDispatcher, IURIManager
	{
		private var _dispatcher:EventDispatcher;
		private var _history:Array;
		private var _requester:URIRequester;
		private var _sender:URISender;
		private var _current:String;
		private var _parser:URIParser;
		private var _internalCall:Boolean = false;
		private var _enabled:Boolean = true;
		public function URIManager()
		{
			super();
			this._history = new Array();
			this._dispatcher = new EventDispatcher(this);
			this._parser = new URIParser();
			this._requester = new URIRequester();
			this._sender = new URISender();
			this._requester.addEventListener(URIRequesterEvent.REQUEST_ERROR,requestError);
			this._requester.addEventListener(URIRequesterEvent.REQUEST_MADE,requestMade);
			this._sender.addEventListener(URISenderEvent.SEND_COMPLETE,this.sendComplete);
			this._sender.addEventListener(URISenderEvent.SEND_ERROR,this.sendError);
			this._requester.addEventListener(URIRequesterEvent.REQUEST_RECEIVED,this.uriChanged);
			this._current = "";
		    ExternalInterface.addCallback("goToURI",_goToURI);
		}
		public function get enabled():Boolean{return this._enabled;}
		public function set enabled(value:Boolean):void{this._enabled = value;}
		public function get parser():URIParser{return this._parser;}
		public function get sender():URISender{return this._sender;}
		public function get requester():URIRequester{return this._requester;}
		public function get current():String{return this._current;}
		public function goToURI(uri:String,data:Object=null,session_id:String="",hasDynamicContent:Boolean=false):void{
			this._internalCall = true;
			this._goToURI(uri,data,session_id,hasDynamicContent);
		}
		private function _goToURI(uri:String,data:Object=null,session_id:String="",hasDynamicContent:Boolean=false):void{
			if(this._enabled){
				this.dispatchEvent(new URIRequesterEvent(URIRequesterEvent.REQUEST_MADE,uri,"",[],true));
				log("Go To URI: \n\turi='"+uri+"',\n\tdata='\n"+data+"\n'\n");
				this._sender.send(uri,data,session_id,hasDynamicContent);
			}
		}
		private function uriChanged(e:URIRequesterEvent):void{
			this._history.push(this._current);
			this._current = e.uri;
			this._internalCall = false;
			log("URI Changed: \n\ttype='"+e.type+"',\n\tsuccess='"+e.success+"',\n\turi='"+e.uri+"',\n\thtml='\n"+e.html+"\n',\n\tsuplimental='\n"+e.supplemental+"\n',\n");
			var ne:Event = new URIManagerEvent(URIManagerEvent.URI_CHANGED,e.uri,e.html,e.supplemental);
			e.clear();
			e = null;
			this.dispatchEvent(ne);
		}
		private function requestMade(e:URIRequesterEvent):void{
			log("Request Made: \n\ttype='"+e.type+"',\n\tsuccess='"+e.success+"',\n\turi='"+e.uri+"',\n\thtml='\n"+e.html+"\n',\n\tsuplimental='\n"+e.supplemental+"\n',\n");
			var ne:Event = new URIRequesterEvent(e.type,e.uri,e.html,e.supplemental,e.success);
			e.clear();
			e = null;
			this.dispatchEvent(ne);
		}
		private function requestError(e:URIRequesterEvent):void{
			log("Request Error: \n\ttype='"+e.type+"',\n\tsuccess='"+e.success+"',\n\turi='"+e.uri+"',\n\thtml='\n"+e.html+"\n',\n\tsuplimental='\n"+e.supplemental+"\n',\n");
			this._internalCall = false;
			var ne:Event = new URIRequesterEvent(e.type,e.uri,e.html,e.supplemental,e.success);
			e.clear();
			e = null;
			this.dispatchEvent(ne);
		}
		private function sendComplete(e:URISenderEvent):void{
			log("Send Complete: "+e.error);
			var ne:Event = new URISenderEvent(URISenderEvent.SEND_COMPLETE,e.error);
			e.clear();
			e = null;
			this.dispatchEvent(ne);
		}
		private function sendError(e:URISenderEvent):void{
			log("Send Error: "+e.error,2);
			var ne:Event = new URISenderEvent(URISenderEvent.SEND_ERROR,e.error);
			e.clear();
			e = null;
			this.dispatchEvent(ne);
		}
		public function addEventListener(type:String, listener:Function, useCapture:Boolean=false, priority:int=0, useWeakReference:Boolean=false):void
		{ this._dispatcher.addEventListener(type,listener,useCapture,priority,useWeakReference);
		}
		
		public function removeEventListener(type:String, listener:Function, useCapture:Boolean=false):void
		{ this._dispatcher.removeEventListener(type,listener,useCapture);
		}
		
		public function dispatchEvent(event:Event):Boolean
		{
			return this._dispatcher.dispatchEvent(event);
		}
		
		public function hasEventListener(type:String):Boolean
		{
			return this._dispatcher.hasEventListener(type);
		}
		
		public function willTrigger(type:String):Boolean
		{
			return this._dispatcher.willTrigger(type);
		}
		
		private function log(message:Object,level:int=0):void{
			 Logger.log("[URIManager] "+String(message),level);
		}
		
	}
}