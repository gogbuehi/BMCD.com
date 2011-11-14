package com.hphant.remoting
{
	import com.adobe.cairngorm.control.CairngormEvent;

	
	public class GeneralEvent extends CairngormEvent {
		
		public var responder : IResponder;
		

		public function GeneralEvent( type : String, bubbles : Boolean = false, cancelable : Boolean = false )
		{
			super( type, bubbles, cancelable );
		}
		
	}

}