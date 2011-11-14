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

	public class ImageCropperEvent extends Event implements ICropperEvent
	{
		
		public static const CONTENT_READY 			: String = "contentReady";
		public static const MASTER_READY 			: String = "masterReady";

		
		private var _imageCropperInfo:Object = new Object();
		
		
		
		public function ImageCropperEvent(type:String,
									imageData:BitmapData,
									srcImgXoffset:Number,
									srcImgYoffset:Number,
									srcImgScale:Number,
									srcImgRotation:Number, 
									//masterName:String,	// ??? what's this, and with type : Number ? 
									bubbles:Boolean = false, 
									cancelable:Boolean = false)
		{
			super(type,bubbles,cancelable);
			this._imageCropperInfo.imageData= imageData;
			this._imageCropperInfo.offsetX 	= srcImgXoffset;
			this._imageCropperInfo.offsetY 	= srcImgYoffset;
			this._imageCropperInfo.scale 	= srcImgScale;
			this._imageCropperInfo.rotation	= srcImgRotation;
			//this._imageCropperInfo.masterName 		=masterName;
		}	
		
		public function get cropperInfo():Object
		{
			return this._imageCropperInfo;
		}
	}
}	
