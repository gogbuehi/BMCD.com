package com.hphant.data.model
{
	import com.adobe.cairngorm.vo.ValueObject;
	
	import mx.collections.ArrayCollection;


	[Bindable]
	[RemoteClass(alias="DataFilter")]
	public class DataFilter implements ValueObject
	{
		
		/**
		 *	properties
		 */
		public var id 		: int;
		public var blnvalid : Boolean = true;//	must be 
		public var dt		: int;
		
		
		public var table			: String;
		
		public var column			: String;
		
		
		public var operator			: String;
		public var condition		: String;
		
		public var html_id			: String;
		public var page_url			: String;
		
		
		public function DataFilter() {}

		public function toString() : String {
			return "DataFilter<"+id+">[SELECT * FROM `"+table+"` WHERE (`"+column+"` "+operator+" "+condition+")]";
		}
		
		public function clone() : DataFilter {
			var clone : DataFilter = new DataFilter();
			
			clone.id 				= this.id;
			clone.blnvalid			= this.blnvalid;
			clone.dt				= this.dt;
			
			clone.table				= this.table;
			clone.column			= this.column;
			clone.condition			= this.condition;
		    clone.operator			= this.operator;
		    clone.html_id			= this.html_id;
		    clone.page_url			= this.page_url;
		    /* 
		    table, column, condition, operator, html_id, page_url;
		     */
		   
			return clone;
		}
		
	}
}