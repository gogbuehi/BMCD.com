package com.hphant.modsite.data.inventory
{
	import com.hphant.modsite.data.interfaces.ISuplimemtTranslator;
	
	import mx.formatters.CurrencyFormatter;

	public class SuggestedItemsTranslator extends Object implements ISuplimemtTranslator
	{
		public function SuggestedItemsTranslator()
		{
			super();
		}
		
		public function translate(xml:XML):XML
		{
			
			BMCDInventoryItemData.setHeader(xml.thead.tr.td);
			return _translate(xml);
		}
		public function setHeader(table:XMLList):void{
			BMCDInventoryItemData.setHeader(table.thead.tr.td);
		}
		public function quickTranslate(xml:XML):XML{
			return _translate(xml);
		}
		private function _translate(xml:XML):XML
		{
			var div:XML = <div />;
			div.@['class'] = "MASuggestedItems";
			var h1:XML = <h1 />;
			h1.@['class'] = "Title";
			h1.appendChild("Recommendations");
			var ul:XML = <ul />;
			ul.@['class'] = "MAImageSelectorV";
			var cnt:uint = 0;
			
			var item1:BMCDInventoryItemData = new BMCDInventoryItemData();
			item1.row = XML(xml.tbody.tr[0]);
			div.appendChild(new XML("<div class='selected' vin='"+item1.vin.data+"' />"));
			var pf:CurrencyFormatter = new CurrencyFormatter();
  			pf.currencySymbol = "$";
  			pf.thousandsSeparatorTo = ",";
  			pf.useThousandsSeparator = true;
  			pf.useNegativeSign = false;
			for each( var tr:XML in xml.tbody.tr){
					var item:BMCDInventoryItemData = new BMCDInventoryItemData();
					item.row = tr;
					var li:XML = new XML("<li class='Image' id='"+xml.@id+"_"+tr.childIndex()+"'/>");
					var a:XML = new XML("<a class='suggestion' href='"+String(item.url.data)+"' />");
					var img:XML = new XML("<img src='"+String(XML(item.photo.data).@src).replace("/images/","/thumb.php/")+"' />");
					var p1:XML = new XML("<p class='model'>"+String(item.year.data)+" "+String(item.model.data)+"</p>");//+" "+String(item.make.data)+"</p>");
					
					var p2:XML = new XML("<p class='price'>"+String(pf.format(Number(item.price.data)))+"</p>");
					if(Number(item.price.data)==0){
						p2 = new XML("<p class='price'>Call for price</p>");
					}
					a.appendChild(img);
					li.appendChild(a);
					li.appendChild(p1);
					li.appendChild(p2);
					ul.appendChild(li);
			//	}
			//	cnt++;
			}
			div.appendChild(h1);
			div.appendChild(ul);
			
			return div;
		}
		
	}
}