// ActionScript file
/*--------------------------------

	Sample Build Function 

			buildImageCropperEvent():ImageCropperEvent
			{
			
				var srcImgXoffset:Number 	= 
				var srcImgYoffset:Number 	=	
				var srcImgScale:Nuber 		=  
				var masterName:Number 		= 
				var contentType:Strin 		=	 
				var bubbles:Boolean 		= false; 
				var cancelable:Boolean 		= false;
			
				return new ImageCropper(type, imageData, srcImgXoffset, srcImgYoffset, srcImgScale, masterName, bubbles, cancelable );
			}
//-------------------------------
*/
package com.hphant.events
{
	import flash.display.BitmapData;
	import flash.events.Event;

	public class VideoCropperEvent extends Event implements ICropperEvent
	{
		
		public static const CONTENT_READY 			: String = "contentReady";
		public static const MASTER_READY 			: String = "masterReady";

		
		private var _videoCropperInfo:Object = new Object();
		
		
		
		public function VideoCropperEvent(type:String,
									imageData:BitmapData,
									srcImgXoffset:Number,
									srcImgYoffset:Number,
									srcImgScale:Number,
									srcImgRotation:Number,
									time:Number, 
									//masterName:String,	// ??? what's this, and with type : Number ? 
									bubbles:Boolean = false, 
									cancelable:Boolean = false)
		{
			super(type,bubbles,cancelable);
			this._videoCropperInfo.imageData= imageData;
			this._videoCropperInfo.offsetX 	= srcImgXoffset;
			this._videoCropperInfo.offsetY 	= srcImgYoffset;
			this._videoCropperInfo.scale 	= srcImgScale;
			this._videoCropperInfo.rotation	= srcImgRotation;
			this._videoCropperInfo.time = time;
			//this._imageCropperInfo.masterName 		=masterName;
		}	
		
		public function get cropperInfo():Object
		{
			return this._videoCropperInfo;
		}
	}
}	
