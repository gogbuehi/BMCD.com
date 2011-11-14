package com.hphant.modsite.data.modelInfo
{
	import com.hphant.modsite.data.DataItem;
	import com.hphant.utils.Logger;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;

	public class BMCDModelInfoData extends EventDispatcher
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
		public static const names:Object = {			
														url:"URL",
														make:"Make",
														model:"Model",
														submodel:"Sub-Model",
														description:"Description",
														videos:"Videos",
														images:"Images",
														engine:"Engine",
														displacement:"Displacement",
														horsepower:"Horsepower",
														acceleration:"Acceleration",
														topSpeed:"Top Speed",
														msrp:"MSRP",
														brochure:"Brouchure",
														configurtor:"Configurator",
														manufacture:"Manufacturer"
														};
														
		private static function stringToDate(date:String):Date{
			var s:String = String(date);
			return new Date(s);
		}
		public function BMCDModelInfoData()
		{
			super(this);
		}
		public function copy():BMCDModelInfoData{
			var c:BMCDModelInfoData = new BMCDModelInfoData();
			c.row = this.row;
			c.selected = this.selected;
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
				di.data = XML(this._row.td[XML(BMCDModelInfoData._header[label]).childIndex()]).children();
			} catch(e:Error){
				log(label+" : "+e.message,1);
			}
			return di;
		}
		private function setRowData(item:DataItem):void{
			var td:XML = this._row.td[XML(BMCDModelInfoData._header[item.label]).childIndex()];
			td.setChildren(item.data);
			this.dispatchEvent(new Event("rowChanged"));
		}
		
		[Bindable(event="rowChanged")]
		public function get url():DataItem{	return this.getRowData(BMCDModelInfoData.names.url);}
		public function set url(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get make():DataItem{	return this.getRowData(BMCDModelInfoData.names.make);}
		public function set make(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get model():DataItem{	return this.getRowData(BMCDModelInfoData.names.model);}
		public function set model(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get submodel():DataItem{	return this.getRowData(BMCDModelInfoData.names.submodel);}
		public function set submodel(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get description():DataItem{	return this.getRowData(BMCDModelInfoData.names.description);}
		public function set description(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get videos():DataItem{	return this.getRowData(BMCDModelInfoData.names.videos);}
		public function set videos(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get images():DataItem{	return this.getRowData(BMCDModelInfoData.names.images);}
		public function set images(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get engine():DataItem{	return this.getRowData(BMCDModelInfoData.names.engine);}
		public function set engine(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get displacement():DataItem{	return this.getRowData(BMCDModelInfoData.names.displacement);}
		public function set displacement(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get horsepower():DataItem{	return this.getRowData(BMCDModelInfoData.names.horsepower);}
		public function set horsepower(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get acceleration():DataItem{	return this.getRowData(BMCDModelInfoData.names.acceleration);}
		public function set acceleration(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get topSpeed():DataItem{	return this.getRowData(BMCDModelInfoData.names.topSpeed);}
		public function set topSpeed(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get msrp():DataItem{	return this.getRowData(BMCDModelInfoData.names.msrp);}
		public function set msrp(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get brouchure():DataItem{	return this.getRowData(BMCDModelInfoData.names.brouchure);}
		public function set brouchure(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get configurator():DataItem{	return this.getRowData(BMCDModelInfoData.names.configurator);}
		public function set configurator(value:DataItem):void{this.setRowData(value);}
		[Bindable(event="rowChanged")]
		public function get manufacture():DataItem{	return this.getRowData(BMCDModelInfoData.names.manufacture);}
		public function set manufacture(value:DataItem):void{this.setRowData(value);}
		
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
			var s:String = "[BMCDModelInfoData]";
			return s;
		}
		
		private function log(message:Object,level:int=0):void{
			Logger.log(this.toString()+" "+message,level);
		}
	}
}