// ActionScript file
import com.hphant.modsite.site.events.MALinkClickEvent;

import flash.events.Event;

import mx.containers.Box;
import mx.core.ScrollPolicy;
import mx.core.UIComponent;
import mx.effects.Resize;
import mx.events.EffectEvent;

			private function resizeEnd(e:EffectEvent):void{
				this._resizeCount++;
				if(this._resizeCount==this.numChildren){
					this.dispatchEvent(new EffectEvent("Special"+e.type));
				}
			}
			private var _resizeCount:uint = 0;
			private var _sizeImages:Boolean = false;
			private var _loadImages:Boolean = false;
			
			[Bindable('sizeImagesChanged')]
			[Inspectable]
			public function get sizeImages():Boolean{return this._sizeImages;}
			public function set sizeImages(value:Boolean):void{
				//log("Size images :"+this._sizeImages+" : "+value+" : "+this.numChildren);
				
				if(this._sizeImages!=value){
					this._sizeImages = value;
					doSizeImages(value);
					this.invalidateDisplayList();
					this.dispatchEvent(new Event('sizeImagesChanged'));
				}
			}
			[Bindable('loadImagesChanged')]
			[Inspectable]
			public function get loadImages():Boolean{return this._loadImages;}
			public function set loadImages(value:Boolean):void{
				//log("Loading images :"+this._loadImages+" : "+value+" : "+this.numChildren);
				if(this._loadImages != value){
					this._loadImages = value;
					doLoadImages(value);
					this.invalidateDisplayList();
					this.dispatchEvent(new Event('loadImagesChanged'));
				}
			}
			private function doLoadImages(value:Boolean):void{
				for(var i:uint = 0;i<this.numChildren;i++){
				//	log("Loading image :"+i+" : "+Box(this.getChildAt(i)).getChildAt(0)+" : "+XMLList(this._xml.li[i]).toXMLString());
					if(value){
						this.setImageXML(IMAsset(Box(this.getChildAt(i)).getChildAt(0)),XMLList(this._xml.li[i]));
					} else {
						this.setImageXML(IMAsset(Box(this.getChildAt(i)).getChildAt(0)),null);
					}
				}
			}
			
			protected override function commitProperties():void{
				if(this.cssChanged){
					this.cssChanged = false;
				}
				if(this.xmlChanged && this._xml){
					this.setImages(this._xml.li);
					if(this.loadImages){
						this.doLoadImages(true);
					}
					if(this.sizeImages){
						this.doSizeImages(true);
					}
					this.xmlChanged = false;
				} else if(this.xmlChanged){
					this.unloadImages();
					this.xmlChanged = false;
				}
				super.commitProperties();
			}
			private var imgHeight:Number = 130;
			[Inspectable]
			[Bindable]
			public function get imageHeight():Number{return this.imgHeight;}
			public function set imageHeight(value:Number):void{
				this.imgHeight = value;
				this.invalidateDisplayList();
			}
			private var imgWidth:Number = 180;
			
			
			[Inspectable]
			[Bindable]
			public function get imageWidth():Number{return this.imgWidth;}
			public function set imageWidth(value:Number):void{
				this.imgWidth = value;
				this.invalidateDisplayList();
			}
			private function unloadImages():void{
				for each(var box:Box in this.getChildren()){
					IMAsset(box.getChildAt(0)).xml = null;
				}
			}
			private function setImages(xml:XMLList):void{
				this.resizeTargets = new Array();
				if(xml.children()){
					var k:uint = 0;
					for(var i:uint=0;i<xml.length();i++){
						k = this.setImage(k,XMLList(xml[i]));
						k++;
					}
					if(xml.length() < this.numChildren){
						for(var j:uint = xml.length();j<this.numChildren;j++){
							this.removeChildAt(j);
						}
					}
					
				}
			}
			private var resizeTargets:Array;
			private function setImage(index:uint,xml:XMLList):uint{
				var i_:uint = index;
				for(var i:uint = index;i<this.numChildren;i++){
					var mod:IMAsset = IMAsset(Box(this.getChildAt(i)).getChildAt(0));
					var nodeName:String = String(XML(xml.children()[0]).name());
					if(!mod.xml || nodeName=="a" || nodeName=="img" || nodeName=="li"){
						//this.setImageXML(mod,xml);
						resizeTargets.push(mod);
						return i;
					} else {
						this.removeChildAt(i);
						i--;
					}
					i_ = i;
				}
				if(i_==this.numChildren){
					var m:IMAsset = this.createNewImage();
					var b:Box = new Box();
					/* 
					UIComponent(m).addEventListener(Event.ADDED_TO_STAGE,imageAddedToStage);
					UIComponent(m).addEventListener(FlexEvent.CREATION_COMPLETE,imageAddedToStage);
					UIComponent(m).addEventListener(FlexEvent.ADD,imageAddedToStage); 
					*/
					this.sizeImage(b);
					b.verticalScrollPolicy = ScrollPolicy.OFF;
					b.horizontalScrollPolicy = ScrollPolicy.OFF;
					b.setStyle('verticalAlign','middle');
					b.setStyle('horizontalAlign','center');
					this.addChild(b);
					b.addChild(DisplayObject(m));
					resizeTargets.push(m);
					//this.setImageXML(m,xml);
				}
				return i_;
			}
			private function imageAddedToStage(event:Event):void{
				if(sizeImages){
					doSizeImage(UIComponent(event.currentTarget),true);
				}
			}
			
			public function set quickSizeImages(value:Boolean):void{
				if(value){
					for each(var m:UIComponent in resizeTargets){
						m.width = imgWidth;
						m.height = imgHeight;
					}
				}
				_qsi = value;
			}
			public function get quickSizeImages():Boolean{
				return _qsi;
			}
			private var _qsi:Boolean = false;
			
			private function doSizeImage(image:UIComponent,value:Boolean):void{
				var resize:Resize = new Resize();
				resize.target = image;
				if(value){
					resize.heightFrom = 0;
					resize.heightTo = this.imgHeight;
					resize.widthFrom = 0;
					resize.widthTo = this.imgWidth;	
				} else {
					resize.heightFrom = this.imgHeight;
					resize.heightTo = 0;
					resize.widthFrom = this.imgWidth;
					resize.widthTo = 0;	
				}
				resize.play();
			}
			
			private function imageClicked(e:MALinkClickEvent):void{
				//log("Image Clicked : "+e.item);
				
				this.dispatchEvent(new MALinkClickEvent(MALinkClickEvent.LINK_CLICKED,e.item));
			}
			private function setImageXML(image:IMAsset,xml:XMLList):void{
				image.xml = xml;
			}
			
			protected override function updateDisplayList(unscaledWidth:Number, unscaledHeight:Number):void{
				super.updateDisplayList(unscaledWidth,unscaledHeight);
				for each (var img:Box in this.getChildren()){
					sizeImage(img);
				}
			}
			
			protected override function createChildren():void{
					super.createChildren();
					doLoadImages(_loadImages);
					doSizeImages(_sizeImages);
			}
			