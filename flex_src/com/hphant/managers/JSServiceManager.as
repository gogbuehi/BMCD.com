package com.hphant.managers
{
	import com.hphant.utils.Logger;
	
	import flash.external.ExternalInterface;
	
	public class JSServiceManager
	{
		public function JSServiceManager()
		{
			if(instance){
				throw new Error("Singleton, Call JSServiceManager.getInstance()");
			}
			ExternalInterface.addCallback("callbackMethod",callbackMethod);
		}
		private static var instance:JSServiceManager;
		public static function getInstance():JSServiceManager{
			if(!instance){
				instance = new JSServiceManager();
			}
			return instance;
		}
		private var services:Object = new Object();
		public function registerService(serviceName:String,successCallback:Function,errorCallback:Function):void{
			this.services[serviceName] = {success:successCallback,error:errorCallback};
		}
		
		private function callbackMethod(callbackObject:Object):void{
			var service:Object = this.services[callbackObject.serviceName];
		//	{ serviceName: "login", messageType: "info", message: "Login Successful"}
			Logger.log("[JSServiceManager:"+service+"] "+callbackObject.messageType+":"+callbackObject.message);
			if(service){
				if(callbackObject.messageType=="error" || callbackObject.messageType==2){
					service.error(callbackObject);
				} else {
					service.success(callbackObject);
				}
			} else {
				Logger.log("[JSServiceManager] service '"+callbackObject.serviceName+"' not registered.",1);
			}
		}
	}
}