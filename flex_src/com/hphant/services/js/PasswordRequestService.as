package com.hphant.services.js
{
	import com.hphant.components.LoginForm;
	import com.hphant.components.LoginMessage;
	import com.hphant.components.PasswordRequestForm;
	import com.hphant.components.events.LoginFormEvent;
	import com.hphant.managers.BrowserScrollManager;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.external.ExternalInterface;
	
	import mx.core.Application;
	import mx.core.UIComponent;
	import mx.events.ResizeEvent;
	import mx.managers.PopUpManager;
	import mx.utils.URLUtil;
	[Event(name="error",type="com.hphant.services.js.JavascriptServiceEvent")]
	[Event(name="success",type="com.hphant.services.js.JavascriptServiceEvent")]
	public class PasswordRequestService extends EventDispatcher
	{
		public function PasswordRequestService()
		{
			super(this);
			if(instance){
				throw new Error("Singleton. Use PasswordRequestService.getInstance().");
			}
			form = new PasswordRequestForm();
			message = new LoginMessage();
			form.addEventListener(Event.SELECT,this.passwordRequestClick);
			form.addEventListener(Event.CANCEL,this.cancelClick);
			message.addEventListener(Event.SELECT,this.messageClick);
			form.addEventListener(ResizeEvent.RESIZE,this.resize);
			message.addEventListener(ResizeEvent.RESIZE,this.resize);
		}
		private static var instance:PasswordRequestService;
		public static function getInstance():PasswordRequestService{
			if(!instance){
				instance = new PasswordRequestService()
			}
			return instance;
		}
		public function request():void{
			form.clear();
			centerPopUp(form);
			PopUpManager.addPopUp(form,UIComponent(Application.application),true);
		}
		private var form:PasswordRequestForm;
		private var message:LoginMessage;
		
		public function successCallback(callbackObject:Object):void{
			message.message = callbackObject.message;
			form.request.enabled = true;
			centerPopUp(message);
			PopUpManager.addPopUp(message,UIComponent(Application.application),true);
			PopUpManager.removePopUp(form);
			this.dispatchEvent(new JavascriptServiceEvent(JavascriptServiceEvent.SUCCESS));
		}
		public function errorCallback(callbackObject:Object):void{
			message.message = callbackObject.message;
			centerPopUp(message);
			form.request.enabled = true;
			PopUpManager.addPopUp(message,UIComponent(Application.application),true);
			this.dispatchEvent(new JavascriptServiceEvent(JavascriptServiceEvent.ERROR));
		}
		private function centerPopUp(popup:UIComponent):void{
			popup.y = BrowserScrollManager.getInstance().vertical + BrowserScrollManager.getInstance().height/2 - popup.height/2;
			popup.x = BrowserScrollManager.getInstance().horizontal + BrowserScrollManager.getInstance().width/2 - popup.width/2;
		}
		private function messageClick(event:Event):void{
			PopUpManager.removePopUp(UIComponent(event.currentTarget));
		}
		private function passwordRequestClick(event:Event):void{
			var domain:String = URLUtil.getServerName(Application.application.url);
			form.request.enabled = false;
			ExternalInterface.call("PermissionManager.sendPasswordRequest",form.user,domain);
		}
		private function cancelClick(event:Event):void{
			PopUpManager.removePopUp(UIComponent(event.currentTarget));
		}
		private function resize(event:ResizeEvent):void{
			centerPopUp(UIComponent(event.currentTarget));
		}
	}
}