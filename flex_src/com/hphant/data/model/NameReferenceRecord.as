package com.hphant.data.model
{
	import com.adobe.cairngorm.vo.ValueObject;
	
	import mx.collections.ArrayCollection;


	[Bindable]
	[RemoteClass(alias="NameReferenceRecord")]
	public class NameReferenceRecord implements ValueObject
	{
		
		/**
		 *	properties
		 */
		public var id 		: int;
		public var blnvalid : Boolean = true;//	must be 
		public var dt		: int;
		
		
		public var name			:String = "";
		public var name_string			: String = "";
		public var logo			: String = "";
		
		public function NameReferenceRecord() {}

		public function toString() : String {
			return "NameReferenceRecord<"+id+">";
		}
		
		public function clone() : NameReferenceRecord {
			var clone : NameReferenceRecord = new NameReferenceRecord();
			
			clone.id 				= this.id;
			clone.blnvalid			= this.blnvalid;
			clone.dt				= this.dt;
			
			clone.name				= this.name;
			clone.name_string		= this.name_string;
			clone.logo			= this.logo;
		    
		   
			return clone;
		}
		
	}
}