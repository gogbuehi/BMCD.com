package com.hphant.contentlibrary.process
{
	import com.hphant.components.AlertPallet;
	import com.hphant.configurators.ImageCropperConfigurator;
	import com.hphant.contentlibrary.control.event.VideoEvent;
	import com.hphant.contentlibrary.model.Video;
	import com.hphant.contentlibrary.view.CropPalletView;
	import com.hphant.contentlibrary.view.ICropPallet;
	import com.hphant.events.ImageCropperManagerEvent;
	import com.hphant.managers.ImageCropperManager;
	import com.hphant.remoting.GeneralEvent;
	import com.hphant.remoting.IResponder;
	import com.hphant.utils.Logger;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	
	import mx.controls.Alert;
	import mx.rpc.Fault;
	[Event(name="complete",type="flash.events.Event")]
	public class EditVideoProcess extends EventDispatcher implements IImageProcess, IResponder
	{
		public function EditVideoProcess()
		{
			super(this);
		}
		private var _master:Video;
		private var _manager:ImageCropperManager = new ImageCropperManager();	
		
		private var _pallet:ICropPallet;
		public function get pallet():ICropPallet{
			return this._pallet;
		}
		public function set pallet(value:ICropPallet):void{
			this._pallet = value;
		}
		private function commitMaster(event:Event):void
		{
			log("Commit Video");
			try{
				this._master.height = this._manager.imageCropper.masterBitmapData.height;//.imageCropperInfo.imageData).height;
				this._master.width = this._manager.imageCropper.masterBitmapData.width;//.lastImageCropperEvent.imageCropperInfo.imageData).width;
			} catch (e:Error){
				
			}
			this._master.thumbnailLocation = String(this._manager.cropURL);
			this._master.scale = this._manager.imageCropper.lastCropperEvent.cropperInfo.scale;
			this._master.offsetX = this._manager.imageCropper.lastCropperEvent.cropperInfo.offsetX;
			this._master.offsetY = this._manager.imageCropper.lastCropperEvent.cropperInfo.offsetY;
			this._master.rotation = this._manager.imageCropper.lastCropperEvent.cropperInfo.rotation;
			this._master.offsetSeconds = this._manager.imageCropper.lastCropperEvent.cropperInfo.time;
			try{
				this._master.description = this.pallet.html;
			} catch(e:Error){
				this._master.description = "";
				log("The description was not specified for this video.",1);
			}
			try{
				this._master.alternate = this.pallet.alternate;
			} catch(e:Error){
				this._master.alternate = "";
				log("The alternate text was not specified for this video.",1);
			}
			try{
				this._master.title = this.pallet.title;
			} catch(e:Error){
				this._master.title = "";
				log("The title text was not specified for this video.",1);
			}
			if(!this._master.description || !this._master.title || !this._master.alternate){
				var alert:AlertPallet = AlertPallet.show("Please enter the"+
														(!this._master.title ? " title"+(!this._master.description || !this._master.alternate ? "," : "") : "")+
														(!this._master.alternate ? " alternate"+(!this._master.description ? "," : "") : "")+
														(!this._master.description ? " description" : "")+" text for this video.",
														 "No Description",
														 Alert.OK,
														 Alert.OK);
				var v:CropPalletView = this.pallet.getView();
				v.select = false;
				v.description = true;
				v.size = false;
				v.crop = true;
				v.thumb = false;
				v.save = true;
				v.image = true;
				this.pallet.setView(v);
			} else {
				var newImage:VideoEvent = new VideoEvent(VideoEvent.UPDATE_VIDEO);
				newImage.data = this._master;
				newImage.responder = this;
				newImage.dispatch();
			}

		}
		public function selectStep(event:Event):void{
			log("Select step called");
		}
		public function resetStep(event:Event):void{
			this._manager.removeEventListener(ImageCropperManagerEvent.CROP_UPLOAD_COMPLETE,this.handleCropReady);
			this._manager.removeEventListener(ImageCropperManagerEvent.MASTER_LOAD_COMPLETE,this.handleMasterReady);
			var v:CropPalletView = new CropPalletView();
			this.pallet.setView(v);
		}
		public function loadStep(event:Event):void{
			log("Load step called");
			if(event.currentTarget.data is Video){
				this._master = Video(event.currentTarget.data);
				this.pallet.html = this._master.description;
				this.pallet.title = this._master.title;
				this.pallet.alternate = this._master.alternate;
				var v:CropPalletView = this.pallet.getView();
				v.select = false;
				v.description = false;
				v.size = false;
				v.crop = false;
				v.thumb = false;
				v.save = false;
				v.image = false;
				v.cropDone = false;
				v.selectDone = false;
				this.pallet.setView(v);
				this._manager.imageCropper = ICropPallet(event.currentTarget).imageCrop;
				this._manager.addEventListener(ImageCropperManagerEvent.MASTER_LOAD_COMPLETE,this.handleMasterReady);
				this._manager.imageCropper.loadPhoto(this._master.location,
														ImageCropperConfigurator.WIDTH_THUMB,
														ImageCropperConfigurator.HEIGHT_THUMB,
														this._master.scale,
														this._master.rotation,
														this._master.offsetX,
														this._master.offsetY,
														this._master.offsetSeconds);
			}
		}
		public function cropStep(event:Event):void{
			log("Crop Step should not be entered for editing a Video.",3);
		}
		public function thumbStep(event:Event):void{
			var v:CropPalletView = this.pallet.getView();
				v.select = false;
				v.description = false;
				v.size = false;
				v.crop = false;
				v.thumb = false;
				v.save = false;
				v.image = false;
				this.pallet.setView(v);
			this._manager.addEventListener(ImageCropperManagerEvent.CROP_UPLOAD_COMPLETE,this.handleCropReady);
			this._manager.imageCropper.commitCrop();
		}
		public function saveStep(event:Event):void{
			var v:CropPalletView = this.pallet.getView();
				v.select = false;
				v.description = false;
				v.size = false;
				v.crop = false;
				v.thumb = false;
				v.save = false;
				v.image = false;
				this.pallet.setView(v);
			commitMaster(event);
		}
		private function handleMasterReady(event:ImageCropperManagerEvent):void{
			this._manager.removeEventListener(ImageCropperManagerEvent.MASTER_LOAD_COMPLETE,this.handleMasterReady);
				var v:CropPalletView = this.pallet.getView();
				v.select = false;
				v.description = true;
				v.size = false;
				v.crop = false;
				v.thumb = true;
				v.save = false;
				v.image = true;
				this.pallet.setView(v);
		}
		
		private function handleCropReady(event:ImageCropperManagerEvent):void{
			this._manager.removeEventListener(ImageCropperManagerEvent.CROP_UPLOAD_COMPLETE,this.handleCropReady);
				var v:CropPalletView = this.pallet.getView();
				v.select = false;
				v.description = true;
				v.size = false;
				v.crop = false;
				v.thumb = true;
				v.save = true;
				v.image = true;
				v.thumbDone = true;
				this.pallet.setView(v);
		}
		public function handleResult(event:GeneralEvent, result:Object)	: void 
		{
			var alert:AlertPallet = AlertPallet.show("Video sucessfully updated.",
														 "Success",
														 Alert.OK,
														 Alert.OK);
			log(event);
			this._manager.removeEventListener(ImageCropperManagerEvent.CROP_UPLOAD_COMPLETE,this.handleCropReady);
			this._manager.removeEventListener(ImageCropperManagerEvent.MASTER_LOAD_COMPLETE,this.handleMasterReady);
			this.dispatchEvent(new Event(Event.COMPLETE));
		}
			
		public function handleFault (event:GeneralEvent, fault:Fault)	: void
		{
				var v:CropPalletView = this.pallet.getView();
				v.select = false;
				v.description = true;
				v.size = false;
				v.crop = false;
				v.thumb = true;
				v.save = true;
				v.image = true;
				this.pallet.setView(v);
			var alert:AlertPallet = AlertPallet.show("Video update failed. Please try again.",
														 "Update Failed",
														 Alert.OK,
														 Alert.OK);
			log(event);
		}
		protected function log(message:Object,level:uint=0):void{
			Logger.log("[EditVideoProcess] "+message,level)
		}
		
	}
}