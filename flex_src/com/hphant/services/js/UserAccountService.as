package com.hphant.services.js
{
	import com.hphant.components.LoginMessage;
	import com.hphant.components.UserAccountForm;
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
	public class UserAccountService extends EventDispatcher
	{
		public function UserAccountService()
		{
			super(this);
			if(instance){
				throw new Error("Singleton. Use UserAccountService.getInstance().");
			}
			form = new UserAccountForm();
			message = new LoginMessage();
			form.addEventListener(Event.SELECT,this.updateClick);
			form.addEventListener(Event.CANCEL,this.cancelClick);
			message.addEventListener(Event.SELECT,this.messageClick);
			form.addEventListener(ResizeEvent.RESIZE,this.resize);
			message.addEventListener(ResizeEvent.RESIZE,this.resize);
		}
		private static var instance:UserAccountService;
		public static function getInstance():UserAccountService{
			if(!instance){
				instance = new UserAccountService()
			}
			return instance;
		}
		public function update():void{
			form.clear();
			var scope:Object = ExternalInterface.call("PermissionManager.getFlashScope");
			form.user = scope.username;
			centerPopUp(form);
			PopUpManager.addPopUp(form,UIComponent(Application.application),true);
		}
		private var form:UserAccountForm;
		private var message:LoginMessage;
		public function successCallback(callbackObject:Object):void{
			message.message = callbackObject.message;
			form.update.enabled = true;
			centerPopUp(message);
			PopUpManager.addPopUp(message,UIComponent(Application.application),true);
			PopUpManager.removePopUp(form);
			this.dispatchEvent(new JavascriptServiceEvent(JavascriptServiceEvent.SUCCESS));
		}
		public function errorCallback(callbackObject:Object):void{
			message.message = callbackObject.message;
			centerPopUp(message);
			form.update.enabled = true;
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
		private function updateClick(event:Event):void{
			var domain:String = URLUtil.getServerName(Application.application.url);
			form.update.enabled = false;
			ExternalInterface.call("PermissionManager.sendAccountUpdateRequest",form.previousPassword,form.newPassword,form.confirmPassword,domain);
		}
		private function cancelClick(event:Event):void{
			PopUpManager.removePopUp(UIComponent(event.currentTarget));
		}
		private function resize(event:ResizeEvent):void{
			centerPopUp(UIComponent(event.currentTarget));
		}
	}
}