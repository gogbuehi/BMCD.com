package com.hphant.services.js
{
	import com.hphant.components.LoginForm;
	import com.hphant.components.LoginMessage;
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
	[Event(name="login",type="com.hphant.services.js.LoginServiceEvent")]
	public class LoginService extends EventDispatcher
	{
		public function LoginService()
		{
			super(this);
			if(instance){
				throw new Error("Singleton. Use LoginService.getInstance().");
			}
			form = new LoginForm();
			message = new LoginMessage();
			form.addEventListener(Event.SELECT,this.loginClick);
			form.addEventListener(LoginFormEvent.FORGOT,this.forgotClick);
			form.addEventListener(Event.CANCEL,this.cancelClick);
			message.addEventListener(Event.SELECT,this.messageClick);
			form.addEventListener(ResizeEvent.RESIZE,this.resize);
			message.addEventListener(ResizeEvent.RESIZE,this.resize);
			PasswordRequestService.getInstance().addEventListener(JavascriptServiceEvent.ERROR,this.passwordRequestEvent);
			PasswordRequestService.getInstance().addEventListener(JavascriptServiceEvent.SUCCESS,this.passwordRequestEvent);
		}
		private static var instance:LoginService;
		public static function getInstance():LoginService{
			if(!instance){
				instance = new LoginService()
			}
			return instance;
		}
		public function login():void{
			form.clear();
			centerPopUp(form);
			PopUpManager.addPopUp(form,UIComponent(Application.application),true);
		}
		private var form:LoginForm;
		private var message:LoginMessage;
		
		public function successCallback(callbackObject:Object):void{
			message.message = callbackObject.message;
			form.login.enabled = true;
			centerPopUp(message);
			PopUpManager.addPopUp(message,UIComponent(Application.application),true);
			PopUpManager.removePopUp(form);
			this.dispatchEvent(new LoginServiceEvent(LoginServiceEvent.LOGIN));
		}
		public function errorCallback(callbackObject:Object):void{
			message.message = callbackObject.message;
			centerPopUp(message);
			form.login.enabled = true;
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
		private function forgotClick(event:LoginFormEvent):void{
			PasswordRequestService.getInstance().request();
		}
		private function loginClick(event:Event):void{
			var domain:String = URLUtil.getServerName(Application.application.url);
			form.login.enabled = false;
			ExternalInterface.call("PermissionManager.sendLoginRequest",form.user,form.password,domain);
		}
		private function cancelClick(event:Event):void{
			PopUpManager.removePopUp(UIComponent(event.currentTarget));
		}
		private function passwordRequestEvent(event:JavascriptServiceEvent):void{
			
		}
		private function resize(event:ResizeEvent):void{
			centerPopUp(UIComponent(event.currentTarget));
		}
	}
}