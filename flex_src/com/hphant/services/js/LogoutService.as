package com.hphant.services.js
{
	import com.hphant.components.LoginMessage;
	import com.hphant.managers.BrowserScrollManager;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.external.ExternalInterface;
	
	import mx.core.Application;
	import mx.core.UIComponent;
	import mx.events.ResizeEvent;
	import mx.managers.PopUpManager;
	[Event(name="error",type="com.hphant.services.js.JavascriptServiceEvent")]
	[Event(name="logout",type="com.hphant.services.js.LogoutServiceEvent")]
	public class LogoutService extends EventDispatcher
	{
		public function LogoutService()
		{
			super(this);
			if(instance){
				throw new Error("Singleton. Use LogoutServiceEvent.getInstance().");
			}
			message = new LoginMessage();
			message.addEventListener(ResizeEvent.RESIZE,this.resize);
		}
		private static var instance:LogoutService;
		public static function getInstance():LogoutService{
			if(!instance){
				instance = new LogoutService()
			}
			return instance;
		}
		public function logout():void{
			ExternalInterface.call("PermissionManager.sendLogoutRequest");
		}
		private var message:LoginMessage;
		
		public function successCallback(callbackObject:Object):void{
			message.message = callbackObject.message;
			message.addEventListener(Event.SELECT,this.logoutClick);
			centerPopUp(message);
			PopUpManager.addPopUp(message,UIComponent(Application.application),true);
		}
		public function errorCallback(callbackObject:Object):void{
			message.message = callbackObject.message;
			message.addEventListener(Event.SELECT,this.errorClick);
			centerPopUp(message);
			PopUpManager.addPopUp(message,UIComponent(Application.application),true);
		}
		private function centerPopUp(popup:UIComponent):void{
			popup.y = BrowserScrollManager.getInstance().vertical + BrowserScrollManager.getInstance().height/2 - popup.height/2;
			popup.x = BrowserScrollManager.getInstance().horizontal + BrowserScrollManager.getInstance().width/2 - popup.width/2;
		}
		private function errorClick(event:Event):void{
			message.removeEventListener(Event.SELECT,this.errorClick);
			PopUpManager.removePopUp(UIComponent(event.currentTarget));
			this.dispatchEvent(new JavascriptServiceEvent(JavascriptServiceEvent.ERROR));
		}
		private function logoutClick(event:Event):void{
			message.removeEventListener(Event.SELECT,this.logoutClick);
			PopUpManager.removePopUp(UIComponent(event.currentTarget));
			this.dispatchEvent(new LogoutServiceEvent(LogoutServiceEvent.LOGOUT));
		}
		private function resize(event:ResizeEvent):void{
			centerPopUp(UIComponent(event.currentTarget));
		}
	}
}