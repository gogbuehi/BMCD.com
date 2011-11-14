package com.hphant.contentlibrary.process.steps
{
	import com.hphant.contentlibrary.view.NewImagePallet;
	import com.hphant.events.StepEvent;
	import com.hphant.utils.Logger;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	[Event(name="executed",type="com.hphant.events.StepEvent")]
	[Event(name="complete",type="flash.events.Event")]
	public class BaseImageStep extends EventDispatcher
	{
		public function BaseImageStep(){
			super(this);
		}
		public function execute():void{
			this.dispatchEvent(new StepEvent(StepEvent.EXECUTE));
		}
		public function complete():void{
			this.dispatchEvent(new Event(Event.COMPLETE));
		}
		public function setView():void{
			try{
				view.selectButton.enabled = select;
				view.thumbButton.enabled = thumb;
				view.cropButton.enabled = crop;
				view.saveButton.enabled = save;
				view.cropSize.enabled = size;
				view.descriptionButton.enabled = description;
				view.imageCrop.enabled = cropper;
			} catch(e:Error){
				log(e,2);
			}
		}
		[Inspectable]
		public var stepName:String = "BaseImageStep";
		[Inspectable]
		public var view:NewImagePallet;
		[Inspectable]
		public var select:Boolean;
		[Inspectable]
		public var thumb:Boolean;
		[Inspectable]
		public var crop:Boolean;
		[Inspectable]
		public var save:Boolean;
		[Inspectable]
		public var size:Boolean;
		[Inspectable]
		public var description:Boolean;
		[Inspectable]
		public var cropper:Boolean;
	}
	protected function log(message:Object,level:uint=0):void{
		Logger.log("["+this.stepName+"] "+message,level);
	}
}