package com.hphant.modsite.site.assets.text
{
	
	
	import com.hphant.modsite.site.assets.interfaces.IMAsset;
	
	import flash.text.StyleSheet;
	import flash.text.TextFieldAutoSize;
	
	import mx.controls.TextArea;
	import mx.core.ScrollPolicy;
	import mx.effects.Fade;
	import mx.events.EffectEvent;
	public class MOld_MATextArea extends TextArea implements IMAsset
	{
		protected var _xml:XMLList;
		protected var _xmlNew:XMLList;
		protected var _css:StyleSheet;
		protected var _cssNew:StyleSheet;
		protected var _xmlChanged:Boolean;
		protected var _cssChanged:Boolean;
		private var _effect:Fade;
		private var _autoSize:String = TextFieldAutoSize.LEFT;
		private var _scrollable:Boolean = false;
		private var _scrollableChanged:Boolean = true;
		public function MOld_MATextArea()
		{
			super();
			this.setStyle("backgroundAlpha",0.2);
			this.setStyle("borderStyle","none");
			this.setStyle("focusThickness","");
			this.wordWrap = true;
			this.alpha = 0;
			this.defineEffect();
			this._effect.addEventListener(EffectEvent.EFFECT_END,this.effectEnd);
			this._effect.addEventListener(EffectEvent.EFFECT_START,this.effectStart);
			this.setEffectEndValues();
			this.setEffectStartValues();
		}
		public function get scrollable():Boolean{return this._scrollable;}
		public function set scrollable(value:Boolean):void{
			if(this._scrollable != value){
				this._scrollable = value;
				this._scrollableChanged = true;
				this.invalidateDisplayList();
			}
		}
		public function get autoSize():String{return this._autoSize;}
		public function set autoSize(value:String):void{
			this._autoSize = value;
			this.invalidateDisplayList();
		}
		protected override function updateDisplayList(unscaledWidth:Number, unscaledHeight:Number):void{
			super.updateDisplayList(unscaledWidth,unscaledHeight);
			this.textField.embedFonts = true;
			this.textField.autoSize = this._autoSize;
			if(this._scrollableChanged){
				if(this._scrollable){
					var t:ScrollPolicy
					this.verticalScrollPolicy = ScrollPolicy.AUTO;
					this.horizontalScrollPolicy = ScrollPolicy.AUTO;
				} else {				
					this.verticalScrollPolicy = ScrollPolicy.OFF;
					this.horizontalScrollPolicy = ScrollPolicy.OFF;
				}
			}
			if(this._autoSize!=TextFieldAutoSize.NONE){
				this.height = this.textHeight+this.getStyle("paddingBottom")+this.getStyle("paddingTop");	
			}
		}
		private function effectEnd(e:EffectEvent):void{
			trace("effect ended");
			if(this._xmlChanged || this._cssChanged){
				this.changeContent();
			}
		}
		private function effectStart(e:EffectEvent):void{
			trace("effect started");
		}	
		protected function setEffectStartValues():void{
			if(this._effect is Fade){
				if(!this._effect.alphaTo){
					Fade(this._effect).alphaFrom = 0;
				} else {
					Fade(this._effect).alphaFrom = 1;
				}
			}
		}
		protected function setEffectEndValues():void{
			if(this._effect is Fade){
				if(!this._effect.alphaTo){
					Fade(this._effect).alphaTo = 1;
				} else {
					Fade(this._effect).alphaTo = 0;
				}
			}
		}
		protected function defineEffect():void{
			if(!this._effect){this._effect = new Fade(this);}
		}
		protected function applyXML():void{
			if(this._xml){
				this.htmlText = this._xml.toXMLString();
			} else {
				this.htmlText = "";	
			}
			this.validateNow();
		}
		
		protected function applyCSS():void{
			this.styleSheet = this._css;
			this.validateNow();
			this.invalidateDisplayList();
		}
		protected function changeContent():void{
			if(this._xml!=this._xmlNew || !this._xmlNew){
				this._xml = this._xmlNew;
				this.applyXML();
			}
			if(this._css!=this._cssNew || !this._cssNew){
				this._css = this._cssNew;
				this.applyCSS();
			}
			if(this._cssChanged || this._xmlChanged){
				this._cssChanged = this._xmlChanged = false;
				if(this._effect.isPlaying){this._effect.pause();}
				this._effect.alphaFrom = 0;
				this._effect.alphaTo = 1;
				this._effect.play();
			}
		}
		public function get xml():XMLList{return this._xmlNew;}
		public function set xml(value:XMLList):void{
			if(this.compareXML(value)){
				this._xmlNew = value;
				this._xmlChanged = true;
				this.invalidateProperties();
			}
		}
		protected override function commitProperties():void{
			if(this._xmlChanged || this._cssChanged){
				if(this.alpha!=0){
					trace("play effect");
					if(this._effect.isPlaying){this._effect.pause();}
					this._effect.alphaFrom = 1;
					this._effect.alphaTo = 0;
					this._effect.play();
				} else {
					trace("changed content");
					this.changeContent();
				}
			}
			super.commitProperties();
		}
		public function get css():StyleSheet{return this._css;}
		public function set css(value:StyleSheet):void{
			if(this.compareCSS(value)){
				this._cssNew = value;
				this._cssChanged = true;
				this.invalidateProperties();
			}
		}
		protected function compareXML(otherXML:XMLList):Boolean{
			return (this._xmlNew!=otherXML);
		}
		
		protected function compareCSS(otherCSS:StyleSheet):Boolean{
			if(this._cssNew && otherCSS){
				for(var i:uint=0;i<this._cssNew.styleNames.length;i++){
					var s1:Object = this._cssNew.getStyle(this._cssNew.styleNames[i]);
					var s2:Object = otherCSS.getStyle(this._cssNew.styleNames[i]);
					if(s1 &&s2){
						for(var j:String in s1){
							if(s1[j]!=s2[j]){return true;}
						}
						for(var k:String in s2){
							if(s2[k]!=s1[k]){return true;}
						}
					} else {
						return true;
					}
				}
				return (this._cssNew!=otherCSS);
			} else {
				return (this._cssNew!=otherCSS);
			} 
		}
	}
}