package com.hphant.modsite.site.style
{
	import flash.text.StyleSheet;
	
	public class CSSInstance
	{
		private static var _css:StyleSheet;
		public function CSSInstance()
		{
		}
		public static function set css(value:StyleSheet):void{
			_css = value;
		}
		public static function get css():StyleSheet{
			return _css;
		}
	}
}