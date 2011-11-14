// ActionScript file
import flash.text.StyleSheet;

protected var _xml:XMLList;
protected var _css:StyleSheet;

public function get xml():XMLList{return this._xml;}
/*
	fuction should be implamented inside the Data Asset.
	public function set xml(xml:XMLList):void
	{
		if(this._xml!=xml){
			//// code here 
		}
	}
*/

public function get css():StyleSheet{return this._css;}
public function set css(value:StyleSheet):void
{
	if(this._css != value){
		this._css = value;
	}
}