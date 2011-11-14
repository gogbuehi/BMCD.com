package com.hphant.utils
{
	import flash.events.KeyboardEvent;
	import flash.net.SharedObject;
	
	public class Logger
	{
		private static var _log:Array = ["["+new Date().toTimeString()+"] [Info] Log Started"];
		private static var _types:Array = ["Info","Warning","Error","Fatel"];
		public static const TRACE:String = "trace";
		public static const FILE:String = "file";
		public static const OFF:String = "off";
		public static var MAX_LINES:uint = 500;
		public static var logType:String = OFF;
		
		public static function log(message:String,level:uint=0):void{
			if(!_logObject){
				_logObject = SharedObject.getLocal("loggerData","/");
				_logObject.flush();
			}
			if(!_logObject.data.logType){
				_logObject.data.logType = logType;	
			} else {
				logType = _logObject.data.logType;
			}
			if(logType==TRACE || logType==FILE){
				var d:Date = new Date();
				var split:Array = message.split("\n");
				for each (var part:String in split){
					var line:String = "["+d.getHours()+":"+d.getMinutes()+":"+d.getSeconds()+":"+d.getMilliseconds()+"] ["+_types[level]+"] "+part+"";
					_log.push(line);
					while(_log.length>MAX_LINES){
						_log.shift();
					}
					if(logType==TRACE)
						trace(line);
				}
			}
			_logObject.data.log = _log;
		}
		public static function publish(path:String):void{
			log("Publishing log to "+path);
			log("Logger publisher not implimented",1);
			if(!_logObject){
				_logObject = SharedObject.getLocal("loggerData","/");
			}
			_logObject.flush();
		}
		public function Logger(){
			throw new Error("The Logger Class can't be instantiated.");
		}
		
		private static var _logKey:String = "flashlogger";
		private static var _logLoc:String = "";
		private static var _logObject:SharedObject;
		public static function logKeyListener(event:KeyboardEvent):void{
			var changed:Boolean = false;
			_logLoc+=String.fromCharCode(event.charCode);
			if(String(_logKey+OFF).indexOf(_logLoc)==0 || String(_logKey+FILE).indexOf(_logLoc)==0 || String(_logKey+TRACE).indexOf(_logLoc)==0){
				if(String(_logKey+OFF)==_logLoc){
					logType=OFF;
					changed = true;
				} else if(String(_logKey+FILE)==_logLoc){
					logType=FILE;
					changed = true;
				} else if(String(_logKey+TRACE)==_logLoc){
					logType=TRACE;
					changed = true;
				}
			} else {
				_logKey = "";
			}
			if(changed){
				if(!_logObject){
					_logObject = SharedObject.getLocal("loggerData","/");
				}
				_logObject.data.logType = logType;
				_logObject.flush();
			}
		}
	}
}