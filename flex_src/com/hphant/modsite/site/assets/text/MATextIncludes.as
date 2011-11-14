// ActionScript file

import flash.display.Sprite;
import flash.events.ProgressEvent;

import mx.core.UIComponent;

private var _mask:UIComponent = new UIComponent();
private var _maskSprite:Sprite = new Sprite();
private var _plHolder:UIComponent = new UIComponent();
private function addMask():void{
	this._mask.addChild(this._maskSprite);
	this.addChild(this._mask);
	this.mask = this._mask;
}
private function drawMask():void{
	this._maskSprite.graphics.clear();
	this._maskSprite.graphics.beginFill(0x000000);
	if(this.width && this.height){
		this._maskSprite.graphics.drawRoundRect(0,0,this.width,this.height,this.getStyle("cornerRadius")*2,this.getStyle("cornerRadius")*2);
	}
	this._maskSprite.graphics.endFill();
}
protected override function updateDisplayList(unscaledWidth:Number, unscaledHeight:Number):void{
	super.updateDisplayList(unscaledWidth, unscaledHeight);
	this.drawMask();
}