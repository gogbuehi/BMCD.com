package com.hphant.utils
{
	public class StringUtils
	{
		public static function wordToCamel(word:String):String{
			var camel:String = "";
			for(var i:uint=0;i<word.length;i++){
				var char:String = word.charAt(i);
				var spaceFound:Boolean = char == " ";
				while(char == " " && i<word.length-1){
					i++;
					char = word.charAt(i);
				}
				
				if(camel.length==0 || !spaceFound){
					camel += char.toLowerCase();
				} else {
					camel += char.toUpperCase();
				}
			}
			return camel;
		}
		public static function camelToWord(camel:String):String{
			var word:String = "";
			for(var i:uint=0;i<camel.length;i++){
				var char:String = camel.charAt(i);
				while(char == " " && i<camel.length-1){
					i++;
					char = camel.charAt(i);
				}
				var code:Number = camel.charCodeAt(i);
				if(word.length==0){
					word += char.toUpperCase();
				} else if(code<91 && code>64){
					word += " "+char.toUpperCase();
				} else {
					word += char;
				}
			}
			return word;
		}
	}
}