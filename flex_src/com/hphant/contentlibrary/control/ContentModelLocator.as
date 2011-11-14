package com.hphant.contentlibrary.control
{
	import com.adobe.cairngorm.*;
	import com.adobe.cairngorm.model.IModelLocator;
	import com.hphant.contentlibrary.model.*;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.external.ExternalInterface;
	
	import mx.collections.ArrayCollection;
	
	
	/**
	 *	Singleton to store references to all model data used by application.
	 */	
	
	public class ContentModelLocator extends EventDispatcher implements IModelLocator {
		
		/**
		* 	Class' static  members.
		*/		
		private static var _instance:ContentModelLocator;
		
		public static function getInstance():ContentModelLocator {
			if ( !_instance ) {
				_instance = new ContentModelLocator();
			}
			return _instance; 
		}
		
		/**
		 * 	Constructor
		 */		
		public function ContentModelLocator(){
			super(this);
			if ( _instance )
           	{
           		throw new CairngormError( CairngormMessageCodes.SINGLETON_EXCEPTION, "ModelLocator" );
            }
           	_instance = this;
		}

		
		/**
		* 	Instance members.
		*/
		public function get sessionKey():String{
			var gVars:Object = ExternalInterface.call("getGlobals");
			var sk:String = "SESSSIONKEY";
			try{
				sk = String(gVars.SESSION_KEY);
			}catch(e:Error){
				
			}
			return sk;
		}
		
		//	Masters-related
		[Bindable]
		public var selectedMaster	: Master;
		
	
		[ArrayElementType("com.hphant.contentlibrary.model.Master")]
		private var _masters			: ArrayCollection;
		private var _mastersById		: Object = new Object();
		
		[Bindable(event="mastersChanged")]
		[ArrayElementType("com.hphant.contentlibrary.model.Master")]
		public function get masters():ArrayCollection{
			return this._masters;
		}
		public function set masters(value:ArrayCollection):void{
			this._mastersById = new Object();
			this._masters = value;
			for each(var m:Master in this._masters){
				this._mastersById["id_"+m.id] = m;
			}
			this.dispatchEvent(new Event("mastersChanged"));
		}
		public function getMasterByID(id:Object):Master{
			return Master(this._mastersById["id_"+id]);
		}
		public function getMasterOfCrop(crop:Crop):Master{
			return this.getMasterByID(crop.masterId);
		}
		
		//	Crops-related
		[Bindable]
		public var selectedCrop		: Crop;
		
		[Bindable]
		[ArrayElementType("com.hphant.contentlibrary.model.Crop")]
		public var suggestedCrops	: ArrayCollection;
		
	
		[ArrayElementType("com.hphant.contentlibrary.model.Crop")]
		private var _crops	: ArrayCollection;
		private var _cropsByID:Object = new Object();
		private var _cropsByDimension:Object = new Object();
		private var _cropsByMasterID:Object = new Object();
		[Bindable(event="cropsChanged")]
		[ArrayElementType("com.hphant.contentlibrary.model.Crop")]
		public function get crops():ArrayCollection{
			return this._crops;
		}
		public function set crops(value:ArrayCollection):void{
			this._crops = value;
			refreshCropDictionaries();
		}
		public function getCropsByID(id:Object):Crop{
			return Crop(this._cropsByID["id_"+id]);
		}
		public function refreshCropDictionaries():void{
			this._cropsByID = new Object();
			this._cropsByDimension = new Object();
			this._cropsByMasterID = new Object();
			for each(var c:Crop in this._crops){
				this._cropsByID["id_"+c.id] = c;
				if(!_cropsByMasterID["id_"+c.masterId]){
					_cropsByMasterID["id_"+c.masterId] = new ArrayCollection();
				}
				ArrayCollection(_cropsByMasterID["id_"+c.masterId]).addItem(c);
				if(!_cropsByDimension["w"+c.dimensionWidth+"_h"+c.dimensionHeight]){
					_cropsByDimension["w"+c.dimensionWidth+"_h"+c.dimensionHeight] = new ArrayCollection();
				}
				ArrayCollection(_cropsByDimension["w"+c.dimensionWidth+"_h"+c.dimensionHeight]).addItem(c);
			}
			this.dispatchEvent(new Event("cropsChanged"));
		}
		
		[ArrayElementType("com.hphant.contentlibrary.model.Crop")]
		public function getCropsOfDimension(width:Object,height:Object):ArrayCollection{
			return ArrayCollection(_cropsByDimension["w"+width+"_h"+height]);
		}
		
		[ArrayElementType("com.hphant.contentlibrary.model.Crop")]
		public function getCropsOfMaster(master:Master):ArrayCollection{
			return this.getCropsByMasterID(master.id);
		}
		[ArrayElementType("com.hphant.contentlibrary.model.Crop")]
		public function getCropsByMasterID(id:Object):ArrayCollection{
			return ArrayCollection(_cropsByMasterID["id_"+id]);
		}
		
		
		//	Videos-related
		[Bindable]
		public var selectedVideo	: Video;
		
		[Bindable]
		[ArrayElementType("com.hphant.contentlibrary.model.Video")]
		public var suggestedVideos	: ArrayCollection;
		
	
		[ArrayElementType("com.hphant.contentlibrary.model.Video")]
		private var _videos	: ArrayCollection;
		private var _videosByID:Object = new Object();
		private var _videosByDimension:Object = new Object();
		[Bindable(event="videosChanged")]
		[ArrayElementType("com.hphant.contentlibrary.model.Video")]
		public function get videos():ArrayCollection{
			return this._videos;
		}
		public function set videos(value:ArrayCollection):void{
			this._videosByID = new Object();
			this._videosByDimension = new Object();
			this._videos = value;
			for each(var c:Video in this._videos){
				this._videosByID["id_"+c.id] = c;
				if(!_videosByDimension["w"+c.width+"_h"+c.height]){
					_videosByDimension["w"+c.width+"_h"+c.height] = new ArrayCollection();
				}
				ArrayCollection(_videosByDimension["w"+c.width+"_h"+c.height]).addItem(c);
			}
			evaluateUpladedVideos(this._uploadedVideos);
		}
		
		private function evaluateUpladedVideos(value:Array):void{
			var t:String = value.join(",");
			for each(var vid:Video in this._videos){
				t = t.split(vid.location).join("").split(",,").join(",");
				if(t.indexOf(",")==0){
					t = t.substr(1,t.length-1);
				}
			}
			this._uploadedVideos = t.split(",");
			this.dispatchEvent(new Event("videosChanged"));
		}
		
		[ArrayElementType("String")]
		private var _uploadedVideos:Array = [];
		
		[Bindable(event="videosChanged")]
		[ArrayElementType("String")]
		public function get uploadedVideos():Array{
			return this._uploadedVideos;
		}
		public function set uploadedVideos(value:Array):void{
			evaluateUpladedVideos(value);
		}
		
		public function getVideoByID(id:Object):Video{
			return Video(this._videosByID["id_"+id]);
		}
		
		[ArrayElementType("com.hphant.contentlibrary.model.Video")]
		public function getVideosOfDimension(width:Object,height:Object):ArrayCollection{
			return ArrayCollection(_videosByDimension["w"+width+"_h"+height]);
		}
		
		
		//	PDFs-related
		[Bindable]
		public var selectedPDF		: PDF;
		
		[Bindable]
		[ArrayElementType("com.hphant.contentlibrary.model.PDF")]
		public var suggestedPDFs	: ArrayCollection;
		
	
		[ArrayElementType("com.hphant.contentlibrary.model.PDF")]
		private var _PDFs	: ArrayCollection;
		private var _PDFsByID:Object = new Object();
		[Bindable(event="pdfsChanged")]
		[ArrayElementType("com.hphant.contentlibrary.model.PDF")]
		public function get pdfs():ArrayCollection{
			return this._PDFs;
		}
		public function set pdfs(value:ArrayCollection):void{
			this._PDFs = value;
			refreshPDFDictionaries();
		}
		public function getPDFsByID(id:Object):PDF{
			return PDF(this._PDFsByID["id_"+id]);
		}
		public function refreshPDFDictionaries():void{
			this._PDFsByID = new Object();
			for each(var c:PDF in this._PDFs){
				this._PDFsByID["id_"+c.id] = c;
			}
			this.dispatchEvent(new Event("pdfsChanged"));
		}
		
		
	}
}