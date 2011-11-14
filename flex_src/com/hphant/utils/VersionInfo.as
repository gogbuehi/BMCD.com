package com.hphant.utils
{
	import flash.events.Event;
	import flash.net.URLLoader;
	import flash.net.URLLoaderDataFormat;
	import flash.net.URLRequest;

	public class VersionInfo extends URLLoader
	{
		public function VersionInfo(request:URLRequest=null)
		{
			this.dataFormat = URLLoaderDataFormat.VARIABLES;
			super(request);
			this.addEventListener(Event.COMPLETE,this.infoLoaded);
		}
		[Bindable]
		public var major:int = 0;
		[Bindable]
		public var minor:int = 0;
		[Bindable]
		public var revision:int = 0;
		[Bindable]
		public var build:int = 0;
		[Bindable]
		public var date:String = "";
		[Bindable]
		public var swf:String = "";
		
		private function infoLoaded(event:Event):void{
			var vars:Array = String(this.data).split("\n");
			var key:String;
			for each(key in vars) {
				var prop:Array = key.split("=");
				switch(prop[0]){
					case "major":
						major = prop[1];
					break;
					case "minor":
						minor = prop[1];
					break;
					case "revision":
						revision = prop[1];
					break;
					case "build":
						build = prop[1];
					break;
					case "build.date":
						date = prop[1];
					break;
					case "swf":
						swf = prop[1];
					break;
				}
            }
			Logger.log("[VersionInfo] SWF='"+swf+"',");
			Logger.log("              Version="+major+"."+minor+"."+revision+"."+build+",");
			Logger.log("              BuildDate='"+date+"'");	
		}
		
	}
}