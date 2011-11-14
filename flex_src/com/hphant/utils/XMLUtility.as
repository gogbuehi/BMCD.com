package com.hphant.utils
{
	public class XMLUtility
	{
		public function XMLUtility()
		{
		}
		
		public static function insertBlankNode(xmlList:XMLList):void{
			for each(var node:XML in xmlList){
				if(node.children().length()==0){
					node.setChildren(XML(""));
				}
			}
		}
		public static function formatEmptyNodes(xml:XMLList):String{
			var step1:Array = xml.toXMLString().split("/>");
			var newString:String = "";
			for(var i:uint=0;i<step1.length-1;i++){
				var step2:Array = String(step1[i]).split("<");
				var head:String = String(step2.pop());
				var step3:Array = head.split(" ");
				newString += String(step1[i])+"></"+step3[0]+">";
			}
			newString += String(step1.pop());
			return newString;
		}
	}
}