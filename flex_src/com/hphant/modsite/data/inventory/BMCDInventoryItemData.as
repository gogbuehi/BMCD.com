package com.hphant.modsite.data.inventory
{
	import com.hphant.modsite.data.DataItem;
	import com.hphant.utils.Logger;
	
	import flash.events.EventDispatcher;

	public class BMCDInventoryItemData extends EventDispatcher
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
		public static const names:Object = {url:"URL",
														dealership:"Dealership",
														id:"UniqueID",
														year:"Year",
														make:"Make",
														model:"Model",
														vin:"VIN",
														stockNumber:"StockNumber",
														engine:"Engine",
														transmission:"Transmission",
														description:"Description",
														mileage:"Mileage",
														price:"Price",
														color:"Color",
														dealerAddress:"DealerAddress",
														dealerCity:"DealerCity",
														dealerState:"DealerState",
														dealerZip:"DealerZipcode",
														dealerPhone:"DealerPhone",
														email:"EmailLeadsTo",
														photo:"PhotoURL",
														equipment:"Equipment",
														dealerMessage:"DealerMessage",
														certified:"Certified",
														highOctane:"HighOctane",
														highOctane360:"HighOctane360",
														highOctaneMultiPhotos:"HighOctaneMultiPhotos",
														retailPrice:"RetailPrice",
														dealerBlurb:"DealerBlurb",
														multiplePhotos:"MultiplePhotos",
														addDate:"AddDate"};
														
		private static function stringToDate(date:String):Date{
			var s:String = String(date);
			return new Date(s);
		}
		public function BMCDInventoryItemData()
		{
			super(this);
		}
		public static function get supplemental():XMLList{return _supplemental;}
		public static function set supplemental(value:XMLList):void{
			_supplemental = value;
			Logger.log('[BMCDInventoryItemData Class] supplemental: '+value);
		}
		private static var _supplemental:XMLList;
		private var _dataItemDictionarey:Object = new Object();
		private function getRowData(label:String):DataItem{
			var di:DataItem = (_dataItemDictionarey[label]) ? _dataItemDictionarey[label] : new DataItem();
			_dataItemDictionarey[label] = di;
			di.label = label;
			try{
				di.data = XML(this._row.td[XML(BMCDInventoryItemData._header[label]).childIndex()]).children();
				if(label==BMCDInventoryItemData.names.multiplePhotos||label==BMCDInventoryItemData.names.photo){
					var reg:RegExp = /\/images\/\d{6}-XXXXXX/g;
					di.data = XML(XML(di.data).toXMLString().replace(reg,''));
				}
			} catch(e:Error){
				log(label+" : "+e.message,1);
			}
			return di;
		}
		private function setRowData(item:DataItem):void{
			var td:XML = this._row.td[XML(BMCDInventoryItemData._header[item.label]).childIndex()];
			td.setChildren(item.data);
			this.dispatchEvent(new Event("rowChanged"));
		}
		
		[Bindable(event="rowChanged")]
		public function get url():DataItem{	return this.getRowData(BMCDInventoryItemData.names.url);}
		public function set url(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get dealership():DataItem{	return this.getRowData(BMCDInventoryItemData.names.dealership);}
		public function set dealership(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get id():DataItem{	return this.getRowData(BMCDInventoryItemData.names.id);}
		public function set id(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get year():DataItem{	return this.getRowData(BMCDInventoryItemData.names.year);}
		public function set year(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get make():DataItem{	return this.getRowData(BMCDInventoryItemData.names.make);}
		public function set make(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get model():DataItem{	return this.getRowData(BMCDInventoryItemData.names.model);}
		public function set model(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get vin():DataItem{	return this.getRowData(BMCDInventoryItemData.names.vin);}
		public function set vin(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get stockNumber():DataItem{	return this.getRowData(BMCDInventoryItemData.names.stockNumber);}
		public function set stockNumber(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get engine():DataItem{	return this.getRowData(BMCDInventoryItemData.names.engine);}
		public function set engine(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get transmission():DataItem{	return this.getRowData(BMCDInventoryItemData.names.transmission);}
		public function set transmission(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get description():DataItem{	return this.getRowData(BMCDInventoryItemData.names.description);}
		public function set description(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get mileage():DataItem{	return this.getRowData(BMCDInventoryItemData.names.mileage);}
		public function set mileage(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get price():DataItem{	return this.getRowData(BMCDInventoryItemData.names.price);}
		public function set price(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get color():DataItem{	return this.getRowData(BMCDInventoryItemData.names.color);}
		public function set color(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get dealerAddress():DataItem{	return this.getRowData(BMCDInventoryItemData.names.dealerAddress);}
		public function set dealerAddress(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get dealerCity():DataItem{	return this.getRowData(BMCDInventoryItemData.names.dealerCity);}
		public function set dealerCity(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get dealerState():DataItem{	return this.getRowData(BMCDInventoryItemData.names.dealerState);}
		public function set dealerState(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get dealerZip():DataItem{	return this.getRowData(BMCDInventoryItemData.names.dealerZip);}
		public function set dealerZip(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get dealerPhone():DataItem{	return this.getRowData(BMCDInventoryItemData.names.dealerPhone);}
		public function set dealerPhone(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get email():DataItem{	return this.getRowData(BMCDInventoryItemData.names.email);}
		public function set email(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get photo():DataItem{	return this.getRowData(BMCDInventoryItemData.names.photo);}
		public function set photo(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get equipment():DataItem{	return this.getRowData(BMCDInventoryItemData.names.equipment);}
		public function set equipment(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get dealerMessage():DataItem{return this.getRowData(BMCDInventoryItemData.names.dealerMessage);}
		public function set dealerMessage(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get certified():DataItem{return this.getRowData(BMCDInventoryItemData.names.certified);}
		public function set certified(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get highOctane():DataItem{return this.getRowData(BMCDInventoryItemData.names.highOctane);}
		public function set highOctane(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get highOctane360():DataItem{return this.getRowData(BMCDInventoryItemData.names.highOctane360);}
		public function set highOctane360(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get highOctaneMultiPhotos():DataItem{return this.getRowData(BMCDInventoryItemData.names.highOctaneMultiPhotos);}
		public function set highOctaneMultiPhotos(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get retailPrice():DataItem{return this.getRowData(BMCDInventoryItemData.names.retailPrice);}
		public function set retailPrice(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get dealerBlurb():DataItem{return this.getRowData(BMCDInventoryItemData.names.dealerBlurb);}
		public function set dealerBlurb(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get multiplePhotos():DataItem{return this.getRowData(BMCDInventoryItemData.names.multiplePhotos);}
		public function set multiplePhotos(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get addDate():DataItem{return this.getRowData(BMCDInventoryItemData.names.addDate);}
		public function set addDate(value:DataItem):void{this.setRowData(value);}
		
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
		
		
		
		
		public override function toString():String{
			var s:String = "[BMCDInventoryItemData vin="+this.vin.data+"]";
			return s;
		}
		
		private function log(message:Object,level:int=0):void{
			Logger.log("[BMCDInventoryItemData] "+message,level);
		}
	}
}