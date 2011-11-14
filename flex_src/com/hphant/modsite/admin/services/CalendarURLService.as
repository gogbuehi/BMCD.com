package com.hphant.modsite.admin.services
{
	import com.hphant.data.control.event.CalendarEvent;
	import com.hphant.data.model.CalendarRecord;
	import com.hphant.remoting.GeneralEvent;
	import com.hphant.remoting.IResponder;
	import com.hphant.services.LinkGeneratorService;
	
	import mx.rpc.Fault;

	public class CalendarURLService extends LinkGeneratorService implements IResponder
	{
		public function CalendarURLService()
		{
			super();
			this.label = "Calendar";
			this.idLabel = "MM/DD/YYYY";
		}
		
		private var storedID:String;
		public override function generate(id:Object):void{
			this.storedID = String(id);
			var event:CalendarEvent = new CalendarEvent(CalendarEvent.GET_ALL);
			event.responder = this;
			event.dispatch();
		}
		public function handleFault(event:GeneralEvent, fault:Fault):void{
			this.errorCallback({message:'Evvent Not Found on '+storedID});
		}
		public function handleResult(event:GeneralEvent, result:Object):void{
			for each(var record:CalendarRecord in result){
				if(record.date == this.storedID){
					this.successCallback({message:record.url});
					return;
				}
			}
			this.errorCallback({message:'Evvent Not Found on '+storedID});
		}
		
	}
}