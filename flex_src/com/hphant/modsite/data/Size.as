package com.hphant.modsite.data
{
	import flash.events.EventDispatcher;

	public class Size extends EventDispatcher
	{
		[Bindable]
		public var width:Number;
		[Bindable]
		public var height:Number;
		public function Size(obj:Object=null)
		{
			super(this);
			this.width = (obj && obj.width) ? obj.width : 0;
			this.height = (obj && obj.height) ? obj.height : 0;
		}
		
	}
}