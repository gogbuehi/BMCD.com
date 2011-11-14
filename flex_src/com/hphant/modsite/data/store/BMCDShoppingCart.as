package com.hphant.modsite.data.store
{
	import com.hphant.modsite.site.assets.store.events.MAStoreEvent;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	
	import mx.formatters.CurrencyFormatter;
	[Event(name="addToCart",type="com.hphant.modsite.site.assets.store.events.MAStoreEvent")]
	[Event(name="removeFromCart",type="com.hphant.modsite.site.assets.store.events.MAStoreEvent")]
	[Event(name="clearCart",type="com.hphant.modsite.site.assets.store.events.MAStoreEvent")]
	public class BMCDShoppingCart extends EventDispatcher
	{
		public function BMCDShoppingCart()
		{
			super(this);
			if(BMCDShoppingCart._instance){
				throw new Error("Only one instance of this class may exist. Use BMCDShoppingCart.getInstance()");
			}
		}
		private static var _instance:BMCDShoppingCart;
		public static function getInstance():BMCDShoppingCart{
			if(!_instance){
				_instance = new BMCDShoppingCart();
			}
			return _instance;
		}
		public function clear():void{
			this._items = new Object();
			this._totalItems = 0;
			this._totalPrice = 0;
			this.dispatchEvent(new MAStoreEvent(MAStoreEvent.CLEAR_CART,null));
		}
		private var _items:Object = new Object();
		public function addItem(item:BMCDStoreItemData):void{
			var nm:String = item.id.data+"_"+item.selectedOption;
			if(!_items[nm]){
				_items[nm] = item.copy();
				calculateTotals();
				BMCDStoreItemData(_items[nm]).addEventListener("quantityChanged",this.reportQuantityChanged);
			} else {
				_items[nm].quantity+=item.quantity;
			}
			this.dispatchEvent(new Event("itemsChanged"));
			this.dispatchEvent(new MAStoreEvent(MAStoreEvent.ADD_TO_CART,item.row));
		}
		public function removeItem(item:BMCDStoreItemData,quantity:int=0):void{
			var nm:String = item.id.data+"_"+item.selectedOption;
			
			if(_items[nm] && !quantity){
				_items[nm] = null;
				calculateTotals();
			} else if(_items[nm]) {
				_items[nm].quantity-=quantity;
			} else {
				return;
			}
			this.dispatchEvent(new Event("itemsChanged"));
			this.dispatchEvent(new MAStoreEvent(MAStoreEvent.REMOVE_FROM_CART,item.row));
		}
		private function reportQuantityChanged(event:Event):void{
			calculateTotals();
			this.dispatchEvent(new Event("itemsChanged"));
		}
		[Bindable(event="itemsChanged")]
		public function get items():Array{
			var itms:Array = new Array();
			for each(var data:BMCDStoreItemData in _items){
				if(data){
					itms.push(data);
				}
			}
			return itms;
		}
		private function calculateTotals():void{
			this._totalItems = 0;
			this._totalPrice = 0;
			for each(var data:BMCDStoreItemData in _items){
				if(data){
					this._totalItems+=data.quantity;
					this._totalPrice+=data.quantity*Number(data.price.data);
				}
			}
				
		}
		private var _totalItems:int = 0;
		private var _totalPrice:Number = 0;
		public function get totalItems():int{
			return this._totalItems;
		}
		public function get totalPrice():Number{
			return this._totalPrice;
		}
		public function cartToData():XML{
			var dataList:XML = <tbody />;
			var cf:CurrencyFormatter = new CurrencyFormatter();
			cf.precision = 2;
			cf.useThousandsSeparator = true;
			var dataHead:XML = <tr />;
			dataHead.appendChild(toTD("<strong><em>PID</em></strong>"));
		//	dataHead.appendChild(toTD("Size"));
		//	dataHead.appendChild(toTD("Color"));
			dataHead.appendChild(toTD("<strong><em>Title</em></strong>"));
		//	dataHead.appendChild(toTD("Thumbnail"));
		//	dataHead.appendChild(toTD("Main Image"));
		//	dataHead.appendChild(toTD("URL"));
		//	dataHead.appendChild(toTD("Brand"));
		//	dataHead.appendChild(toTD("M/F/C/A"));
		//	dataHead.appendChild(toTD("Sale"));
		//	dataHead.appendChild(toTD("Short Description"));
		//	dataHead.appendChild(toTD("Long Description"));
		//	dataHead.appendChild(toTD("Category"));
			dataHead.appendChild(toTD("<strong><em>Qty</em></strong>"));
			dataHead.appendChild(toTD("<strong><em>Unit Price</em></strong>"));
			dataHead.appendChild(toTD("<strong><em>Line Total</em></strong>"));
			for each(var item:BMCDStoreItemData in this._items){
				if(item){
					var d:XML = <tr />;
					d.appendChild(toTD(item.selectedOption.td[0].toString()));
			//		d.appendChild(toTD(item.selectedOption.td[1].toString()));
			//		d.appendChild(toTD(item.selectedOption.td[2].toString()));
					d.appendChild(toTD(String(item.title.data)));
			//		d.appendChild(toTD("<img src='"+String(item.thumb.data)+"' />"));
			//		d.appendChild(toTD(String(XML(XMLList(item.images.data)[0]).toXMLString())));
			//		d.appendChild(toTD(String(item.url.data)));
			//		d.appendChild(toTD(String(item.brand.data)));
			//		d.appendChild(toTD(String(item.mfca.data)));
			//		d.appendChild(toTD(String(item.sale.data)));
			//		d.appendChild(toTD(String(item.short.data)));
			//		d.appendChild(toTD(String(item.long.data)));
			//		d.appendChild(toTD(String(item.category.data)));
					d.appendChild(toTD(String(item.quantity)));
					d.appendChild(toTD(cf.format(Number(item.price.data))));
					d.appendChild(toTD('<strong><em>'+cf.format(Number(item.price.data)*item.quantity)+'</em></strong>'));
					dataList.appendChild(d);
				}
			}
			return XML("<table width='599' border='1'>"+dataHead.toXMLString()+dataList.children().toXMLString()+"</table>");
		}
		private function toTD(value:String):XML{
			return XML("<th scope='col'>"+value+"</th>");	
		}
	}
}