package com.hphant.utils
{
	import mx.collections.ListCollectionView;
	
	public interface IGroupFilter
	{
		function getGroupValue(item:Object):Object;
		function sortGroups(groups:Array):void;
		function sortAll(data:ListCollectionView):void;
	}
}