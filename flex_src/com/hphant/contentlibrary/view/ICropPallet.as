package com.hphant.contentlibrary.view
{
	import com.hphant.contentlibrary.process.IImageProcess;
	import com.hphant.components.imageCropper.ICropper;
	import mx.controls.ComboBox;
	public interface ICropPallet
	{
		function get cropSizes():Array;
		function set cropSizes(value:Array):void;
		function get process():IImageProcess;
		function set process(value:IImageProcess):void;
		function get imageCrop():ICropper; 
		function get cropSize():ComboBox;
		function get html():String;
		function set html(value:String):void;
		function get title():String;
		function set title(value:String):void;
		function get alternate():String;
		function set alternate(value:String):void;
		function setView(viewObject:CropPalletView):void;
		function getView():CropPalletView;
	}
}