package com.hphant.utils
{
	import mx.collections.ArrayCollection;
	
	
	/**
	 * 	Utility class for work with collections of objects.
	 */
	public class CollectionUtil
	{

		/**
		 * 	Returns first occurence of object with specified value of property.
		 * 	@param	col		collection to find in
		 * 	@param	prop	property to find by
		 * 	@param	value	value of the property
		 */
		public static function findObjectByValueOfProperty( col:ArrayCollection, prop:String, value:Object ):Object 
		{
			var res:Object;
			
			for each (var obj:Object in col) 
			{
				if ( !obj.hasOwnProperty( prop ) ) 
				{
					throw new Error("Object ["+obj+"] doesn't contain property '"+prop+"'."); 
				}
				//trace( "obj."+prop+" = "+obj[prop] );
				
				if (obj[prop] == value) 
				{
					res = obj;
					break;
				}
			}
			return res;
		}
		
		/**
		 * 	Makes replacement of first occurence of object with specified id.
		 * 
		 * 	@param	col		collection to find in
		 * 	@param	prop	property to find by
		 * 	@param	value	value of the property
		 * 
		 * 	@return true	if replacement was successful
		 * 	@return false	otherwise
		 */
		public static function replaceObjectByID( col:ArrayCollection, backObj:Object, id:int ):Boolean 
		{
			var res:Boolean = false;
			var obj:Object;
			try {
				obj = findObjectByValueOfProperty( col, "id", id );
			} catch (err:Error) {
				trace("Object can't be found by property id" );
				return res;
			}
			if (!obj) {
				trace("Object not found with id = " + id);
				return res;
			}
			//trace("Object to replace  : "+obj );
			//trace("Replacement object : "+backObj );
			var index:int = col.getItemIndex(obj);
			col[ index ] = backObj;
			
			res = true;
			return res;
		}
		
	}
}