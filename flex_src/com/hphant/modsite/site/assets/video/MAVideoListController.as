package com.hphant.modsite.site.assets.video
{
	import com.hphant.modsite.site.assets.interfaces.IMAsset;
	
	import flash.events.EventDispatcher;
	
	import mx.events.VideoEvent;
	
	[Event(name="complete", type="mx.events.VideoEvent")]
	
	public class MAVideoListController extends EventDispatcher implements IMAsset
	{	
		include "../interfaces/DataAssetIncludes.as";
		private var _videoPlayer:MAVideoDisplay;
		private var _nextIndex:uint	= 0;
		private var _loop:Boolean;
		public function get currentIndex():uint{return this._nextIndex;}
		private function videoCompleteHandler(e:VideoEvent = null):void
		{
			this.playNextVideo();
			dispatchEvent(new VideoEvent(VideoEvent.COMPLETE));
		}
		public function playNextVideo():void
		{
			this._videoPlayer.xml = XMLList(_xml.li[this._nextIndex]);
			this._nextIndex = (_xml.li.length()>this._nextIndex+1) ? this._nextIndex + 1 : 0;
		}
		
		public function playPreviousVideo():void
		{
			this._videoPlayer.xml = XMLList(_xml.li[(this._nextIndex>2) ? this._nextIndex-2 : _xml.li.length() + this._nextIndex-2 ]);
			this._nextIndex = (0<=this._nextIndex-1) ? this._nextIndex - 1 : _xml.li.length();
		}
		public function set videoPlayer(value:MAVideoDisplay):void
		{
			if(value){
				//Logger.log(this.toString()+" Video display set : "+value);
				this._videoPlayer = value;
				this._videoPlayer.addEventListener(VideoEvent.COMPLETE,videoCompleteHandler);
				// if XML is set.
				if(this._xml)
				{
					this.playNextVideo();
				}
			} else if(this._videoPlayer){
				//Logger.log(this.toString()+" Video display removed : "+this._videoPlayer);
				this._videoPlayer.removeEventListener(VideoEvent.COMPLETE,videoCompleteHandler);
				this._videoPlayer.videoPlayer.stop();
				this._videoPlayer = value;
			}
		}
	
		public function set xml(xml:XMLList):void
		{
			
			// if XML has changed.
			if(this._xml!=xml)
			{
				this._xml = xml;
				
				this._nextIndex = 0;
				// if video player is set. 
				if(this._videoPlayer && this._autoLoad && this._xml)
				{
					//Logger.log(this.toString()+" XML set : "+xml.toXMLString());
					this.playNextVideo();
				}else if(this._videoPlayer && !this._xml){
					this._videoPlayer.xml = null;
					//this.videoPlayer = null;
				}
			}
		}
		private var _autoLoad:Boolean = false;
		[Inspectable]
		public function get autoLoad():Boolean{return this._autoLoad;}
		public function set autoLoad(value:Boolean):void{
			if(!this._autoLoad && value && this._xml){
				this.playNextVideo();
			}
			this._autoLoad = value;
			
		}
		public function load():void{
			this.playNextVideo();
		}
}
}