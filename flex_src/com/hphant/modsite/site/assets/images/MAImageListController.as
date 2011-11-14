package com.hphant.modsite.site.assets.images

{
	import com.hphant.modsite.site.assets.interfaces.IMAsset;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.TimerEvent;
	import flash.utils.Timer; 

	public class MAImageListController extends EventDispatcher implements IMAsset
	{
		include "../interfaces/DataAssetIncludes.as";
		private var _nextIndex		:uint			= 0;
		private var _loop			:Boolean 		= true;
		private var _maImage		:MAImage;
		private var playTimer		:Timer;
		private var _imageDelay 	:uint			= 10;
		

		public function MAImageListController()
		{
			this.playTimer = new Timer(this._imageDelay*1000,0);
			this.playTimer.stop();
			this.playTimer.addEventListener(TimerEvent.TIMER, playTimerTimerEventHandler);
		}
		[Bindable]
		public var autoLoad		:Boolean		= true;
		[Bindable]
		public var isLoaded		:Boolean		= false;
		public function load():void{
			if(this._xml && this._maImage){
				this.isLoaded = true;
				this.loadNextImage();
			}
		}
		public function play():void
		{
			this.playTimer.start();
			
		}
		public function pause():void
		{
			this.playTimer.stop();
			
		}
		public function nextImage():void
		{
			this.pause();
			this.loadNextImage();
		}
		public function previousImage():void
		{
			this.pause();
			this.loadPreviousImage();
		}
		
		public function set maImage(value:MAImage):void
		{
			//trace("- MAImageListController set maImage() = " + value);
			this._maImage = value;
			
			// if XML is set.
			if(this._xml && this.autoLoad)
			{
				this.loadNextImage();
				this.playTimer.start();
			}
		}
		
		public function set xml(xml:XMLList):void
		{
			//trace("- MAImageListController setXML = " + xml);
			// if XML has changed.
			if(this._xml!=xml)
			{
				this._xml = xml;
				this._nextIndex = 0;
				// if image display is set. 
				if(this._maImage && this.autoLoad)
				{
					this.isLoaded = true;
					this.loadNextImage();
					this.playTimer.start();
				}
			}
		}
		private function playTimerTimerEventHandler(e:Event):void
		{
			this.loadNextImage();
			//trace(this + " playTimerTimerEvent()");
		}
		
		//Set in Seconds.  
		public function set imageDelay(value:Number):void
		{
			this._imageDelay = value;
			this.playTimer.delay = value*1000;
		}
		
		
		
		
		
		
		
		private function loadNextImage():void
		{
			//trace("- MAImageListController nextImage() nex xml = " + XMLList(this._xml.li[this._nextIndex]));
			var lastIndex:int = this._xml.li.length()-1;
			//if not at end of list, advance one.
			if(this._nextIndex <= lastIndex)
			{
				this._maImage.xml = XMLList(this._xml.li[this._nextIndex]);
				this._nextIndex++;
			}
			//if at end of list loop back to index 0;
			else
			
			{
				this._nextIndex = 0;
				this._maImage.xml = XMLList(this._xml.li[this._nextIndex]);
				this._nextIndex++;
			}
		}
		private function loadPreviousImage():void
		{
			//if not at beginning of list
			//trace("- MAImageListController loadNextImage()");
			var lastIndex:int = this.xml.li.length()-1;
			var thisIndex:int; 
			if(this._nextIndex==0)
			{
				thisIndex=lastIndex;
				
			}else
			{
				thisIndex = this._nextIndex-1;
				
			}
			if(thisIndex > 0)
			{
				this._maImage.xml = XMLList(this._xml.li[thisIndex-1]);
				this._nextIndex = thisIndex;
			}
			else
			{
				this._maImage.xml = XMLList(this._xml.li[lastIndex]);
				this._nextIndex = 0;
			}
		}
		
	}
}
