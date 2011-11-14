package com.hphant.modsite.admin.wizards
{
	import flash.utils.Dictionary;
	
	public interface IWizard
	{
		function nextStep():void;
		function previousStep():void;
		function goToStep(key:Object):void;
	}
}