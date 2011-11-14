package com.hphant.modsite.admin.services
{
	
	import com.hphant.data.control.event.ModelEvent;
	import com.hphant.data.model.ModelRecord;
	import com.hphant.remoting.GeneralEvent;
	import com.hphant.remoting.IResponder;
	import com.hphant.services.LinkGeneratorService;
	
	import mx.rpc.Fault;
	import mx.utils.StringUtil;

	public class ModelInfoURLService extends LinkGeneratorService implements IResponder
	{
		public function ModelInfoURLService()
		{
			super();
			this.label = "Model Info";
			this.idLabel = "Make, Model, Submodel";
		}
		private var storedID:String;
		public override function generate(id:Object):void{
			this.storedID = String(id);
			var event:ModelEvent = new ModelEvent(ModelEvent.GET_ALL);
			event.responder = this;
			event.dispatch();
		}
		public function handleFault(event:GeneralEvent, fault:Fault):void{
			this.errorCallback({message:storedID+' Not Found'});
		}
		public function handleResult(event:GeneralEvent, result:Object):void{
			var modelArray:Array = this.storedID.split(',');
			for each(var record:ModelRecord in result){
				var compareString:String = StringUtil.trim(record.make);
				compareString = compareString+(modelArray.length>1 ? ', '+StringUtil.trim(record.model) : '');
				compareString = compareString+(modelArray.length>2 ? ', '+StringUtil.trim(record.submodel) : '');
				if(compareString == this.storedID){
					this.successCallback({message:record.url});
					return;
				}
			}
			this.errorCallback({message:storedID+' Not Found'});
		}
		
	}
}