package com.hphant.modsite.data.interfaces
{
	public interface ISuplimemtTranslator
	{
		function translate(xml:XML):XML;
		function setHeader(table:XMLList):void
		function quickTranslate(xml:XML):XML
	}
}