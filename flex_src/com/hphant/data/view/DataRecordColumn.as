package com.hphant.data.view
{
	import com.hphant.remoting.GeneralEvent;
	import com.hphant.utils.StringUtils;
	
	import flash.events.Event;
	
	import mx.controls.dataGridClasses.DataGridColumn;
	import mx.core.ClassFactory;
	import mx.core.IFactory;
	
	
	public class DataRecordColumn extends DataGridColumn
	{
		public function DataRecordColumn(columnName:String=null)
		{
			super(columnName);
			if(!_renderer){
				this.itemRenderer = new ClassFactory(DataRecordColumnRenderer);
			}
		}
		private var _pName:String;
		[Bindable(event="propertyNameChanged")]
		[Inspectable]
		public function set propertyName(value:String):void{
			this._pName = value;
			this.headerText = (this._headerText>"") ? this._headerText : StringUtils.camelToWord(value ? value : "noName");
			setIRProps();
			this.dispatchEvent(new Event("propertyNameChanged"));
		}
		public function get propertyName():String{
			return _pName;
		}
		private var _pType:String;
		[Bindable(event="propertyTypeChanged")]
		[Inspectable]
		public function set propertyType(value:String):void{
			this._pType = value;
			setIRProps();
			this.dispatchEvent(new Event("propertyTypeChanged"));
		}
		public function get propertyType():String{
			return _pType;
		}
		[Bindable("itemRendererChanged")]
    	[Inspectable(category="Other")]
		public override function set itemRenderer(value:IFactory):void{
			_renderer = value;
			super.itemRenderer = value;
			setIRProps();
		}
		public override function get itemRenderer():IFactory{
			return super.itemRenderer;
		}
		private var _renderer:IFactory;
		private function setIRProps():void{
			if(this.itemRenderer){
				var props:Object = ClassFactory(this.itemRenderer).properties;
				if(!props){
					props = new Object();
				}
				props.propertyType = this._pType;
				props.propertyName = this._pName;
				props.eventClass = this._eventClass;
				props.options = this._options;
				ClassFactory(this.itemRenderer).properties = props;
			}
		}
		
		[Bindable]
		[Inspectable]
		public function set eventClass(value:Class):void{
			_eventClass = value;
			setIRProps();
		}
		public function get eventClass():Class{
			return _eventClass;
		}
		private var _eventClass:Class;
		
		[Bindable]
		[Inspectable]
		public override function set headerText(value:String):void{
			_headerText = value;
			super.headerText = value;
		}
		public override function get headerText():String{
			return _headerText;
		}
		private var _headerText:String;
		
		[Bindable]
		[Inspectable]
		public function set options(value:Array):void{
			_options = value;
			setIRProps();
		}
		public function get options():Array{
			return _options;
		}
		private var _options:Array;
	}
}