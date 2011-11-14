// ActionScript file
private var _embedFont:Boolean = true;
private var _embedFontChanged:Boolean = false;
public function get embedFont():Boolean{return this._embedFont;}
public function set embedFont(value:Boolean):void{
	if(this._embedFont!=value){
		this._embedFont=value;
		this._embedFontChanged = true;
		this.invalidateDisplayList();
	}
}
protected override function updateDisplayList(unscaledWidth:Number, unscaledHeight:Number):void{
	super.updateDisplayList(unscaledWidth, unscaledHeight);
	this.textField.embedFonts = this._embedFont;
	if(this._embedFontChanged){
		this._embedFontChanged = false;
	}
}
