package com.hphant.modsite.site.assets.interfaces
{
	import flash.text.StyleSheet;
	
	public interface IMAsset
	{
		function set xml(value:XMLList):void;
		function get xml():XMLList;
		function set css(value:StyleSheet):void;
		function get css():StyleSheet;
	}
}