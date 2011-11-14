package com.hphant.context
{
	import com.hphant.components.LinkGenerator;
	import com.hphant.events.URLEvent;
	import com.hphant.managers.LinkGeneratorManager;
	
	import flash.events.ContextMenuEvent;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.ui.ContextMenuItem;
	
	import mx.core.Application;
	import mx.managers.PopUpManager;
	[Event(name="urlSelect",type="com.hphant.events.URLEvent")]
	public class ItemURLSelect extends EventDispatcher
	{
		public function ItemURLSelect()
		{
			super(this);
			this._menuItem = new ContextMenuItem("Item URLs");
			this.tree.styleName = "menuTreePopup";
			this.dispatchEvent(new Event("menuItemCahged"));
			this.menuItem.addEventListener(ContextMenuEvent.MENU_ITEM_SELECT,this.itemSelected);
		}
		private function urlSelected(event:URLEvent):void{
			PopUpManager.removePopUp(this.generator);
			this.generator.removeEventListener(URLEvent.URL_SELECT,urlSelected);
			this.dispatchEvent(new URLEvent(URLEvent.URL_SELECT,event.data));
		}
		private function itemSelected(event:ContextMenuEvent):void{
			this.tree.addEventListener(URLEvent.URL_SELECT,urlSelected);
			PopUpManager.addPopUp(this.generator,Application(Application.application),true);
			this.tree.x = Application(Application.application).mouseX-this.tree.width/2;
			this.tree.y = Application(Application.application).mouseY-this.tree.height/2;
		}
		[Bindable("menuItemCahged")]
		public function get menuItem():ContextMenuItem{
			return _menuItem;
		}
		private var _menuItem:ContextMenuItem;
		private var urlEvent:URLEvent;
		private var tree:DataTree;
	}
}