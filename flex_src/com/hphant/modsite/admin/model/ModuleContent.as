package com.hphant.modsite.admin.model
{
	import com.hphant.modsite.admin.constants.ContentTypes;
	import com.hphant.utils.Logger;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.geom.Rectangle;
	
	public class ModuleContent extends EventDispatcher
	{
		
		
		protected var _xml:XML;
		protected var _image:XML;
		protected var _video:XML;
		protected var _title:XML;
		protected var _body:XML;
		protected var _data:XMLList;
		[ArrayElementType("String")]
		protected var _dataIDs:Array;
		protected var _videoType:String = ContentTypes.NONE;
		protected var _imageType:String = ContentTypes.NONE;
		protected var _hasTitle:Boolean = false;
		protected var _hasBody:Boolean = false;
		protected var _hasImage:Boolean = false;
		protected var _hasVideo:Boolean = false;
		protected var _hasData:Boolean = false;
		[ArrayElementType("flash.geom.Rectangle")]
		protected var _imageSizes:Array;
		[ArrayElementType("flash.geom.Rectangle")]
		protected var _videoSizes:Array;
		protected var _thumbSize:Rectangle;
		
		public var moduleClassName:String;
		
		public function ModuleContent()
		{
			super(this);
		}
		
		[Bindable]
		public function get thumbSize():Rectangle{
			return this._thumbSize;
		}
		public function set thumbSize(value:Rectangle):void{
			this._thumbSize = value;
		}
		
		[Bindable]
		[ArrayElementType("flash.geom.Rectangle")]
		public function get imageSizes():Array{
			return this._imageSizes;
		}
		public function set imageSizes(value:Array):void{
			this._imageSizes = value;
		}
		
		[Bindable]
		[ArrayElementType("String")]
		public function get dataIDs():Array{
			return this._dataIDs;
		}
		public function set dataIDs(value:Array):void{
			this._dataIDs = value;
		}
		
		[Bindable]
		[ArrayElementType("flash.geom.Rectangle")]
		public function get videoSizes():Array{
			return this._videoSizes;
		}
		public function set videoSizes(value:Array):void{
			this._videoSizes = value;
		}
		
		[Bindable(event="imageChanged")]
		public function get image():XMLList{
			return (_image) ? _image.children() : null;
		}
		
		[Bindable(event="videoChanged")]
		public function get video():XMLList{
			return (_video) ? _video.children() : null;
		}
		[Bindable(event="titleChanged")]
		public function get title():XMLList{
			return (_title) ? _title.children() : null;
		}
		[Bindable(event="bodyChanged")]
		public function get body():XMLList{
			return (_body) ? _body.children() : null;
		}
		[Bindable(event="dataChanged")]
		public function get data():XMLList{
			return _data
		}
		public function set data(value:XMLList):void{
			if(_data != value){
				_data = value;
				handleNewData();
			}
		}
		
		[Bindable(event="titleChanged")]
		public function get titleString():String{
			return _titleString;
		}
		public function set titleString(value:String):void{
			_titleString = value;
			log("Setting Title Text to :"+value);
			this.setTitle(XMLList(value));
		}
		private var _titleString:String;
		
		[Bindable(event="dataClassesChanged")]
		public function get dataClasses():Array{
			return _dataClasses;
		}
		public function set dataClasses(value:Array):void{
			_dataClasses = value;
			this.dispatchEvent(new Event("dataClassesChanged"));
		}
		private var _dataClasses:Array = [];
		
		[Bindable(event="bodyChanged")]
		public function get bodyString():String{
			return _bodyString;
		}
		public function set bodyString(value:String):void{
			_bodyString = value;
			this.setBody(XMLList(value));
		}
		private var _bodyString:String;
		
		public function setImage(value:XMLList):void{
			if(_image){
				XML.ignoreWhitespace = false;
				_image.setChildren(value ? value : '');
				this.dispatchEvent(new Event("imageChanged"));
			}
		}
		
		public function setVideo(value:XMLList):void{
			if(_video){
				XML.ignoreWhitespace = false;
				_video.setChildren(value ? value : '');
				this.dispatchEvent(new Event("videoChanged"));
			}
		}
		
		public function setBody(value:XMLList):void{
			if(!_body){
				_body = XML('<p class="Body" />');
			}
			if(_body){
				XML.ignoreWhitespace = false;
				_body.setChildren(value ? value : '');
				this.dispatchEvent(new Event("bodyChanged"));
			}
		}
		
		public function setTitle(value:XMLList):void{
			if(!_title){
				_title = XML('<h1 class="Title" />');
			}
			if(_title){
				XML.ignoreWhitespace = false;
				_title.setChildren(value ? value : '');
				this.dispatchEvent(new Event("titleChanged"));
			}
		}
		
		
		[Bindable]
		public function get hasData():Boolean{
			return _hasData;
		}
		public function set hasData(value:Boolean):void{
			this._hasData = value;
		}
		[Bindable]
		public function get hasImage():Boolean{
			return _hasImage;
		}
		public function set hasImage(value:Boolean):void{
			this._hasImage = value;
		}
		[Bindable]
		public function get hasVideo():Boolean{
			return _hasVideo;
		}
		public function set hasVideo(value:Boolean):void{
			this._hasVideo = value;
		}
		[Bindable]
		public function get hasBody():Boolean{
			return _hasBody;
		}
		public function set hasBody(value:Boolean):void{
			this._hasBody = value;
		}
		[Bindable]
		public function get hasTitle():Boolean{
			return _hasTitle;
		}
		public function set hasTitle(value:Boolean):void{
			this._hasTitle = value;
		}
		[Bindable(event="imageTypeChanged")]
		public function get imageType():String{
			return this._imageType;
		}
		[Bindable(event="videoTypeChanged")]
		public function get videoType():String{
			return this._videoType;
		}
		public function useContentFrom(content:ModuleContent):void{
			log('Taking content from '+content+' to '+this+'.');
			XML.prettyPrinting = false;
			XML.ignoreWhitespace = false;
			_body = (hasBody) ? (content._body) ? content._body : XML('<p class="Body" />') : null;
			_title = (hasTitle) ? (content._title) ? content._title : XML('<h1 class="Title" />') : null;
			
			
			/* if(_data){
				this.hasImage = content.hasImage;
				this.hasVideo = content.hasVideo;
			} */
			/* if(this.hasImage || this.hasVideo){
				this.hasData = false;
			} */
			
			_bodyString = (hasBody) ? content._bodyString : null;
			_titleString = (hasTitle) ? content._titleString : null;
			if(hasImage){
				if(content.imageType != ContentTypes.NONE){
					var imgList:ImageListXML = new ImageListXML();
					var img:ImageXML = new ImageXML();
					switch(this.imageType){
						case content.imageType:
							log("Same Image Content Type.");
							log("From: "+_image);
							log("To: "+content._image);
							_image = content._image;
							log("Now: "+_image);
						break;
						case ContentTypes.LIST:
							log("Image: Single to List");
							imgList.liClass = "Image";
							img.parse(content.image);
							img.link = img.source;
							imgList.addImage(img);
							_image = XML('<ul class="Images">'+imgList.toXMLString()+'</ul>');
						break;
						case ContentTypes.SINGLE:
							log("Image: List to Single");
							imgList.parse(content.image);
							if(imgList.images.length>0){
								img = ImageXML(imgList.images[0]);
								img.source = img.link;
								img.link = null;
								_image = XML('<div class="Image">'+img.toXMLString()+'</div>');
							}
						break;
					}
					this.dispatchEvent(new Event("imageChanged"));
				} else {
					findImage();
				}
			} else {
				_image = null;
				this.dispatchEvent(new Event("imageChanged"));
			}
			if(hasVideo){
				if(content.videoType != ContentTypes.NONE){
					var vidList:ImageListXML = new ImageListXML();
					var vid:VideoXML = new VideoXML();
					var timg:ImageXML = new ImageXML();
					switch(this.videoType){
						case content.videoType:
							_video = content._video;
						break;
						case ContentTypes.LIST:
							vidList.liClass = "Video";
							vid.parse(content.video);
							timg.link = vid.source;
							timg.text = vid.text;
							vidList.addImage(img);
							_video = XML('<ul class="Videos">'+vidList.toXMLString()+'</ul>');
						break;
						case ContentTypes.SINGLE:
							vidList.parse(content.video);
							if(vidList.images.length>0){
								timg = ImageXML(vidList.images[0]);
								vid.source = timg.link;
								vid.text = timg.text;
								_video = XML('<div class="Video">'+vid.toXMLString()+'</div>');
							}
						break;
					}
					this.dispatchEvent(new Event("videoChanged"));
				} else {
					findVideo();
				}
			} else {
				_video = null;
				this.dispatchEvent(new Event("videoChanged"));
			}
			_xml = content._xml;
			data = (hasData && content._data) ? content._data : null;
			this.dispatchEvent(new Event("titleChanged"));
			this.dispatchEvent(new Event("bodyChanged"));
			this.dispatchEvent(new Event("xmlChanged"));
			this.dispatchEvent(new Event("dataChanged"));
		}
		[Bindable(event="xmlChanged")]
		public function set xml(value:XML):void{
			_xml = value;
			if(_xml){
				this.moduleClassName = String(_xml.@['class']);
				findBody();
				findTitle();
				try{
				findImage();
				} catch(e:Error){
					log("Image Error:"+e);
				}
				try{
				findVideo();
				} catch(e:Error){
					log("Video Error:"+e);
				}
				try{
				findSimpleUL();
				} catch(e:Error){
					log("Simple UL Error:"+e);
				}
				try{
				findData();
				} catch(e:Error){
					log("Data Error:"+e);
				}
				
			} else {
				this.moduleClassName = null;
				_body = _title = _image = _video = null;
				_data = null;
				_dataIDs = null;
				_hasData = _hasBody = _hasTitle = _hasImage = _hasVideo = false;
			}
			this.dispatchEvent(new Event("xmlChanged"));
		}
		public function get xml():XML{
			XML.prettyPrinting = false;
			XML.ignoreWhitespace = false;
			/* if(_data && _dataIDs){
				for(var i:uint=0;i<_dataIDs.length;i++){
					if(this.dataClasses[i]){
						_data[i].@['class'] = this.dataClasses[i]
					}
					_data[i].@id = _dataIDs[i];
				}
			} */
			var div:XML = XML('<div '+(this.moduleClassName ? 'class="'+this.moduleClassName+'"' : '')+'>'+
									  (_title && _title.children().length()>0 ? _title.toXMLString() : "")+
									  (_body && _body.children().length()>0 ? _body.toXMLString() : "")+
									  (_data && _data.length()>0 ? _data.toXMLString() : "")+
									  (_image && _image.children().length()>0 ? _image.toXMLString() : "")+
									  (_video && _video.children().length()>0 ? _video.toXMLString() : "")+'</div>');						  
			return div;
		}
		protected function findData():void{
			XML.prettyPrinting = false;
			XML.ignoreWhitespace = false;
			_data = (_xml.table.length()>0) ? _xml.table : null;
			handleNewData();
		}
		private function handleNewData():void{
			_dataIDs = new Array;
			this._dataClasses = new Array;
			for each(var table:XML in _data){
				_dataIDs.push(String(table.@id));
				_dataClasses.push(String(table.@['class']));
			}
			hasData = (_data!=null);
			log("Data("+hasData+")");
			/* if(this.hasImage || this.hasVideo){
				this.hasData = false;
			} */
			this.dispatchEvent(new Event("dataClassesChanged"));
			this.dispatchEvent(new Event("dataChanged"));
		}
		protected function findBody():void{
			XML.prettyPrinting = false;
			XML.ignoreWhitespace = false;
			if(_xml){
			var b:XMLList = _xml.p.(String(@['class']).toLowerCase() == "body");
			if(b.length()>0){
				XML.prettyPrinting = false;
				XML.ignoreWhitespace = false;
				_bodyString = b.children().toString();
				_body = XML('<p class="Body">'+_bodyString+'</p>');
				hasBody = true;
			} else {
				_body = null;
				_bodyString = null;
				hasBody = false;
			}
			}
			XML.prettyPrinting = false;
			log("Body("+hasBody+"): "+_body);
			this.dispatchEvent(new Event("bodyChanged"));
		}
		protected function findTitle():void{
			XML.prettyPrinting = false;
			XML.ignoreWhitespace = false;
			if(_xml){
			var t:XMLList = _xml.h1.(String(@['class']).toLowerCase() == "title");
				if(t.length()>0){
				XML.prettyPrinting = false;
				XML.ignoreWhitespace = false;
				
				_titleString = t.children().toString();
				_title = XML('<h1 class="Title">'+_titleString+'</h1>');
				hasTitle = true;
			} else {
				_title = null;
				_titleString = null;
				hasTitle = false;
			}
			}
			log("Title("+hasTitle+"): "+_title);
			this.dispatchEvent(new Event("titleChanged"));
		}
		protected function findImage():void{
			XML.prettyPrinting = false;
			XML.ignoreWhitespace = false;
			log("Image: Looking for image");
			if(_xml){
			var ul:XMLList = _xml.ul.(String(@['class']).toLowerCase()=="images");
			var img:XMLList = _xml.div.(String(@['class']).toLowerCase()=="image");
			var ptype:String = this._imageType;
			if(img.length()==0){
				img = _xml.children().(name()=="img" || name()=="a");
				if(img.length()>0){
					img = XMLList('<div class="Image">'+img.toXMLString()+'</div>');
				}
			}
			if(ul.length()>0){
				var list:ImageListXML = new ImageListXML();
				list.parse(ul);
				list.liClass = "Image";
				this._imageType = ContentTypes.LIST;
				this._image = XML('<ul class="Images">'+list.toXMLString()+'</ul>');
				hasImage = true;
			} else if(img.length()>0){
				this._imageType = ContentTypes.SINGLE;
				_image = XML('<div class="Image">'+img.children().toXMLString()+'</div>');
				hasImage = true;
			} else {
				this._imageType = ContentTypes.NONE;
				_image = null;
				hasImage = false;
			}
			}
			log("Image("+hasImage+"|"+_imageType+"): "+_image);
			this.dispatchEvent(new Event("imageChanged"));
			if(ptype!=this._imageType){
				this.dispatchEvent(new Event("imageTypeChanged"));
			}
		}
		protected function findVideo():void{
			XML.prettyPrinting = false;
			XML.ignoreWhitespace = false;
			log("Video: Looking for video");
			if(_xml){
			var ul:XMLList = _xml.ul.(String(@['class']).toLowerCase()=="videos");
			var vid:XMLList = _xml.div.(String(@['class']).toLowerCase()=="video");
			var ptype:String = this._videoType;
			if(ul.length()>0){
				var list:ImageListXML = new ImageListXML();
				list.parse(ul);
				list.liClass = "Video";
				this._videoType = ContentTypes.LIST;
				this._video = XML('<ul class="Videos">'+list.toXMLString()+'</ul>');
				hasVideo = true;
			} else if(vid.length()>0){
				this._videoType = ContentTypes.SINGLE;
				_video = XML('<div class="Video">'+vid.children().toXMLString()+'</div>');
				hasVideo = true;
			} else {
				this._videoType = ContentTypes.NONE;
				_video = null;
				hasVideo = false;
			}
			}
			log("Video("+hasVideo+"|"+_videoType+"): "+_video);
			this.dispatchEvent(new Event("videoChanged"));
			if(ptype!=this._videoType){
				this.dispatchEvent(new Event("videoTypeChanged"));
			}
		}
		protected function findSimpleUL():void{
			XML.prettyPrinting = false;
			XML.ignoreWhitespace = false;
			var vtype:String = this._videoType;
			var itype:String = this._imageType;
			log("Simple UL: Looking for image or video lists");
			if(_xml){
			var ul:XMLList = _xml.ul;
			if(!_video && ul.length()>0){
				var list:ImageListXML = new ImageListXML();
				list.parse(ul);
				if(list.liClass=="Video" && ul.li.embed.length()==0 ||
				   (list.liClass!="Video" && ul.li.embed.length()==0 && list.images.length > 0 && ImageXML(list.images[0]).link && ImageXML(list.images[0]).link.indexOf(".flv")>-1)){
					this._videoType = ContentTypes.LIST;
					this._hasVideo = true;
					this._video = XML('<ul class="Videos">'+list.toXMLString()+'</ul>');
					
				} else if(ul.li.embed.length()>0){
					var embeds:Array = new Array();
					for each(var li:XML in ul.li){
						var img:ImageXML = new ImageXML();
						img.text = li.p.children().toXMLString();
						img.source = "no_image";
						img.link = li.embed.@src;
						embeds.push(img);
					}
					list.images = embeds;
					this._videoType = ContentTypes.LIST;
					this._hasVideo = true;
					this._video = XML('<ul class="Videos">'+list.toXMLString()+'</ul>');
				}
				log("Video("+_hasVideo+"|"+_videoType+"): "+_video);
				this.dispatchEvent(new Event("videoChanged"));
				if(vtype!=this._videoType){
					this.dispatchEvent(new Event("videoTypeChanged"));
				}
			}
			if(!_image && ul.length()>0){
				if((list.images.length > 0 && list.liClass=="Image") || 
				  (list.images.length > 0 && list.liClass!="Video" && ul.li.embed.length()==0 && ImageXML(list.images[0]).link && ImageXML(list.images[0]).link.indexOf(".flv")==-1)){
					this._imageType = ContentTypes.LIST;
					this._hasImage = true;
					this._image = XML('<ul class="Images">'+list.toXMLString()+'</ul>');
				}
				log("Image("+_hasImage+"|"+_imageType+"): "+_image);
				this.dispatchEvent(new Event("imageChanged"));
				if(itype!=this._imageType){
					this.dispatchEvent(new Event("imageTypeChanged"));
				}
			}
			}
		}
		public function toXMLString():String{
			var p:Object = XML.settings();
			var t:XML = this.xml;
			XML.prettyPrinting = true;
			var s:String = t.toXMLString();
			XML.setSettings(p);
			return s;
		}
		protected function log(message:Object,level:uint=0):void{
			Logger.log("[ModuleContent:"+this.moduleClassName+":"+this+"] "+message,level);
		}
	}
}