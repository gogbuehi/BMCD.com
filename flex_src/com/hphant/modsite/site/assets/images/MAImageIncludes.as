// ActionScript file

import flash.display.Sprite;
import flash.events.ProgressEvent;

import mx.core.UIComponent;

/* [Embed(source="imagePreloader.swf")]
[Bindable]
private var MAImagePreloader:Class; */

private var _mask:UIComponent = new UIComponent();
private var _maskSprite:Sprite = new Sprite();
//private var preloader:Sprite = new MAImagePreloader() as Sprite;
private var _plHolder:UIComponent = new UIComponent();
private function addMask():void{
	this._mask.addChild(this._maskSprite);
	this.addChild(this._mask);
	this.img.mask = this._mask;
	//this.addPreloader();
}
/* private function addPreloader():void{
	this._plHolder.addChild(this.preloader);
	this.addChild(this._plHolder);
	this.img.addEventListener(ProgressEvent.PROGRESS,this.checkProgress);
}
private function checkProgress(pr:ProgressEvent):void{
	var percent:int = (pr.currentTarget.bytesLoaded / pr.currentTarget.bytesTotal) * 100;
	  MAImagePreloader(this.preloader).rotate(percent);
	
}         */
private function drawMask():void{
	this._maskSprite.graphics.clear();
	this._maskSprite.graphics.beginFill(0x000000);
	if(this.width && this.height){
		this._maskSprite.graphics.drawRoundRect(0,0,this.width,this.height,this.getStyle("cornerRadius")*2,this.getStyle("cornerRadius")*2);
	}
	this._maskSprite.graphics.endFill();
	//this.preloader.x = this.width/2;
	//this.preloader.y = this.height/2;
}
protected override function updateDisplayList(unscaledWidth:Number, unscaledHeight:Number):void{
	super.updateDisplayList(unscaledWidth, unscaledHeight);
	this.drawMask();
}