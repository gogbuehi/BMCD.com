package com.hphant.contentlibrary.process
{
	import com.hphant.components.AlertPallet;
	import com.hphant.constants.ImageConstants;
	import com.hphant.contentlibrary.control.event.CropEvent;
	import com.hphant.contentlibrary.model.Crop;
	import com.hphant.contentlibrary.model.Master;
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
	public class NewCropProcess extends EventDispatcher implements IImageProcess, IResponder
	{
		public function NewCropProcess()
		{
			super(this);
		}
		
		private var _master:Master;
		private var _crop:Crop;
		private var _manager:ImageCropperManager = new ImageCropperManager();	
		
		private var _pallet:ICropPallet;
		public function get pallet():ICropPallet{
			return this._pallet;
		}
		public function set pallet(value:ICropPallet):void{
			this._pallet = value;
			//this._pallet.cropSizes = cropSizes;
		}
		
		[Bindable]
		[Inspectable]
		public var cropSizes:Array = ImageConstants.CROP_SIZES;
		
		private function commitCrop(event:Event):void
		{
			log("Commit Image");
			_crop = new Crop();
			try{
			this._crop.dimensionHeight = this._pallet.cropSize.selectedItem.height;//.imageCropperInfo.imageData).height;
			this._crop.dimensionWidth = this._pallet.cropSize.selectedItem.width;//.lastImageCropperEvent.imageCropperInfo.imageData).width;
			} catch (e:Error){
				
			}
			this._crop.masterId = _master.id;
			this._crop.cropLocation = String(this._manager.cropURL);
			this._crop.scale = this._manager.imageCropper.lastCropperEvent.cropperInfo.scale;
			this._crop.offsetX = this._manager.imageCropper.lastCropperEvent.cropperInfo.offsetX;
			this._crop.offsetY = this._manager.imageCropper.lastCropperEvent.cropperInfo.offsetY;
			this._crop.rotation = this._manager.imageCropper.lastCropperEvent.cropperInfo.rotation;
			try{
				this._crop.shortDescription = this.pallet.html;
			} catch(e:Error){
				this._crop.shortDescription = "";
				log("The description was not specified for this crop.",1);
			}
			try{
				this._crop.alternate = this.pallet.alternate;
			} catch(e:Error){
				this._crop.alternate = "";
				log("The alternate text was not specified for this crop.",1);
			}
			try{
				this._crop.title = this.pallet.title;
			} catch(e:Error){
				this._crop.title = "";
				log("The title text was not specified for this crop.",1);
			}
			if(!this._crop.shortDescription || !this._crop.title || !this._crop.alternate){
				var alert:AlertPallet = AlertPallet.show("Please enter the"+
														(!this._crop.title ? " title"+(!this._crop.shortDescription || !this._crop.alternate ? "," : "") : "")+
														(!this._crop.alternate ? " alternate"+(!this._crop.shortDescription ? "," : "") : "")+
														(!this._crop.shortDescription ? " description" : "")+" text for this crop.",
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
				var newCrop:CropEvent = new CropEvent(CropEvent.ADD_CROP);
				newCrop.data = this._crop;
				newCrop.responder = this;
				newCrop.dispatch();
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
			try{
				this._master = Master(event.currentTarget.data);
				this.pallet.html = this._master.shortDescription;
				this.pallet.alternate = this._master.alternate;
				this.pallet.title = this._master.title;
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
				this._manager.imageCropper.loadPhoto(this._master.masterLocation,
														ImageConstants.CROP_SIZES[0].width,
														ImageConstants.CROP_SIZES[0].height,
														100,
														0,
														0,
														0);
			} catch (e:Error){
				log(e,2);
			}
		}
		public function cropStep(event:Event):void{
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
		public function thumbStep(event:Event):void{
			log("Thumb Step should not be entered for creating a new Crop.",3);
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
			commitCrop(event);
		}
		private function handleMasterReady(event:ImageCropperManagerEvent):void{
			if(this._manager){
				this._manager.removeEventListener(ImageCropperManagerEvent.MASTER_LOAD_COMPLETE,this.handleMasterReady);
				try{
					this._manager.imageCropper.setCropSize(this._pallet.cropSize.selectedItem.width,
														this._pallet.cropSize.selectedItem.height);
				} catch(e:Error){
					log(e,1);
				}
			}
				var v:CropPalletView = this.pallet.getView();
				v.select = false;
				v.description = true;
				v.size = true;
				v.crop = true;
				v.thumb = false;
				v.save = false;
				v.image = true;
				v.selectDone = true;
				this.pallet.setView(v);
		}
		
		private function handleCropReady(event:ImageCropperManagerEvent):void{
			this._manager.removeEventListener(ImageCropperManagerEvent.CROP_UPLOAD_COMPLETE,this.handleCropReady);
				var v:CropPalletView = this.pallet.getView();
				v.select = false;
				v.description = true;
				v.size = true;
				v.crop = true;
				v.thumb = false;
				v.save = true;
				v.image = true;
				v.cropDone = true;
				this.pallet.setView(v);
		}
		public function handleResult(event:GeneralEvent, result:Object)	: void 
		{
			var alert:AlertPallet = AlertPallet.show("New Crop sucessfully created.",
														 "Success",
														 Alert.OK,
														 Alert.OK);
			
			this._master = null;
			log(event);
			this._manager.removeEventListener(ImageCropperManagerEvent.CROP_UPLOAD_COMPLETE,this.handleCropReady);
			this._manager.removeEventListener(ImageCropperManagerEvent.MASTER_LOAD_COMPLETE,this.handleMasterReady);
			this.dispatchEvent(new Event(Event.COMPLETE));
		}
			
		public function handleFault (event:GeneralEvent, fault:Fault)	: void
		{
			var alert:AlertPallet = AlertPallet.show("New Crop creation failed. Please try again.",
														 "Creation Failed",
														 Alert.OK,
														 Alert.OK);
				var v:CropPalletView = this.pallet.getView();
				v.select = false;
				v.description = true;
				v.size = true;
				v.crop = true;
				v.thumb = false;
				v.save = true;
				v.image = true;
				this.pallet.setView(v);
			
			log(event);
		}
		protected function log(message:Object,level:uint=0):void{
			Logger.log("[NewCropProcess] "+message,level)
		}
		
	}
}