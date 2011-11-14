// ActionScript file

import flash.filters.DropShadowFilter;

import mx.core.UIComponent;
private var _mask:UIComponent = new UIComponent();
private var _maskSprite:Sprite = new Sprite();
private function addMask():void{
	/* this._mask.addChild(this._maskSprite);
	this.addChild(this._mask);
	this.mask = this._mask; */
}
private function drawMask():void{
	this._maskSprite.graphics.clear();
	this._maskSprite.graphics.beginFill(0x000000);
	this._maskSprite.graphics.drawRoundRect(0,0,this.width,this.height,this.getStyle("cornerRadius")*2,this.getStyle("cornerRadius")*2);
	this._maskSprite.graphics.endFill();
}
protected override function updateDisplayList(unscaledWidth:Number, unscaledHeight:Number):void{
	super.updateDisplayList(unscaledWidth, unscaledHeight);
	this.drawMask();
}