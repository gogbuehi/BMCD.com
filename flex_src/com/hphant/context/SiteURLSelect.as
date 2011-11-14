package com.hphant.context
{
	import com.hphant.components.MenuTree;
	import com.hphant.events.URLEvent;
	
	import flash.events.ContextMenuEvent;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.ui.ContextMenuItem;
	
	import mx.core.Application;
	import mx.managers.PopUpManager;
	[Event(name="urlSelect",type="com.hphant.events.URLEvent")]
	public class SiteURLSelect extends EventDispatcher
	{
		public function SiteURLSelect()
		{
			super(this);
			this._menuItem = new ContextMenuItem("Page URLs");
			this.tree = new MenuTree();
			this.tree.styleName = "menuTreePopup";
			this.dispatchEvent(new Event("menuItemCahged"));
			this.tree.addEventListener(URLEvent.URL_SELECT,urlSelected);
			this.menuItem.addEventListener(ContextMenuEvent.MENU_ITEM_SELECT,this.itemSelected);
		}
		private function urlSelected(event:URLEvent):void{
			PopUpManager.removePopUp(this.tree);
			this.dispatchEvent(new URLEvent(URLEvent.URL_SELECT,event.data));
		}
		private function itemSelected(event:ContextMenuEvent):void{
			PopUpManager.addPopUp(this.tree,Application(Application.application),true);
			this.tree.x = Application(Application.application).mouseX-this.tree.width/2;
			this.tree.y = Application(Application.application).mouseY-this.tree.height/2;
		}
		[Bindable("menuItemCahged")]
		public function get menuItem():ContextMenuItem{
			return _menuItem;
		}
		private var _menuItem:ContextMenuItem;
		private var urlEvent:URLEvent;
		private var tree:MenuTree;
	}
}