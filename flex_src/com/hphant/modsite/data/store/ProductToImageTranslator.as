package com.hphant.modsite.data.store
{
	import com.hphant.modsite.data.interfaces.ISuplimemtTranslator;

	public class ProductToImageTranslator extends Object implements ISuplimemtTranslator
	{
		public function ProductToImageTranslator()
		{
			super();
		}
		
		public function translate(xml:XML):XML
		{
			
			BMCDStoreItemData.setHeader(xml.thead.tr.td);
			return _translate(xml);
		}
		public function setHeader(table:XMLList):void{
			BMCDStoreItemData.setHeader(table.thead.tr.td);
		}
		public function quickTranslate(xml:XML):XML{
			return _translate(xml);
		}
		private function _translate(xml:XML):XML
		{
			var ul:XML = <ul />;
			ul.@['class'] = "MAImageSelectorH";
			var cnt:uint = 0;
			for each( var tr:XML in xml.tbody.tr){
					var item:BMCDStoreItemData = new BMCDStoreItemData();
					item.row = tr;
				//if(cnt > 0){
					trace("The thumb should be: "+item.thumb.data);
					var li:XML = new XML("<li class='Image' id='"+xml.@id+"_"+tr.childIndex()+"'/>");
					var a:XML = new XML("<a href='"+String(item.url.data)+"' />");
					var img:XML = XML(item.thumb.data);// = new XML("<img src='"+String(XML(item.thumb.data).@src)+"' />");//.replace("/images/","/thumb.php/")+"' />");
					
					var p:XML = new XML("<p>"+String(item.brand.data)+" "+String(item.title.data)+"</p>");//+" "+String(item.make.data)+"</p>");
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