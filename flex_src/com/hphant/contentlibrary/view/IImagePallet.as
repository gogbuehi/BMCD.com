package com.hphant.contentlibrary.view
{
	import com.hphant.components.imageCropper.ICropper;
	import com.hphant.contentlibrary.process.IImageProcess;

	import mx.controls.ComboBox;
	public interface IImagePallet
	{
		function get cropSizes():Array;
		function set cropSizes(value:Array):void;
		function get process():IImageProcess;
		function set process(value:IImageProcess):void;
		function get imageCrop():ICropper; 
		function get cropSize():ComboBox;
		function get html():String;
		function set html(value:String):void;
		function setView(select:Boolean,
									description:Boolean,
									size:Boolean,
									crop:Boolean,
									thumb:Boolean,
									save:Boolean,
									image:Boolean):void;
	}
}