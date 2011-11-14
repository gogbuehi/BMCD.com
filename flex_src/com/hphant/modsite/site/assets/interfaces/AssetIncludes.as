// ActionScript file
import com.hphant.modsite.site.style.CSSInstance;
import com.hphant.modsite.system.events.ViewStateChangeEvent;
import com.hphant.utils.Logger;

import flash.text.StyleSheet;
public var logging:Boolean = true;
[Bindable]
protected var _xml:XMLList;
protected var _css:StyleSheet = CSSInstance.css;
protected var cssChanged:Boolean = true;
protected var xmlChanged:Boolean;

[Bindable]
[Inspectable(defaultValue="null", type="Object")]
public function get xml():XMLList{return this._xml;}
public function set xml(xml:XMLList):void
{
	//if(!this._xml || !xml || this._xml.toXMLString()!=xml.toXMLString()){
		this._xml = xml;
		
		this.xmlChanged = true;
		this.invalidateProperties();
	//}
}
[Bindable]
[Inspectable(defaultValue="null", type="Object")]
public function get css():StyleSheet{return this._css;}
public function set css(value:StyleSheet):void
{
	if(this._css != value){
		this._css = value;
		this.cssChanged = true;
		this.invalidateProperties();
	}
}

protected function parseCSS(name:String):StyleSheet{
	var newCSS:StyleSheet = new StyleSheet();
	if(this._css){
		for(var i:uint=0;i<this._css.styleNames.length;i++){
			var parts:Array = String(this._css.styleNames[i]).split(".");
			var newName:String = "";
			if(parts[0].toLowerCase()==name.toLowerCase()){
				if(parts.length>1){
					parts.shift();
				}
				newName = parts.join(".");
				newCSS.setStyle(newName,this._css.getStyle(this._css.styleNames[i]));
			}
		}
	}
	return newCSS;
}

protected function dispatchTransitionCompleted():void{
	var s:String =  String(this.currentState);
	var i:uint = uint(Number(s.replace("state","")));
	this.dispatchEvent(new ViewStateChangeEvent(ViewStateChangeEvent.CHANGE_COMPLETE,i));
}
protected function dispatchStateReached():void{
	var s:String =  String(this.currentState);
	var i:uint = uint(Number(s.replace("state","")));
	this.dispatchEvent(new ViewStateChangeEvent(ViewStateChangeEvent.STATE_REACHED,i));
}
protected function log(message:String,priority:Number=0):void{
	if(logging){
		Logger.log("["+this.className+"] "+message,priority);
	}
}