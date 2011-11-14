// ActionScript file
import com.hphant.modsite.data.SuplimentalDataBase;
import com.hphant.modsite.site.style.CSSInstance;
import com.hphant.modsite.system.events.ViewStateChangeEvent;
import com.hphant.modsite.system.interfaces.IURIManager;
import com.hphant.utils.Logger;

import flash.text.StyleSheet;
		
public var logging:Boolean = true;
protected var _xml:XMLList;
protected var _suplimental:XMLList;

protected var _css:StyleSheet = CSSInstance.css;
protected var cssChanged:Boolean = true;
protected var xmlChanged:Boolean;
protected var _uriManager:IURIManager;
private var _id:String = "";

public function get modId():String{
	return this._id;
}

public function set css(value:StyleSheet):void
{
	if(this._css != value && value){
		this._css = value;
		this.cssChanged = true;
		this.invalidateProperties();
	}
}

public function get uriManager():IURIManager
{
	return this._uriManager;
}

public function set uriManager(value:IURIManager):void
{
	this._uriManager = value;
}
[Bindable]
public function set xml(xml:XMLList):void
{
	if(!this._xml || !xml || this._xml.toXMLString()!=xml.toXMLString()){
		this._xml = xml;
		this._id = (this._xml) ? this._xml.@id : "";
	    this._suplimental = XMLList(SuplimentalDataBase.getSuplimentalData(this._id));
		this.xmlChanged = true;
		this.invalidateProperties();
	}
}
public function get xml():XMLList
{
	return this._xml;
}

[Bindable]
public function set suplimental(value:XMLList):void
{
	if(this._suplimental!==value){
		this._suplimental = value;
	}
}
public function get suplimental():XMLList
{
	return this._suplimental;
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
	log("ViewStateChangeEvent.CHANGE_COMPLETE, currentState = "+s);
	this.dispatchEvent(new ViewStateChangeEvent(ViewStateChangeEvent.CHANGE_COMPLETE,i));
}
protected function dispatchStateReached():void{
	var s:String =  String(this.currentState);
	var i:uint = uint(Number(s.replace("state","")));
	log("ViewStateChangeEvent.STATE_REACHED, currentState = "+s);
	this.dispatchEvent(new ViewStateChangeEvent(ViewStateChangeEvent.STATE_REACHED,i));
}
protected function log(message:String,priority:Number=0):void{
	if(logging){
		Logger.log("["+this.className+"] "+message,priority);
	}
}