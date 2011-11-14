package com.hphant.renderers
{
	import mx.controls.listClasses.IListItemRenderer;

	public interface IVListItemRenderer extends IListItemRenderer
	{
		function get hRuleStyleName():String;
		function set hRuleStyleName(value:String):void;
		function get suggestionsStyleName():String;
		function set suggestionsStyleName(value:String):void;
	}
}