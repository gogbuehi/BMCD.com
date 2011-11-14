package com.hphant.modsite.site.assets.containers.interfaces
{
	import mx.core.IContainer;
	import mx.core.IUIComponent;
	import mx.styles.IStyleClient;
	[Event(name="dropComplete",type="com.hphant.modsite.site.events.SiteBodyDropEvent")]
	public interface ISiteBody extends IUIComponent, IContainer, IStyleClient
	{
		function get dragEnabled():Boolean;
		function set dragEnabled(value:Boolean):void;
	}
}