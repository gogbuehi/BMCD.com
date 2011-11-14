package com.hphant.managers
{
	import com.hphant.components.imageCropper.ICropper;
	import com.hphant.configurators.ImageCropperConfigurator;
	import com.hphant.contentlibrary.control.ContentModelLocator;
	import com.hphant.events.ICropperEvent;
	import com.hphant.events.ImageCropperEvent;
	import com.hphant.events.ImageCropperManagerEvent;
	import com.hphant.utils.Logger;
	import com.hphant.utils.UploadPostHelper;
	
	import flash.events.DataEvent;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.HTTPStatusEvent;
	import flash.events.IEventDispatcher;
	import flash.events.IOErrorEvent;
	import flash.events.ProgressEvent;
	import flash.events.SecurityErrorEvent;
	import flash.net.FileFilter;
	import flash.net.FileReference;
	import flash.net.URLLoader;
	import flash.net.URLLoaderDataFormat;
	import flash.net.URLRequest;
	import flash.net.URLRequestHeader;
	import flash.net.URLRequestMethod;
	import flash.net.URLVariables;
	import flash.utils.ByteArray;
	
	import mx.graphics.codec.PNGEncoder;
	[Event(name="masterSelected",type="com.hphant.events.ImageCropperManagerEvent")]
	[Event(name="masterUploadStart",type="com.hphant.events.ImageCropperManagerEvent")]
	[Event(name="masterUploadError",type="com.hphant.events.ImageCropperManagerEvent")]
	[Event(name="masterUploadComplete",type="com.hphant.events.ImageCropperManagerEvent")]
	[Event(name="masterLoadStart",type="com.hphant.events.ImageCropperManagerEvent")]
	[Event(name="masterLoadError",type="com.hphant.events.ImageCropperManagerEvent")]
	[Event(name="masterLoadComplete",type="com.hphant.events.ImageCropperManagerEvent")]
	[Event(name="cropReady",type="com.hphant.events.ImageCropperManagerEvent")]
	[Event(name="cropUploadStarted",type="com.hphant.events.ImageCropperManagerEvent")]
	[Event(name="cropUploadError",type="com.hphant.events.ImageCropperManagerEvent")]
	[Event(name="cropUploadComplete",type="com.hphant.events.ImageCropperManagerEvent")]
	
	
	/**
	 * 	Class for:
	 * 	- selecting & uploading raw image to the server.
	 *	- uploading image's crops to the server.
	 */	
	public class ImageCropperManager extends EventDispatcher 
	{

		//	config values	
       	private var ic	:ICropper;
       	
       	//	optional callback params, being called on file selection 
       	public  var callbackParams : Object;

		//	helper values       	
       	private var fileRef		: FileReference;
		private var uploadReq	: URLRequest;
		private var postVars	:URLVariables;
		private var modelLocator: ContentModelLocator = ContentModelLocator.getInstance();
       	
       	public function get masterURL():String{
       		return this._masterURL;
       	}
		private var _masterURL:String = "";
       	public function get cropURL():String{
       		return this._cropURL;
       	}
		private var _cropURL:String = "";
		/**
		 * 	Constructor
		 */	
		public function ImageCropperManager()  
		{
			super(this);
		}
		[Inspectable]
		[Bindable(event="imageCropperChanged")]
		public function get imageCropper():ICropper{
			return this.ic;
		}
		public function set imageCropper(value:ICropper):void{
			if(this.ic!=value){
				if(this.ic){
					this.unregisterEventListeners();
				}
				this.ic = value;
				if(this.ic){
					this.registerEventListeners();
				}
				this.dispatchEvent(new Event("imageCropperChanged"));
			}
		}
		

		/**
		 * 	@private
		 * 
		 * 	Block:
		 * 
		 * 	FileReference Configuration and support methods..
		 * 
		 */	
	  	public function uploadFileReference():void
    	{
        	fileRef = new FileReference();
        	configureFRListeners(fileRef);
        	fileRef.browse(getTypes());
    	}
	 
		private function configureFRListeners(dispatcher:IEventDispatcher):void {
            dispatcher.addEventListener(Event.SELECT, selectHandler);
            dispatcher.addEventListener(Event.CANCEL, cancelHandler);
            dispatcher.addEventListener(Event.COMPLETE, completeHandler);
            dispatcher.addEventListener(Event.OPEN, openHandler);
            dispatcher.addEventListener(ProgressEvent.PROGRESS, progressHandler);
            dispatcher.addEventListener(HTTPStatusEvent.HTTP_STATUS, httpStatusHandler);
            dispatcher.addEventListener(IOErrorEvent.IO_ERROR, ioErrorHandler);
            dispatcher.addEventListener(SecurityErrorEvent.SECURITY_ERROR, securityErrorHandler);
            dispatcher.addEventListener(DataEvent.UPLOAD_COMPLETE_DATA, uploadCompleteDataHandler);
        }
		
        private function getTypes():Array {
            var allTypes:Array = new Array(getImageTypeFilter(), getTextTypeFilter());
            return allTypes;
        }

        private function getImageTypeFilter():FileFilter {
            return new FileFilter("Images (*.jpg, *.jpeg, *.gif, *.png)", "*.jpg;*.jpeg;*.gif;*.png");
        }

        private function getTextTypeFilter():FileFilter {
            return new FileFilter("Text Files (*.txt, *.rtf)", "*.txt;*.rtf");
        }

        private function selectHandler(event:Event):void {
            var file:FileReference = FileReference(event.target);
            this.dispatchEvent(new ImageCropperManagerEvent(ImageCropperManagerEvent.MASTER_SELECTED));
            startProgressIndication();
            uploadReq = new URLRequest();
			uploadReq.method = URLRequestMethod.POST;
        	uploadReq.url = ImageCropperConfigurator.UPLOAD_SERVICE_ROOT_URL +
        					ImageCropperConfigurator.UPLOAD_SERVICE_NAME;
            this.postVars = new URLVariables();
            postVars.options  = "OPTIONS";
            postVars.session_key = modelLocator.sessionKey;
            log("selectHandler: name=" + file.name + "  URL=" + uploadReq.url);
            log("Setting the session key to '"+postVars.session_key+"'");
            uploadReq.data = postVars;
			
            
            file.upload(uploadReq);
            this.dispatchEvent(new ImageCropperManagerEvent(ImageCropperManagerEvent.MASTER_UPLOAD_START));
        }

        private function cancelHandler(event:Event):void {
            log("cancelHandler: " + event);
            stopProgressIndication();
        }

        private function completeHandler(event:Event):void {
            log("completeHandler: " + event);
           
        }

        private function uploadCompleteDataHandler(event:DataEvent):void {
            stopProgressIndication();
            log("uploadCompleteData: " + event);
            log("event.data: " + event.data);
            //	Parse event.data for actual image URL.
            var xml:XML = new XML( event.data );
            //	error-detecting
            if (xml.error[0].toString().length > 0) {
            	log("Error occured during image uploading:\n"+xml.error[0], 2);
           		this.dispatchEvent(new ImageCropperManagerEvent(ImageCropperManagerEvent.MASTER_UPLOAD_ERROR));
            	//Alert.show( "Error occured during image uploading:\n"+xml.error[0], "Error" );
            	return;
            }
           	this.dispatchEvent(new ImageCropperManagerEvent(ImageCropperManagerEvent.MASTER_UPLOAD_COMPLETE));
            var url:String = xml.value[0];
            this._masterURL = url;
            ic.loadPhoto( url, ImageCropperConfigurator.WIDTH_CROP, ImageCropperConfigurator.HEIGHT_CROP );
           	this.dispatchEvent(new ImageCropperManagerEvent(ImageCropperManagerEvent.MASTER_LOAD_START));
        }

        private function httpStatusHandler(event:HTTPStatusEvent):void {
            log("httpStatusHandler: " + event);
        }
        
        private function ioErrorHandler(event:IOErrorEvent):void {
           	log("ioErrorHandler: " + event,2);
            this.dispatchEvent(new ImageCropperManagerEvent(ImageCropperManagerEvent.MASTER_UPLOAD_ERROR));
           // Alert.show( event.text, "Error" );
        }

        private function openHandler(event:Event):void {
            log("openHandler: " + event);
        }

        private function progressHandler(event:ProgressEvent):void {
            var file:FileReference = FileReference(event.target);
            log("progressHandler name=" + file.name + " bytesLoaded=" + event.bytesLoaded + " bytesTotal=" + event.bytesTotal);
        }

        private function securityErrorHandler(event:SecurityErrorEvent):void {
            log("securityErrorHandler: " + event,2);
           // Alert.show( event.text, "Error" );
        }

		private function startProgressIndication():void{ic.spinner.play();}
		private function stopProgressIndication():void{ic.spinner.stop();}

		private function registerEventListeners():void
		{
			this.ic.addEventListener(ImageCropperEvent.CONTENT_READY, handlerICContentReady);
			this.ic.addEventListener(ImageCropperEvent.MASTER_READY, handlerICMasterReady);
		}
		private function unregisterEventListeners():void
		{
			this.ic.removeEventListener(ImageCropperEvent.CONTENT_READY, handlerICMasterReady);
			this.ic.addEventListener(ImageCropperEvent.MASTER_READY, handlerICMasterReady);
		}

		/**
		 *	Event handler fires when ImageCropper fires ImageCropperEvent.CONTENT_READY event.
		 *	This is where crop-file upload happens. 
		 */
		private function handlerICContentReady(e:ICropperEvent):void
		{
			var obj:Object = e.cropperInfo;
			log("INFO: things are working");
			var myPNGEncoder:PNGEncoder = new PNGEncoder();
			var myPNG:ByteArray = myPNGEncoder.encode(obj.imageData);
			var ba:ByteArray = myPNG;
			var d:Date = new Date();
			
			
			var request:URLRequest = new URLRequest();
			request.method = URLRequestMethod.POST;
			request.url =	ImageCropperConfigurator.UPLOAD_SERVICE_ROOT_URL +
        						ImageCropperConfigurator.UPLOAD_SERVICE_NAME;//+
        						//"?s="+d.getUTCMilliseconds();
        						// +
        					//"?" +
        					//"&" - makes ioError +
        					//"session_key="+ modelLocator.sessionKey;// + ";" +
        					//"s="+d.getUTCMilliseconds();
        	
			request.contentType = 'multipart/form-data; boundary=' + UploadPostHelper.getBoundary();
			request.requestHeaders.push( new URLRequestHeader( 'Cache-Control', 'no-cache' ) );
			//request.data = UploadPostHelper.getPostData("temp.png", ba);
			request.data = UploadPostHelper.getPostData("temp.png", ba, {session_key: modelLocator.sessionKey} );
			
			var urlLoader:URLLoader = new URLLoader();
			urlLoader.dataFormat = URLLoaderDataFormat.BINARY;
			urlLoader.addEventListener(Event.COMPLETE, function():void{ stopProgressIndication(); } );
			urlLoader.addEventListener(Event.COMPLETE, urlLoadCompleteHandler);
			urlLoader.addEventListener(HTTPStatusEvent.HTTP_STATUS, urlLoaderStatusHandler);
            urlLoader.addEventListener(IOErrorEvent.IO_ERROR, urlLoadIoErrorHandler);
            urlLoader.addEventListener(SecurityErrorEvent.SECURITY_ERROR, urlLoadSecurityErrorHandler);
			//urlLoader.dataFormat = URLLoaderDataFormat.BINARY;
			
			// Final call to laod URL
			startProgressIndication();
			urlLoader.load(request);
            this.dispatchEvent(new ImageCropperManagerEvent(ImageCropperManagerEvent.CROP_UPLOAD_STARTED));
		}
		/**
		 *	Event handler fires when ImageCropper fires ImageCropperEvent.MASTER_READY event.
		 *	This is where crop-file upload happens. 
		 */
		 private function handlerICMasterReady(e:ICropperEvent):void{
            this.dispatchEvent(new ImageCropperManagerEvent(ImageCropperManagerEvent.MASTER_LOAD_COMPLETE));
		 }
		
		private function urlLoadCompleteHandler(e:Event):void{
			log("Crop Upload Complete = " + e.currentTarget.data);
			var xml:XML = new XML( e.currentTarget.data );
            //	error-detecting
            if (xml.error[0].toString().length > 0) {
            	log("Error occured during image uploading:\n"+xml.error[0], 2);
           		this.dispatchEvent(new ImageCropperManagerEvent(ImageCropperManagerEvent.CROP_UPLOAD_ERROR));
            	//Alert.show( "Error occured during image uploading:\n"+xml.error[0], "Error" );
            	return;
            }
            var url:String = xml.value[0];
			this._cropURL = url;
            this.dispatchEvent(new ImageCropperManagerEvent(ImageCropperManagerEvent.CROP_UPLOAD_COMPLETE));
		}
		
		private function urlLoadIoErrorHandler(e:Event):void{
			log("Crop Upload IO Error = " + e.currentTarget.data);
            this.dispatchEvent(new ImageCropperManagerEvent(ImageCropperManagerEvent.CROP_UPLOAD_ERROR));
		}
		private function urlLoadSecurityErrorHandler(e:Event):void{
			log("Crop Upload Security Error = " + e.currentTarget.data);
            this.dispatchEvent(new ImageCropperManagerEvent(ImageCropperManagerEvent.CROP_UPLOAD_ERROR));
		}
		
		private function urlLoaderStatusHandler(e:HTTPStatusEvent):void
		{
			log("HTTP Status = " + e.status);	
		}
		protected function log(message:Object,level:uint=0):void{
			Logger.log("[ManagerImageCropper] "+message,level);
		}	
	}
}