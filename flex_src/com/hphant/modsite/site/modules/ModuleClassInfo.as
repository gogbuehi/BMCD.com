package com.hphant.modsite.site.modules
{
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.geom.Rectangle;
	
	public class ModuleClassInfo extends EventDispatcher
	{
		private var _name:String;
		private var _label:String;
		private var _description:String;
		private var _useAdmin:Boolean;
		private var _icon:Class;
		[ArrayElementType("flash.geom.Rectangle")]
		private var _imageSizes:Array;
		[ArrayElementType("flash.geom.Rectangle")]
		private var _videoSizes:Array;
		
		public function ModuleClassInfo(name:String,
										label:String,
										description:String,
										useAdmin:Boolean=true,
										icon:Class=null,
										imageSizes:Array=null,
										videoSizes:Array=null)
		{
			super(this);
			this._name = name;
			this._imageSizes = imageSizes;
			this._videoSizes = videoSizes;
			this._label = label;
			this._useAdmin = useAdmin;
			this._description = description;
			this._icon = icon;
			this.dispatchEvent(new Event("iconChanged"));
		}
		[ArrayElementType("flash.geom.Rectangle")]
		public function get imageSizes():Array{return this._imageSizes;}
		[ArrayElementType("flash.geom.Rectangle")]
		public function get vidwoSizes():Array{return this._videoSizes;}
		public function get useAdmin():Boolean{return this._useAdmin;}
		public function get name():String{return this._name;}
		public function get label():String{return this._label;}
		public function get description():String{return this._description;}
		[Bindable(event="iconChanged")]
		public function get icon():Class{return this._icon;}
		public override function toString():String{return this._name;}
	}
}