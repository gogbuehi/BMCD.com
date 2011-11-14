package com.hphant.components.imageCropper
{
	import com.hphant.components.spinner.Spinner;
	import com.hphant.events.ICropperEvent;
	
	import flash.display.BitmapData;
	import flash.events.IEventDispatcher;
	
	import mx.core.IUIComponent;
	public interface ICropper extends IEventDispatcher, IUIComponent
	{
		function loadPhoto(masterFilePath:String,
									cropWidth			:Number=0,
					     			cropHeight			:Number=0,
									srcImgScale_init	:Number=100,
									srcImgRotation_init	:Number=0,
									srcImgXoffset_init	:Number=0,
									srcImgYoffset_init	:Number=0,
									time:Number = 0
					     			):void;
		function commitCrop():void;
		function reset():void;
		function setCropSize(width:Number,height:Number):void;
		function get lastCropperEvent():ICropperEvent;
		function get masterBitmapData():BitmapData;
		function get spinner():Spinner;
	}
}