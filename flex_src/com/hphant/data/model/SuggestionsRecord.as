package com.hphant.data.model
{
	import com.adobe.cairngorm.vo.ValueObject;


	[Bindable]
	[RemoteClass(alias="SuggestionsRecord")]
	public class SuggestionsRecord implements ValueObject
	{
		
		/**
		 *	properties
		 */
		public var id 		: int;
		public var blnvalid : Boolean = true;//	must be 
		public var dt		: int;
		
		public var url		: String;
		public var imageURL	: String;
		public var text		: String;
		public var itemType	: String;
		public var itemID	: String;
		public var moduleID	: String;
		public var page		: String;
		
		public function SuggestionsRecord() {}

		public function toString() : String {
			return "SuggestionsRecord<"+id+">";
		}
		
		public function clone() : SuggestionsRecord {
			var clone : SuggestionsRecord = new SuggestionsRecord();
			
			clone.id 		= this.id;
			clone.blnvalid	= this.blnvalid;
			clone.dt		= this.dt;
			
			clone.url		= this.url;
			clone.imageURL	= this.imageURL;
			clone.text		= this.text;
			clone.itemType	= this.itemType;
			clone.itemID	= this.itemID;
		    clone.moduleID	= this.moduleID;
		    clone.page		= this.page;
			return clone;
		}
		
	}
}