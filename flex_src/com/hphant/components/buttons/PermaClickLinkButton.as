package com.hphant.components.buttons
{
	import flash.events.MouseEvent;
	
	import mx.controls.LinkButton;
	public class PermaClickLinkButton extends LinkButton
	{
		public function PermaClickLinkButton()
		{
			super();
			
		}
		protected override function clickHandler(event:MouseEvent):void
	    {
	        var tenabled:Boolean = this.enabled;
	        this.enabled = true;
	        super.clickHandler(event);
	        this.enabled = tenabled; 
	    }
	}
}