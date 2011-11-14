package com.hphant.modsite.admin.services
{
	import com.hphant.data.control.event.InventoryEvent;
	import com.hphant.data.model.InventoryRecord;
	import com.hphant.remoting.GeneralEvent;
	import com.hphant.remoting.IResponder;
	import com.hphant.services.LinkGeneratorService;
	
	import mx.rpc.Fault;

	public class InventoryURLService extends LinkGeneratorService implements IResponder
	{
		public function InventoryURLService()
		{
			super();
			this.label = "Inventory";
			this.idLabel = "Stock Number";
		}
		private var storedID:String;
		public override function generate(id:Object):void{
			this.storedID = String(id);
			var event:InventoryEvent = new InventoryEvent(InventoryEvent.GET_ALL);
			event.responder = this;
			event.dispatch();
		}
		public function handleFault(event:GeneralEvent, fault:Fault):void{
			this.errorCallback({message:'Vehicle Not Found matching '+storedID});
		}
		public function handleResult(event:GeneralEvent, result:Object):void{
			for each(var record:InventoryRecord in result){
				if(record.stockNumber == this.storedID){
					this.successCallback({message:record.url});
					return;
				}
			}
			this.errorCallback({message:'Vehicle Not Found matching '+storedID});
		}
		
	}
}