package com.hphant.components.buttons
{
	import flash.text.TextFormat;
	import flash.text.TextLineMetrics;
	
	import mx.controls.Button;
	public class MultiLineButton extends Button
	{
		public function MultiLineButton()
		{
			super();
		}
		override protected function createChildren():void
		{
		     super.createChildren();
		     if (textField){
		         textField.wordWrap = false;
		         textField.multiline = true;
		         //var tf:TextFormat = textField.getTextFormat();
		         //tf.leading = this.getStyle('leading');
		         //textField.setTextFormat(tf);
		     }
		}
		
		override public function measureText(s:String):TextLineMetrics
		{
		     textField.text = s;
		     var lineMetrics:TextLineMetrics = textField.getLineMetrics(0);
		     lineMetrics.width = textField.textWidth;
		     lineMetrics.height = textField.textHeight;
		
		     return lineMetrics;
		}
	}
}