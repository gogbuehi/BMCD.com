package com.hphant.modsite.data.calendar
{
	import com.hphant.modsite.data.DataItem;
	import com.hphant.utils.Logger;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;

	public class BMCDEventItemData extends EventDispatcher
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
														title:"Title",
														blurb:"Blurb",
														description:"Description",
														start:"Start Time",
														end:"End Time",
														date:"Date",
														thumb:"Thumb",
														images:"Images",
														location:"Location Name",
														street:"Street",
														city:"City",
														state:"State",
														map:"Map",
														zip:"ZIP"
														};
														
		private static function stringToDate(date:String):Date{
			var s:String = String(date);
			return new Date(s);
		}
		public function BMCDEventItemData()
		{
			super(this);
		}
		public function copy():BMCDEventItemData{
			var c:BMCDEventItemData = new BMCDEventItemData();
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
				di.data = XML(this._row.td[XML(BMCDEventItemData._header[label]).childIndex()]).children();
			} catch(e:Error){
				log(label+" : "+e.message,1);
			}
			return di;
		}
		private function setRowData(item:DataItem):void{
			var td:XML = this._row.td[XML(BMCDEventItemData._header[item.label]).childIndex()];
			td.setChildren(item.data);
			this.dispatchEvent(new Event("rowChanged"));
		}
		
		[Bindable(event="rowChanged")]
		public function get url():DataItem{	return this.getRowData(BMCDEventItemData.names.url);}
		public function set url(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get id():DataItem{	return this.getRowData(BMCDEventItemData.names.id);}
		public function set id(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get blurb():DataItem{	return this.getRowData(BMCDEventItemData.names.blurb);}
		public function set blurb(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get title():DataItem{	return this.getRowData(BMCDEventItemData.names.title);}
		public function set title(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get description():DataItem{	return this.getRowData(BMCDEventItemData.names.description);}
		public function set description(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get start():DataItem{	return this.getRowData(BMCDEventItemData.names.start);}
		public function set start(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get end():DataItem{	return this.getRowData(BMCDEventItemData.names.end);}
		public function set end(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get thumb():DataItem{	return this.getRowData(BMCDEventItemData.names.thumb);}
		public function set thumb(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get images():DataItem{	return this.getRowData(BMCDEventItemData.names.images);}
		public function set images(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get location():DataItem{	return this.getRowData(BMCDEventItemData.names.location);}
		public function set location(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get street():DataItem{	return this.getRowData(BMCDEventItemData.names.street);}
		public function set street(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get city():DataItem{	return this.getRowData(BMCDEventItemData.names.city);}
		public function set city(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get state():DataItem{	return this.getRowData(BMCDEventItemData.names.state);}
		public function set state(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get zip():DataItem{	return this.getRowData(BMCDEventItemData.names.zip);}
		public function set zip(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get map():DataItem{	return this.getRowData(BMCDEventItemData.names.map);}
		public function set map(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get date():DataItem{	return this.getRowData(BMCDEventItemData.names.date);}
		public function set date(value:DataItem):void{this.setRowData(value);}
		
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
			var s:String = "[BMCDEventItemData id="+this.id.data+"]";
			return s;
		}
		
		private function log(message:Object,level:int=0):void{
			Logger.log(this.toString()+" "+message,level);
		}
	}
}