package com.hphant.managers
{
	import com.hphant.contentlibrary.control.ContentModelLocator;
	import com.hphant.events.PDFUploadManagerEvent;
	import com.hphant.utils.Logger;
	
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
	import flash.net.URLRequest;
	import flash.net.URLRequestMethod;
	import flash.net.URLVariables;
	
	
	[Event(name="pdfSelected",type="com.hphant.events.PDFUploadManagerEvent")]
	[Event(name="pdfUploadStart",type="com.hphant.events.PDFUploadManagerEvent")]
	[Event(name="pdfUploadError",type="com.hphant.events.PDFUploadManagerEvent")]
	[Event(name="pdfUploadComplete",type="com.hphant.events.PDFUploadManagerEvent")]
	[Event(name="progress",type="flash.events.ProgressEvent")]
	
	
	/**
	 * 	Class for:
	 * 	- selecting & uploading raw image to the server.
	 *	- uploading image's crops to the server.
	 */	
	public class PDFUploadManager extends EventDispatcher 
	{

		
       	
		public static const UPLOAD_SERVICE_ROOT_URL	: String = "/";
		public static const UPLOAD_SERVICE_NAME		: String = "upload";
		
       	//	optional callback params, being called on file selection 
       	public  var callbackParams : Object;

		//	helper values       	
       	private var fileRef		: FileReference;
		private var uploadReq	: URLRequest;
		private var postVars	: URLVariables;
		private var modelLocator: ContentModelLocator = ContentModelLocator.getInstance();
       	
       
		/**
		 * 	Constructor
		 */	
		public function PDFUploadManager()  
		{
			super(this);
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
            var allTypes:Array = new Array(getDocTypeFilter());
            return allTypes;
        }

        private function getDocTypeFilter():FileFilter {
            return new FileFilter("Documents (*.pdf)", "*.pdf;");
        }

        private function selectHandler(event:Event):void {
            var file:FileReference = FileReference(event.target);
            this.dispatchEvent(new PDFUploadManagerEvent(PDFUploadManagerEvent.PDF_SELECTED));
            uploadReq = new URLRequest();
			uploadReq.method = URLRequestMethod.POST;
        	uploadReq.url = UPLOAD_SERVICE_ROOT_URL +
        					UPLOAD_SERVICE_NAME;
            this.postVars = new URLVariables();
            postVars.options  = "OPTIONS";
            postVars.session_key = modelLocator.sessionKey;
            log("selectHandler: name=" + file.name + "  URL=" + uploadReq.url);
            log("Setting the session key to '"+postVars.session_key+"'");
            uploadReq.data = postVars;
			
            
            file.upload(uploadReq);
            this.dispatchEvent(new PDFUploadManagerEvent(PDFUploadManagerEvent.PDF_UPLOAD_START));
        }

        private function cancelHandler(event:Event):void {
            log("cancelHandler: " + event);
            this.dispatchEvent(new PDFUploadManagerEvent(PDFUploadManagerEvent.PDF_UPLOAD_ERROR));
        }

        private function completeHandler(event:Event):void {
            log("completeHandler: " + event);
           
        }

        private function uploadCompleteDataHandler(event:DataEvent):void {
            log("uploadCompleteData: " + event);
            log("event.data: " + event.data);
            //	Parse event.data for actual image URL.
            var xml:XML = new XML( event.data );
            //	error-detecting
            if (xml.error[0].toString().length > 0) {
            	log("Error occured during pdf uploading:\n"+xml.error[0], 2);
           		this.dispatchEvent(new PDFUploadManagerEvent(PDFUploadManagerEvent.PDF_UPLOAD_ERROR));
            	return;
            }
            var url:String = xml.value[0];
            this._url = url;
           	this.dispatchEvent(new PDFUploadManagerEvent(PDFUploadManagerEvent.PDF_UPLOAD_COMPLETE));
        }
        public function get url():String{
        	return this._url;
        }
        public function set url(value:String):void{
        	this._url = value;
        }
        private var _url:String = "";

        private function httpStatusHandler(event:HTTPStatusEvent):void {
            log("httpStatusHandler: " + event);
        }
        
        private function ioErrorHandler(event:IOErrorEvent):void {
           	log("ioErrorHandler: " + event,2);
            this.dispatchEvent(new PDFUploadManagerEvent(PDFUploadManagerEvent.PDF_UPLOAD_ERROR));
           // Alert.show( event.text, "Error" );
        }

        private function openHandler(event:Event):void {
            log("openHandler: " + event);
        }

        private function progressHandler(event:ProgressEvent):void {
            var file:FileReference = FileReference(event.target);
            log("progressHandler name=" + file.name + " bytesLoaded=" + event.bytesLoaded + " bytesTotal=" + event.bytesTotal);
       		this.dispatchEvent(event);
        }

        private function securityErrorHandler(event:SecurityErrorEvent):void {
            log("securityErrorHandler: " + event,2);
           // Alert.show( event.text, "Error" );
        }


		protected function log(message:Object,level:uint=0):void{
			Logger.log("[PDFUploadmanager] "+message,level);
		}	
	}
}