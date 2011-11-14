package com.hphant.modsite.system
{
	import com.hphant.interfaces.IMenuConverter;
	
	import mx.core.Application;
	import mx.utils.URLUtil;

	public class ModSiteMenuConverter implements IMenuConverter
	{
		public function ModSiteMenuConverter()
		{
		}

		public function toTreeXMLList(menu:XMLList):XMLList
		{
			var tree:XML = <tree />;
			for each(var ul:XML in menu){
				for each(var li:XML in ul.li){
					var item:XML = <item />;
					/* if(String(li.a.@href).indexOf("http://")!=0 && String(li.a.@href).indexOf("mailto:")!=0){
						li.a.@href = "http://"+URLUtil.getServerName(Application.application.url)+li.a.@href;
					} */
					item.@link = li.a.@href;
					item.@label = XML(li.a).children().toString();
					if(XMLList(li.ul).length()>0){
						item.setChildren(toTreeXMLList(li.ul));
					}
					tree.appendChild(item);
				}
			}
			return XMLList(tree.item);
		}
		
	}
}