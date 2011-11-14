package com.hphant.utils
{
	import flash.events.EventDispatcher;
	import flash.utils.Dictionary;
	
	import mx.collections.ArrayCollection;
	import mx.collections.IList;
	import mx.collections.ListCollectionView;
	import mx.events.CollectionEvent;
	import mx.events.CollectionEventKind;
	[Event(name="collectionChanged",type="mx.events.CollectionEvent")]
	public class DataGrouping extends EventDispatcher
	{
		public static const MAX_LENGTH:String = "maxLength";
		public static const PROPERTY:String = "property";
		public function DataGrouping()
		{
			super(this);
		}
		private var _data:IList;
		private var _type:String = DataGrouping.MAX_LENGTH;
		public function set type(value:String):void{
			this._type = value;
		}
		public function get type():String{return this._type;}
		public function set data(value:IList):void{
			if(this._data!=value){
				if(this._data){
					this._data.removeEventListener(CollectionEventKind.REFRESH,this.refreshItems);
					this._data.removeEventListener(CollectionEvent.COLLECTION_CHANGE,this.refreshItems);
				}
				this._data = value;
				if(value){
					if(this.propFilter && this._type==DataGrouping.PROPERTY){
						this.propFilter.sortAll(ListCollectionView(value));
					} 
					value.addEventListener(CollectionEventKind.REFRESH,this.refreshItems);
					value.addEventListener(CollectionEvent.COLLECTION_CHANGE,this.refreshItems);
				}
				this.refreshItems();
			}
		}
		public function get data():IList{return this._data;}
		
		public var maxGroupLength:uint = 10;
		private function refreshItems(event:CollectionEvent=null):void{
			this._groups = new Dictionary();
			if(this._type==DataGrouping.MAX_LENGTH){
				this.refreshItemsByLength();
			} else if(this._type==DataGrouping.PROPERTY){
				this.refreshItemsByProperty();
			} else {
				throw new Error("The type is not an expected value: "+this._type);
			}
			this.dispatchEvent(new CollectionEvent(CollectionEvent.COLLECTION_CHANGE));
		}
		private function refreshItemsByLength():void{
			var groupCount:int = (this._data) ? Math.ceil(this._data.length/this.maxGroupLength) : 0;
			var items:Array = (this._data) ? this._data.toArray() : [];
			
			for(var i:int=0;i<groupCount;i++){
				this._groups[i] = new ArrayCollection(items.slice(i*this.maxGroupLength,(i+1)*this.maxGroupLength));
			}
		}
		private function refreshItemsByProperty():void{
			for each(var i:Object in this._data){
				this.addItemToGroup(i);
			}
		}
		
		public function getGroupByItem(item:Object):ArrayCollection{
			var l:ArrayCollection = null;
			if(this._type==DataGrouping.MAX_LENGTH){
				var id:int = (item) ? this._data.getItemIndex(item) : -1;
				var gid:int = (this._data && id>-1) ? Math.floor(id/this.maxGroupLength) : -1;
				l= (gid > -1) ? ArrayCollection(this._groups[gid]) :null;
			} else if(this._type==DataGrouping.PROPERTY){
				l= this.findGroupByPropOfItem(item);
			} else {
				throw new Error("The type is not an expected value: "+this._type);
			}
			return l;
		}
		private function findGroupByPropOfItem(item:Object):ArrayCollection{
			if(!this.propFilter){throw new Error("propFilter must not be null when using DataGrouping.PROPERTY");}
			return (item) ? ArrayCollection(this._groups[propFilter.getGroupValue(item)]) : null;
		}
		public function getItemIndex(item:Object):int{return (item) ? this._data.getItemIndex(item) : -1;}
		public function getItemIndexInGroup(item:Object):int{
			var ac:ArrayCollection = this.getGroupByItem(item);
			return (ac) ? ac.getItemIndex(item) : -1;
		}
		public function getGroupIndexByItem(item:Object):int{
			var g:ArrayCollection = this.getGroupByItem(item);
			var grps:ArrayCollection = new ArrayCollection(this.groups);
			return (g) ? grps.getItemIndex(g) : -1;
		}
		private function addItemToGroup(item:Object):void{
			if(!this.propFilter){throw new Error("propFilter must not be null when using DataGrouping.PROPERTY");}
			if(item){
				var groupID:Object = propFilter.getGroupValue(item);
				if(!this._groups[groupID]){
					this._groups[groupID] = new ArrayCollection();
				}
				ArrayCollection(this._groups[groupID]).addItem(item);
			}
		}
		[Inspectable]
		public var propFilter:IGroupFilter = null;
		
		private var _groups:Dictionary = new Dictionary(true);
		public function get groups():Array{
			var a:Array = new Array();
			for each(var obj:Object in this._groups){
				a.push(obj);
			}
			if(this.propFilter && this._type==DataGrouping.PROPERTY){
				this.propFilter.sortGroups(a);
			}
			return a;
		}
		
	}
}