package com.hphant.data.control.command
{
	import com.adobe.cairngorm.control.CairngormEvent;
	import com.hphant.data.control.*;
	import com.hphant.data.control.delegate.*;
	import com.hphant.data.control.event.*;
	import com.hphant.remoting.BaseServiceCommand;
	
	import mx.utils.StringUtil;
	

	public class ModelGetByModelCommand extends BaseServiceCommand
	{
		private var modelLocator : DataModelLocator = DataModelLocator.getInstance();
		
		
		override public function execute(event:CairngormEvent):void
		{
			log(this + ".execute(): inside...");
			
			//	storing original event for callbacks 
			evt = event as ModelEvent;
			var make:String = ''; 
			var model:String = '';
			var submodel:String = '';
			log("Model: " + evt.data);
			var modelArray:Array = String(evt.data).split(',');
			make = StringUtil.trim(modelArray[0]);
			model = (modelArray.length>1) ? StringUtil.trim(modelArray[1]) : '';
			submodel = (modelArray.length>2) ? StringUtil.trim(modelArray[2]) : ' ';
			var delegate : ModelDelegate = new ModelDelegate(this);
			delegate.getByModel( modelLocator.sessionKey, make, model, submodel );
		}
		
	}
}