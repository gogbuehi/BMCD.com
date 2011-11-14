package com.hphant.modsite.admin.model
{
	import com.hphant.contentlibrary.control.ContentModelLocator;
	import com.hphant.contentlibrary.model.Master;
	
	import flash.events.EventDispatcher;
	
	import mx.collections.ArrayCollection;
	
	public class MastersFilter extends EventDispatcher
	{
		public function MastersFilter(prop:String,value:Object)
		{
			super(this);
			this.prop = prop;
			this.value = value;
			masters = new ArrayCollection(ContentModelLocator.getInstance().masters.source);
			masters.filterFunction = f;
			masters.refresh();
		}
		public function filter(prop:String,value:Object):Array{
			this.prop = prop;
			this.value = value;
			masters.refresh();
			return masters.source;
		}
		private var prop:String;
		private var value:Object;
		private function f(master:Master):Boolean{
			return master[prop]==value;
		}
		public var masters:ArrayCollection;
	}
}