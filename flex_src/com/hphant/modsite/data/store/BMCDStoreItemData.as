package com.hphant.modsite.data.store
{
	import com.hphant.modsite.data.DataItem;
	import com.hphant.utils.Logger;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;

	public class BMCDStoreItemData extends EventDispatcher
	{
		public static function setHeader(tdList:XMLList):void{
		//	if(!_headerSet){
				_headerSet = true;
				_header = new Object();
				for each(var td:XML in tdList){
					_header[String(td)]=td;
				}
		//	}
		}
		private static var _headerSet:Boolean = false;
		private static var _header:Object = new Object();
		public static function get headers():Object{return _header;}
		public static function getHeaderIndex(name:String):int{
			return XML(_header[name]).childIndex();
		}
		public static const names:Object = {			url:"URL",
														id:"ID",
														brand:"Brand",
														title:"Title",
														price:"Price",
														options:"Options",
														mfca:"M/F/C/A",
														email:"EmailLeadsTo",
														sale:"Sale",
														images:"Images",
														thumb:"Thumb",
														short:"Short Description",
														category:"Category",
														long:"Long Description"
														};
														
		private static function stringToDate(date:String):Date{
			var s:String = String(date);
			return new Date(s);
		}
		public function BMCDStoreItemData()
		{
			super(this);
		}
		public function copy():BMCDStoreItemData{
			var c:BMCDStoreItemData = new BMCDStoreItemData();
			c.row = this.row;
			c.selected = this.selected;
			c.selectedOption = this.selectedOption;
			c.quantity = this.quantity;
			return c;
		}
		public static function get supplemental():XMLList{return _supplemental;}
		public static function set supplemental(value:XMLList):void{
			_supplemental = value;
		}
		private static var _supplemental:XMLList;
		private var _dataItemDictionarey:Object = new Object();
		private function getRowData(label:String):DataItem{
			var di:DataItem = (_dataItemDictionarey[label]) ? _dataItemDictionarey[label] : new DataItem();
			_dataItemDictionarey[label] = di;
			di.label = label;
			try{
				di.data = XML(this._row.td[XML(BMCDStoreItemData._header[label]).childIndex()]).children();
			} catch(e:Error){
				log(label+" : "+e.message,1);
			}
			return di;
		}
		private function setRowData(item:DataItem):void{
			var td:XML = this._row.td[XML(BMCDStoreItemData._header[item.label]).childIndex()];
			td.setChildren(item.data);
			this.dispatchEvent(new Event("rowChanged"));
		}
		
		[Bindable(event="rowChanged")]
		public function get url():DataItem{	return this.getRowData(BMCDStoreItemData.names.url);}
		public function set url(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get id():DataItem{	return this.getRowData(BMCDStoreItemData.names.id);}
		public function set id(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get brand():DataItem{	return this.getRowData(BMCDStoreItemData.names.brand);}
		public function set brand(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get title():DataItem{	return this.getRowData(BMCDStoreItemData.names.title);}
		public function set title(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get options():DataItem{	return this.getRowData(BMCDStoreItemData.names.options);}
		public function set options(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get mfca():DataItem{	return this.getRowData(BMCDStoreItemData.names.mfca);}
		public function set mfca(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get sale():DataItem{	return this.getRowData(BMCDStoreItemData.names.sale);}
		public function set sale(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get thumb():DataItem{	return this.getRowData(BMCDStoreItemData.names.thumb);}
		public function set thumb(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get images():DataItem{	return this.getRowData(BMCDStoreItemData.names.images);}
		public function set images(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get price():DataItem{	return this.getRowData(BMCDStoreItemData.names.price);}
		public function set price(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get short():DataItem{	return this.getRowData(BMCDStoreItemData.names.short);}
		public function set short(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get long():DataItem{	return this.getRowData(BMCDStoreItemData.names.long);}
		public function set long(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get email():DataItem{	return this.getRowData(BMCDStoreItemData.names.email);}
		public function set email(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get category():DataItem{	return this.getRowData(BMCDStoreItemData.names.category);}
		public function set category(value:DataItem):void{this.setRowData(value);}
		
		public static function get urlTemplates():XMLList{return _urlTemplates;}
		public static function set urlTemplates(value:XMLList):void{
			_urlTemplates = value;
		}
		private static var _urlTemplates:XMLList;
		
		[Bindable(event="rowChanged")]
		[Inspectable]
		public function get row():XML{return this._row;}
		public function set row(value:XML):void{
			if(this._row != value){
				this._row = value;
				this.selected = (this._row.@selected=="selected") ? true : false;
				this.dispatchEvent(new Event("rowChanged"));
			}
		}
		private var _row:XML;
		
		[Inspectable]
		[Bindable]
		public var selected:Boolean;
		[Inspectable]
		[Bindable]
		public var selectedOption:XML;
		
		[Bindable(event="quantityChanged")]
		public function get quantity():Number{return this._quantity;}
		public function set quantity(value:Number):void{
			this._quantity = value;
			this.dispatchEvent(new Event("quantityChanged"));
		}
		private var _quantity:Number = 0;
		
		
		public override function toString():String{
			var s:String = "[BMCDStoreItemData id="+this.id.data+"]";
			return s;
		}
		
		private function log(message:Object,level:int=0):void{
			Logger.log(this.toString()+" "+message,level);
		}
	}
}