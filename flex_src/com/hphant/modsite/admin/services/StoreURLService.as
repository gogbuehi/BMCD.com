package com.hphant.modsite.admin.services
{
	import com.hphant.data.control.event.StoreEvent;
	import com.hphant.data.model.StoreRecord;
	import com.hphant.remoting.GeneralEvent;
	import com.hphant.remoting.IResponder;
	import com.hphant.services.LinkGeneratorService;
	
	import mx.rpc.Fault;

	public class StoreURLService extends LinkGeneratorService implements IResponder
	{
		public function StoreURLService()
		{
			super();
			this.label = "Boutique";
			this.idLabel = "Product ID";
		}
		private var storedID:String;
		public override function generate(id:Object):void{
			this.storedID = String(id);
			var event:StoreEvent = new StoreEvent(StoreEvent.GET_ALL);
			event.responder = this;
			event.dispatch();
		}
		public function handleFault(event:GeneralEvent, fault:Fault):void{
			this.errorCallback({message:'Product Not Found matching '+storedID});
		}
		public function handleResult(event:GeneralEvent, result:Object):void{
			for each(var record:StoreRecord in result){
				if(record.productId == this.storedID){
					this.successCallback({message:record.url});
					return;
				}
			}
			this.errorCallback({message:'Product Not Found matching '+storedID});
		}
		
	}
}