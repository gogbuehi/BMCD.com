package com.hphant.components.text
{
	import flash.events.Event;
	import flash.events.FocusEvent;
	import flash.text.TextFormat;

	public class SelfLabelTextArea extends BaseTextArea
	{
		public function SelfLabelTextArea()
		{
			super();
		}
		[Bindable]
		[Inspectable]
		public override function set text(value:String):void{
			this._text = value;
			this._htmlText = "";
			setDisplayText();
		}
		public override function get text():String{
			return this._text;
		}
		
		[Bindable]
		[Inspectable]
		public override function set htmlText(value:String):void{
			this._htmlText = value;
			this._text = "";
			setDisplayText();
		}
		public override function get htmlText():String{
			return this._htmlText;
		}
		
		private var _text:String = "";
		private var _htmlText:String = "";
		private var _label:String = "";
		private var _labelFormat:TextFormat;
		private var _textFormat:TextFormat;
		private var _toolTip:String = "";
		
		private function setDisplayText():void{
			if(!this._text){
				super.htmlText = this._htmlText ? this._htmlText : this._label;
			} else {
				super.text = this._text ? this._text : this._label;
			}
			
			super.toolTip = this._toolTip ? this._toolTip : (this._text || this._htmlText) ? this._label : "" ;
			
		}
		[Bindable]
		[Inspectable]
		public override function get toolTip():String{
			return this._toolTip;	
		}
		public override function set toolTip(value:String):void{
			this._toolTip = value;
			setDisplayText();
		}
		protected override function createChildren():void{
			super.createChildren();
			this.addEventListener(FocusEvent.FOCUS_IN,this.focusChanged);
			this.addEventListener(FocusEvent.FOCUS_OUT,this.focusChanged);
			this.addEventListener(Event.CHANGE,this.textChanged);
		}
		private function textChanged(event:Event):void{
			this._text = super.text;
			this._htmlText = super.htmlText;
		}
		private function focusChanged(event:FocusEvent):void{
			switch(event.type){
				case FocusEvent.FOCUS_IN:
					if(super.text==this._label){
						super.text = "";
					}
					
				break;
				case FocusEvent.FOCUS_OUT:
					this.setDisplayText();
				break;
			}
		}
		
		
		[Bindable]
		[Inspectable]
		public function get label():String{
			return this._label;
		}
		public function set label(value:String):void{
			this._label = value;
			setDisplayText();
		}
	}
}