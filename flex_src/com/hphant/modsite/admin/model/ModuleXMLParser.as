package com.hphant.modsite.admin.model
{
	import flash.events.EventDispatcher;
	
	public class ModuleXMLParser extends EventDispatcher
	{
		public function ModuleXMLParser()
		{
			super(this);
    	}
		
		private function findImageNode(node:XML):Object{
			var obj:Object = new Object();
			if(node.name().name=="img"){
				obj.img = node;
				return obj;
			}
			for each(var cnode:XML in node.children()){
				obj = findImageNode(cnode);
			} 
		}
	
	}
}