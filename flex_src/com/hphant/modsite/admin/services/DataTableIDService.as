package com.hphant.modsite.admin.services
{
	import com.hphant.utils.Logger;
	
	import flash.events.EventDispatcher;
	
	import mx.collections.ArrayCollection;
	
	public class DataTableIDService extends EventDispatcher
	{
		public function DataTableIDService()
		{
			super(this);
			if(instance)
				throw new Error('Singleton, Use EventDispatcher.getInstance()');
		}
		private static var instance:DataTableIDService;
		public static function getInstance():DataTableIDService{
			if(!instance)
				instance = new DataTableIDService();
			return instance;
		}
		public static function addTable(table:XML,force:Boolean = false):void{
			var id:String = String(table.@id);
			log('Adding table with ID('+id+')');
			if(id){
				var parts:Array = id.split('_');
				if(parts[parts.length-1]!='0' || force){
					var idArray:ArrayCollection = ArrayCollection(getInstance().ids[parts[0]]);
					if(idArray){
						if(!idArray.contains(table)){
							idArray.addItem(table);
						}
					} else {
						idArray = new ArrayCollection();
						idArray.addItem(table);
						getInstance().ids[parts[0]] = idArray;
					}
					var nid:String = parts[0]+'_'+(idArray.getItemIndex(table)+1);
					log('Changing added table with ID('+table.@id+') to ID('+nid+')');
					table.@id = nid;
				}
			}
		}
		public static function removeTable(table:XML):void{
			var id:String = String(table.@id);
			log('Removing table with ID('+id+')');
			if(id){
				var parts:Array = id.split('_');
				var idArray:ArrayCollection = ArrayCollection(getInstance().ids[parts[0]]);
				if(idArray){
					if(!idArray.contains(table)){
						idArray.removeItemAt(idArray.getItemIndex(table));
						for each(var tbl:XML in idArray){
							var oid:String = String(tbl.@id);
							tbl.@id = parts[0]+'_'+(idArray.getItemIndex(tbl)+1);
							log('Changing table with ID('+oid+') to ID('+tbl.@id+')');
						}
					}
					log('Changing removed table with ID('+table.@id+') to ID('+parts[0]+')');
					table.@id = parts[0];
				}
			}
		}
		public static function printIDs():String{
			var s:String = '';
			for(var i:String in getInstance().ids){
				s+= i.toUpperCase()+' TABLE IDs:\n';
				for each(var table:XML in ArrayCollection(getInstance().ids[i])){
					s += '\t'+table.@id + '\n';
				}
			}
			return s;
		}
		public static function reset():void{
			getInstance().ids = new Object();
		}
		protected static function log(message:Object,level:uint=0):void{
			Logger.log('[DataTableIDService] '+message,level);
		}
		private var ids:Object = new Object();

	}
}