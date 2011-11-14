package com.hphant.skins
{
	import mx.skins.halo.ButtonSkin;

	public class FixedButtonSkin extends ButtonSkin
	{
		public function FixedButtonSkin()
		{
			super();
		}
		protected override function updateDisplayList(w:Number, h:Number):void{
			super.updateDisplayList((isNaN(w) ? 0 : w),(isNaN(h) ? 0 : h));
		}
	}
}