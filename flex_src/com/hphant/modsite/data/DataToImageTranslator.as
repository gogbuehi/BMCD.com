package com.hphant.modsite.data
{
	import com.hphant.modsite.data.interfaces.ISuplimemtTranslator;
	import com.hphant.utils.Logger;
	
	import flash.events.EventDispatcher;

	public class DataToImageTranslator extends EventDispatcher implements ISuplimemtTranslator
	{
		public function DataToImageTranslator()
		{
			super(this);
			if(instance)
				throw new Error("Singleton! Use DataToImageTranslator.getInstance()");
		}
		private static var instance:DataToImageTranslator;
		public static function getInstance():DataToImageTranslator{
			if(!instance)
				instance = new DataToImageTranslator();
			return instance;
		}
		private var translators:Object = new Object();
		public static function registerTranslator(dataName:String,translator:ISuplimemtTranslator):void{
			getInstance().translators[dataName.toLowerCase()] = translator;
		}
		
		public function setHeader(table:XMLList):void{
			var cls:String = '';
			var id:String = '';
			try{
				id = table.@id ? String(String(table.@id).split('_')[0]).toLowerCase() : '';
				cls = table.@['class'] ? String(table.@['class']).toLowerCase() : '';
				if((translators[cls]) || (translators[id])){
				var trltr:ISuplimemtTranslator = (translators[cls]) ? ISuplimemtTranslator(translators[cls]) : ISuplimemtTranslator(translators[id]);
				trltr.setHeader(table);
				}
			} catch (e:Error){
				Logger.log('[DataToImageTranslator:'+cls+'] '+e.message+'\n'+e.getStackTrace(),2);	
			}
		}
		public function quickTranslate(xml:XML):XML{
			var ul:XML = <ul/>
			var cls:String = '';
			var id:String = '';
			try{
				id = xml.@id ? String(String(xml.@id).split('_')[0]).toLowerCase() : '';
				cls = xml.@['class'] ? String(xml.@['class']).toLowerCase() : '';
				if((translators[cls]) || (translators[id])){
				var trltr:ISuplimemtTranslator = (translators[cls]) ? ISuplimemtTranslator(translators[cls]) : ISuplimemtTranslator(translators[id]);
				ul = trltr.quickTranslate(xml);
				}
			} catch (e:Error){
				Logger.log('[DataToImageTranslator:'+cls+'|'+id+'|'+xml.@id+'] '+e.message+'\n'+e.getStackTrace(),2);	
			}
			return ul;
		}
		public function translate(xml:XML):XML{
			var ul:XML = <ul/>
			var cls:String = '';
			var id:String = '';
			try{
				id = xml.@id ? String(String(xml.@id).split('_')[0]).toLowerCase() : '';
				cls = xml.@['class'] ? String(xml.@['class']).toLowerCase() : '';
				if((translators[cls]) || (translators[id])){
				var trltr:ISuplimemtTranslator = (translators[cls]) ? ISuplimemtTranslator(translators[cls]) : ISuplimemtTranslator(translators[id]);
				ul = trltr.translate(xml);
				}
			} catch (e:Error){
				Logger.log('[DataToImageTranslator:'+cls+'] '+e.message+'\n'+e.getStackTrace(),2);	
			}
			return ul;
		}
	}
}