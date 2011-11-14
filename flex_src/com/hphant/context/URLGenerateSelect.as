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
	public class URLGenerateSelect extends EventDispatcher
	{
		public function URLGenerateSelect()
		{
			super(this);
			this._menuItem = new ContextMenuItem("Generate URL");
			this.generator = LinkGeneratorManager.getInstance().generator;
			this.generator.styleName = "menuTreePopup";
			this.dispatchEvent(new Event("menuItemCahged"));
			this.menuItem.addEventListener(ContextMenuEvent.MENU_ITEM_SELECT,this.itemSelected);
		}
		private function urlSelected(event:URLEvent):void{
			PopUpManager.removePopUp(this.generator);
			this.generator.removeEventListener(URLEvent.URL_SELECT,urlSelected);
			this.dispatchEvent(new URLEvent(URLEvent.URL_SELECT,event.data));
		}
		private function itemSelected(event:ContextMenuEvent):void{
			this.generator.addEventListener(URLEvent.URL_SELECT,urlSelected);
			PopUpManager.addPopUp(this.generator,Application(Application.application),true);
			this.generator.x = Application(Application.application).mouseX-this.generator.width/2;
			this.generator.y = Application(Application.application).mouseY-this.generator.height/2;
		}
		[Bindable("menuItemCahged")]
		public function get menuItem():ContextMenuItem{
			return _menuItem;
		}
		private var _menuItem:ContextMenuItem;
		private var urlEvent:URLEvent;
		private var generator:LinkGenerator;
	}
}