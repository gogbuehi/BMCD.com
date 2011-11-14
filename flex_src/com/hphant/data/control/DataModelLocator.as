package com.hphant.data.control
{
	import com.adobe.cairngorm.*;
	import com.adobe.cairngorm.model.IModelLocator;
	import com.hphant.data.model.*;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.external.ExternalInterface;
	
	import mx.collections.ArrayCollection;
	
	
	/**
	 *	Singleton to store references to all model data used by application.
	 */	
	
	public class DataModelLocator extends EventDispatcher implements IModelLocator {
		
		/**
		* 	Class' static  members.
		*/		
		private static var _instance:DataModelLocator;
		
		public static function getInstance():DataModelLocator {
			if ( !_instance ) {
				_instance = new DataModelLocator();
			}
			return _instance; 
		}
		
		/**
		 * 	Constructor
		 */		
		public function DataModelLocator(){
			super(this);
			if ( _instance )
           	{
           		throw new CairngormError( CairngormMessageCodes.SINGLETON_EXCEPTION, "ModelLocator" );
            }
           	_instance = this;
		}

		
		/**
		* 	Instance members.
		*/
		public function get sessionKey():String{
			var gVars:Object = ExternalInterface.call("getGlobals");
			var sk:String = "SESSSIONKEY";
			try{
				sk = String(gVars.SESSION_KEY);
			}catch(e:Error){
				
			}
			return sk;
		}
		[Bindable(event="listsChanged")]
		public function get lists():Array{
			return [{name:"Inventory",list:_inventory},
				    {name:"Store",list:_store},
				    {name:"Calendar",list:_calendar},
				    {name:"Model Info",list:_models},
				    {name:"Name References",list:_names}]
		}
	
		[ArrayElementType("com.hphant.data.model.InventoryRecord")]
		private var _inventory			: ArrayCollection;
		private var _inventoryById		: Object = new Object();
		
		[Bindable(event="inventoryChanged")]
		[ArrayElementType("com.hphant.data.model.InventoryRecord")]
		public function get inventory():ArrayCollection{
			return this._inventory;
		}
		public function set inventory(value:ArrayCollection):void{
			this._inventoryById = new Object();
			this._inventory = value;
			for each(var i:InventoryRecord in this._inventory){
				this._inventoryById["id_"+i.id] = i;
			}
			this.dispatchEvent(new Event("inventoryChanged"));
			this.dispatchEvent(new Event("listsChanged"));
		}
		public function getInventoryRecordByID(id:Object):InventoryRecord{
			return InventoryRecord(this._inventoryById["id_"+id]);
		}
		
		[ArrayElementType("com.hphant.data.model.StoreRecord")]
		private var _store	: ArrayCollection;
		private var _storeById:Object = new Object();
		[Bindable(event="storeChanged")]
		
		[ArrayElementType("com.hphant.data.model.StoreRecord")]
		public function get store():ArrayCollection{
			return this._store;
		}
		public function set store(value:ArrayCollection):void{
			this._storeById = new Object();
			this._store = value;
			for each(var s:StoreRecord in this._store){
				this._storeById["id_"+s.id] = s;
			}
			this.dispatchEvent(new Event("storeChanged"));
			this.dispatchEvent(new Event("listsChanged"));
		}
		public function getStoreRecordByID(id:Object):StoreRecord{
			return StoreRecord(this._storeById["id_"+id]);
		}
		
		
	
		[ArrayElementType("com.hphant.data.model.ModelRecord")]
		private var _models	: ArrayCollection;
		private var _modelsByID:Object = new Object();
		[Bindable(event="modelsChanged")]
		[ArrayElementType("com.hphant.data.model.ModelRecord")]
		public function get models():ArrayCollection{
			return this._models;
		}
		public function set models(value:ArrayCollection):void{
			this._modelsByID = new Object();
			this._models = value;
			for each(var m:ModelRecord in this._models){
				this._modelsByID["id_"+m.id] = m;
			}
			this.dispatchEvent(new Event("modelsChanged"));
			this.dispatchEvent(new Event("listsChanged"));
		}
		public function getModelRecordByID(id:Object):ModelRecord{
			return ModelRecord(this._modelsByID["id_"+id]);
		}
		
		
	
		[ArrayElementType("com.hphant.data.model.CalendarRecord")]
		private var _calendar	: ArrayCollection;
		private var _calendarByID:Object = new Object();
		[Bindable(event="calendarChanged")]
		[ArrayElementType("com.hphant.data.model.CalendarRecord")]
		public function get calendar():ArrayCollection{
			return this._calendar;
		}
		public function set calendar(value:ArrayCollection):void{
			this._calendarByID = new Object();
			this._calendar = value;
			for each(var c:CalendarRecord in this._calendar){
				this._calendarByID["id_"+c.id] = c;
			}
			this.dispatchEvent(new Event("calendarChanged"));
			this.dispatchEvent(new Event("listsChanged"));
		}
		public function getCalendarRecordByID(id:Object):CalendarRecord{
			return CalendarRecord(this._calendarByID["id_"+id]);
		}
		
	
		[ArrayElementType("com.hphant.data.model.SuggestionsRecord")]
		private var _suggestions	: ArrayCollection;
		private var _suggestionsByID:Object = new Object();
		[Bindable(event="suggestionsChanged")]
		[ArrayElementType("com.hphant.data.model.SuggestionsRecord")]
		public function get suggestions():ArrayCollection{
			return this._suggestions;
		}
		public function set suggestions(value:ArrayCollection):void{
			this._suggestionsByID = new Object();
			this._suggestions = value;
			for each(var s:SuggestionsRecord in this._suggestions){
				this._suggestionsByID["id_"+s.id] = s;
			}
			this.dispatchEvent(new Event("suggestionsChanged"));
			this.dispatchEvent(new Event("listsChanged"));
		}
		public function getSuggestionsRecordByID(id:Object):SuggestionsRecord{
			return SuggestionsRecord(this._suggestionsByID["id_"+id]);
		}
	
	
		[ArrayElementType("com.hphant.data.model.NameReferenceRecord")]
		private var _names	: ArrayCollection;
		private var _namesByID:Object = new Object();
		[Bindable(event="namesChanged")]
		[ArrayElementType("com.hphant.data.model.NameReferenceRecord")]
		public function get names():ArrayCollection{
			return this._names;
		}
		public function set names(value:ArrayCollection):void{
			this._namesByID = new Object();
			this._names = value;
			for each(var n:NameReferenceRecord in this._names){
				this._namesByID["id_"+n.id] = n;
			}
			this.dispatchEvent(new Event("namesChanged"));
			this.dispatchEvent(new Event("listsChanged"));
		}
		public function getNameReferenceRecordByID(id:Object):NameReferenceRecord{
			return NameReferenceRecord(this._namesByID["id_"+id]);
		}
		
	
		[ArrayElementType("com.hphant.data.model.DataFilter")]
		private var _filters	: ArrayCollection;
		private var _filtersByID:Object = new Object();
		[Bindable(event="filtersChanged")]
		[ArrayElementType("com.hphant.data.model.DataFilter")]
		public function get filters():ArrayCollection{
			return this._filters;
		}
		public function set filters(value:ArrayCollection):void{
			this._filtersByID = new Object();
			this._filters = value;
			for each(var f:DataFilter in this._filters){
				this._filtersByID["id_"+f.id] = f;
			}
			this.dispatchEvent(new Event("filtersChanged"));
			this.dispatchEvent(new Event("listsChanged"));
		}
		public function getDataFilterByID(id:Object):DataFilter{
			return DataFilter(this._filtersByID["id_"+id]);
		}
		
		
	}
}