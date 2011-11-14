package com.hphant.modsite.data.store
{
	import com.hphant.modsite.data.interfaces.ISuplimemtTranslator;
	
	import mx.formatters.CurrencyFormatter;

	public class StoreSuggestedItemsTranslator extends Object implements ISuplimemtTranslator
	{
		public function StoreSuggestedItemsTranslator()
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
			
			var item1:BMCDStoreItemData = new BMCDStoreItemData();
			item1.row = XML(xml.tbody.tr[0]);
			var pf:CurrencyFormatter = new CurrencyFormatter();
  			pf.currencySymbol = "$";
  			pf.thousandsSeparatorTo = ",";
  			pf.useThousandsSeparator = true;
  			pf.useNegativeSign = false;
			for each( var tr:XML in xml.tbody.tr){
					var item:BMCDStoreItemData = new BMCDStoreItemData();
					item.row = tr;
					var li:XML = new XML("<li class='Image' id='"+xml.@id+"_"+tr.childIndex()+"'/>");
					var a:XML = new XML("<a class='suggestion' href='"+String(item.url.data)+"' />");
					var img:XML = new XML("<img src='"+String(XML(item.thumb.data).@src)+"' />");
					var p1:XML = new XML("<p>"+String(item.title.data)+"</p>");//+" "+String(item.make.data)+"</p>");
					
					var p2:XML = new XML("<p>"+String(pf.format(Number(item.price.data)))+"</p>");
					if(Number(item.price.data)==0){
						p2 = new XML("<p>Call for Price</p>");
					}
					a.appendChild(img);
					li.appendChild(a);
					li.appendChild(p1);
					li.appendChild(p2);
					ul.appendChild(li);
			//	}
			//	cnt++;
			}
			return ul;
		}
		
	}
}