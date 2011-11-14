package com.hphant.modsite.data.modelInfo
{
	import com.hphant.modsite.data.interfaces.ISuplimemtTranslator;

	public class ModelInfoToImageTranslator extends Object implements ISuplimemtTranslator
	{
		public function ModelInfoToImageTranslator()
		{
			super();
		}
		
		public function translate(xml:XML):XML
		{
			
			BMCDModelInfoData.setHeader(xml.thead.tr.td);
			return _translate(xml);
		}
		public function setHeader(table:XMLList):void{
			BMCDModelInfoData.setHeader(table.thead.tr.td);
		}
		public function quickTranslate(xml:XML):XML{
			return _translate(xml);
		}
		private function _translate(xml:XML):XML{
			var ul:XML = <ul />;
			ul.@['class'] = "MAImageSelectorH";
			var cnt:uint = 0;
			for each( var tr:XML in xml.tbody.tr){
					var item:BMCDModelInfoData = new BMCDModelInfoData();
					item.row = tr;
				//if(cnt > 0){
					var li:XML = new XML("<li class='Image' id='"+xml.@id+"_"+tr.childIndex()+"'/>");
					var a:XML = new XML("<a href='"+String(item.url.data)+"' />");
					var img:XML = XML(XMLList(item.images.data)[0]);
					var p:XML = new XML("<p>"+String(item.make.data)+" "+String(item.model.data)+" "+String(item.submodel.data)+"</p>");//+" "+String(item.make.data)+"</p>");
					a.appendChild(img);
					li.appendChild(a);
					li.appendChild(p);
					ul.appendChild(li);
			//	}
				cnt++;
			}
			return ul;
		}
	}
}