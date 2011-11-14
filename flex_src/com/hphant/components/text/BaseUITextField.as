package com.hphant.components.text
{
	import flash.text.TextFormat;
	
	import mx.core.UITextField;
	import mx.core.mx_internal;
	
	use namespace mx_internal;
	
	public class BaseUITextField extends UITextField
	{
		public function BaseUITextField()
		{
			super();
		}
		/* private var ss:StyleSheet;
		private function removeStyleSheet():void{
			ss = this.styleSheet;
			this.styleSheet = null;
		}
		private function replaceStyleSheet():void{
			if(!ss){
				ss = new StyleSheet();
				ss.setStyle("a",{textDecoration:"underline"});
			}
			this.styleSheet = ss;
		}
		public override function set defaultTextFormat(format:TextFormat):void{
			removeStyleSheet();
			super.defaultTextFormat = format;
			replaceStyleSheet();
		}
		public override function get defaultTextFormat():TextFormat{
			removeStyleSheet();
			var tf:TextFormat = super.defaultTextFormat;
			replaceStyleSheet();
			return tf;
		} */
		public override function set htmlText(value:String):void{
			XML.prettyPrinting = false;
			XML.ignoreWhitespace = false;
			super.htmlText = value.split("<a").join("<u><a").split("<A").join("<u><a").split("</a>").join("</a></u>").split("</A>").join("</a></u>");
			
		}
		public override function get htmlText():String{
			XML.prettyPrinting = false;
			XML.ignoreWhitespace = false;
			var html:String = super.htmlText.split("<u><a").join("<a").split("<U><A").join("<a").split("</a></u>").join("</a>").split("</A></U>").join("</a>");
			return html;
		}
	}
}