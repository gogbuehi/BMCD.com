package com.hphant.modsite.admin.model
{
	import com.hphant.utils.Logger;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IEventDispatcher;

	public class HeadXML extends EventDispatcher
	{
		public function HeadXML(target:IEventDispatcher=null)
		{
			super(this);
		}
		
		private var _head:XML = <head />;
		[Inspectable]
		[Bindable]
		public function get head():XML{
			return _head;
		}
		public function set head(value:XML):void{
			_head = value ? value : <head />;
			try{
				_title = XML(_head.title).text().toString();
				this.dispatchEvent(new Event("titleChanged"));
			} catch(e:Error){
				log(e);
				title = "";
			}
			try{
				if(_head.meta.(@name=='description').length()==0){
					description = "";
				} else {
					_description = String(XML(_head.meta.(@name=='description')).@content);
					this.dispatchEvent(new Event("descriptionChanged"));
				}
			} catch(e:Error){
				log(e);
				description = "";
			}
			try{
				if(_head.meta.(@name=='keywords').length()==0){
					keywords = "";
				} else {
					_keywords = String(XML(_head.meta.(@name=='keywords')).@content);
					this.dispatchEvent(new Event("keywordsChanged"));
				}
			} catch(e:Error){
				log(e);
				description = "";
			}
			
		}
		
		private var _title:String = "";
		[Bindable("titleChanged")]
		public function get title():String{
			return _title;
		}
		public function set title(value:String):void{
			_title = value;
			//log("Setting Title");
			try{
				if(XMLList(_head.title).length() > 1){
					delete _head.title;
				}
				if(XMLList(_head.title).length()>0){
					XML(_head.title[0]).setChildren(_title);
				} else {
					_head.appendChild(XML('<title>'+_title+'</title>'));
				}
			} catch(e:Error){
				log(e);
			}
			//log(this);
			this.dispatchEvent(new Event("titleChanged"));
		}
		
		private var _description:String = "";
		[Bindable("descriptionChanged")]
		public function get description():String{
			return _description;
		}
		public function set description(value:String):void{
			_description = value;
			//log("Setting Description");
			try{
				if(XMLList(_head.meta.(@name=='description')).length() > 1){
					delete _head.meta.(@name=='description');
				}
				if(XMLList(_head.meta.(@name=='description')).length()>0){
					XML(_head.meta.(@name=='description')).@content = _description;
				} else {
					_head.appendChild(XML('<meta name="description" content="'+_description+'"></meta>'));
				}
			} catch(e:Error){
				log(e);
			}
			//log(this);
			this.dispatchEvent(new Event("descriptionChanged"));
		}
		
		private var _keywords:String = "";
		[Bindable("keywordsChanged")]
		public function get keywords():String{
			return _keywords;
		}
		public function set keywords(value:String):void{
			_keywords = value;
			//log("Setting Key Words");
			try{
				if(XMLList(_head.meta.(@name=='keywords')).length() > 1){
					delete _head.meta.(@name=='keywords');
				}
				if(XMLList(_head.meta.(@name=='keywords')).length()>0){
					XML(_head.meta.(@name=='keywords')).@content = _keywords;
				} else {
					_head.appendChild(XML('<meta name="keywords" content="'+_keywords+'"></meta>'));
				}
			} catch(e:Error){
				log(e);
			}
			//log(this);
			this.dispatchEvent(new Event("keywordsChanged"));
		}
		public override function toString():String{
			return _head.toXMLString();
		}
		protected function log(message:Object,level:uint=0):void{
			Logger.log("[HeadXML] "+message,level);
		}
	}
}