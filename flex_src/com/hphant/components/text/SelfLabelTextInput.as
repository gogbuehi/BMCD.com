package com.hphant.components.text
{
	import com.hphant.components.events.TextEvent;
	
	import flash.events.Event;
	import flash.events.FocusEvent;
	import flash.text.TextFormat;
	
	import mx.controls.TextInput;
	[Event(name="textChange",type="com.hphant.components.events.TextEvent")]
	public class SelfLabelTextInput extends TextInput
	{
		public function SelfLabelTextInput()
		{
			super();
		}
		[Bindable("textChanged")]
	    [CollapseWhiteSpace]
	    [Inspectable(category="General", defaultValue="")]
	    [NonCommittingChangeEvent("change")]
		public override function set text(value:String):void{
			this._text = value;
			setDisplayText();
			this.dispatchEvent(new Event('textChanged'));
			this.dispatchEvent(new TextEvent(TextEvent.TEXT_CHANGE));
		}
		public override function get text():String{
			return _text;
		}
		private var _text:String = "";
		private var _label:String = "";
		private var _labelFormat:TextFormat;
		private var _textFormat:TextFormat;
		private var _toolTip:String = "";
		
		private function setDisplayText():void{
			
			super.displayAsPassword = (this._text || inFocuse) ? this._displayAsPassword : false;
			super.text = (this._text || inFocuse) ? this._text : this._label;
			
			super.toolTip = this._toolTip ? this._toolTip : (this._text || inFocuse) ? this._label : "" ;
		}
		private var inFocuse:Boolean = false;
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
			setDisplayText();
			this.addEventListener(FocusEvent.FOCUS_IN,this.focusChanged);
			this.addEventListener(FocusEvent.FOCUS_OUT,this.focusChanged);
			this.addEventListener(Event.CHANGE,this.textChanged);
		}
		private function textChanged(event:Event):void{
			this._text = super.text;
			setDisplayText();
			this.dispatchEvent(new Event('textChanged'));
			this.dispatchEvent(new TextEvent(TextEvent.TEXT_CHANGE));
		}
		private function focusChanged(event:FocusEvent):void{
			switch(event.type){
				case FocusEvent.FOCUS_IN:
					inFocuse = true;
					super.text = this._text;
				break;
				case FocusEvent.FOCUS_OUT:
					inFocuse = false;
					this.setDisplayText();
				break;
			}
		}
		[Bindable]
		[Inspectable]
		public override function set displayAsPassword(value:Boolean):void{
			_displayAsPassword = value;
			super.displayAsPassword = value;
		}
		public override function get displayAsPassword():Boolean{
			return _displayAsPassword;
		}
		private var _displayAsPassword:Boolean = false;
		
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