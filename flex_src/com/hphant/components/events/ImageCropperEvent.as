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
package com.hphant.components.events  
{
	import flash.display.BitmapData;
	import flash.events.Event;

	public class ImageCropperEvent extends Event
	{
		
		public static const CONTENT_READY:String = "content_ready";
		private var _imageCropperInfo:Object = new Object();
		
		
		
		public function ImageCropperEvent(type:String,
									imageData:BitmapData,
									srcImgXoffset:Number,
									srcImgYoffset:Number,
									srcImgScale:Number, 
									masterName:Number,
									bubbles:Boolean = false, 
									cancelable:Boolean = false)
		{
			super(type,bubbles,cancelable);
			this._imageCropperInfo.imageData 		= imageData;
			this._imageCropperInfo.srcImgXoffset 	= srcImgXoffset;
			this._imageCropperInfo.srcImgYoffset 	=srcImgYoffset;
			this._imageCropperInfo.srcImgScale 		=srcImgScale;
			this._imageCropperInfo.masterName 		=masterName;
							
		}	
		
		public function get imageCropperInfo():Object
		{
			return this._imageCropperInfo;
		}
	}
}	
