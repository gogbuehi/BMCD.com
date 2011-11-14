// ActionScript file

			import com.hphant.modsite.site.events.MALinkClickEvent;
			import com.hphant.modsite.site.modules.interfaces.IModule;
			import flash.events.TextEvent;
			[Bindable]
			private var ttl:XMLList;
			[Bindable]
			private var txt1:XMLList;
			[Bindable]
			private var txt2:XMLList;
			[Bindable]
			private var img:XMLList;
			
			[Bindable]
			private var ht:Number;
			[Bindable]
			private var imght:Number;
			[Bindable]
			private var imgwt:Number;
			
		import com.hphant.utils.SWFResizer;
		import com.hphant.utils.XMLUtility;
		private function resizeEnd():void{
			SWFResizer.resizeFunction();
		}
			protected override function commitProperties():void{
				if(this.xmlChanged && this.title && this.text1 && this.text2){
					ttl = this._xml.h1.(attribute("class").toLowerCase()=="title");
					txt1 = this._xml.p.(attribute("class").toLowerCase()=="body");
					txt2 = this._xml.p.(attribute("class").toLowerCase()=="body2");
					XMLUtility.insertBlankNode(ttl);
					XMLUtility.insertBlankNode(txt1);
					XMLUtility.insertBlankNode(txt2);
					if(ttl.length()==0 && this.title.parent){
						this.title.parent.removeChild(this.title);
					} else if (ttl.length()>0 && !this.title.parent){
						this.vbox.addChildAt(this.title,0);
					}
					if(txt1.length()==0 && this.text1.parent){
						this.text1.parent.removeChild(this.text1);
					} else if(txt1.length()>0 && !this.text1.parent){
						this.textHolder.addChildAt(this.text1,0);
					}
					if(txt2.length()==0 && this.text2.parent){
						this.text2.parent.removeChild(this.text2);
					} else if(txt2.length()>0 && !this.text2.parent){
						this.vbox.addChildAt(this.text2,this.vbox.numChildren-1);
					}
					img = this._xml.children().(name()=="img"||name()=="a");
					if(img.length()==0){
						img = this._xml.div.(String(@['class']).toLowerCase()=="image").children().(name()=="img"||name()=="a");
					}
					if(img.length()==0)
						img = XMLList(<img src="noImage"/>);
					ht = Number(XML(this._xml).@height);
					try{
						imght = (img.name()=="img") ? img.@height : img.img.@height;
						imgwt = (img.name()=="img") ? img.@width : img.img.@width;
						imght = (imght) ? imght : 380;
						imgwt = (imgwt) ? imgwt : 460;
					} catch(e:Error){
						log("Unable to determine image size from XML : ["+img.toXMLString()+"]");
						imght = 380;
						imgwt = 460;
					}
					if(this.currentState>="state5"){
						this.title.xml = ttl;
						this.text1.xml = txt1;
						this.text2.xml = txt2;
						this.image.xml = img;
					}
					this.xmlChanged = false;
				} else if(this.xmlChanged){
					ttl = null;
					txt1 = null;
					txt2 = null;
						img = XMLList(<img src="noImage"/>);
					if(this.currentState>="state5"){
						this.title.xml = ttl;
						this.text1.xml = txt1;
						this.text2.xml = txt2;
						this.image.xml = img;
					}
				}
				super.commitProperties();
			}
			private function imageClicked(e:MALinkClickEvent):void{
				log("Image Clicked : "+e.item);
				var href:String = e.item.@href;
				this.uriManager.goToURI(href);
			}
			
			private function sendLink(event:TextEvent):void{
				this.uriManager.goToURI(event.text);
			}