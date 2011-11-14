package com.hphant.contentlibrary.control.delegate
{
	import com.hphant.contentlibrary.model.Master;
	import com.hphant.remoting.BaseDelegate;
	import com.hphant.remoting.IServiceCommand;
	
	import mx.rpc.AsyncToken;


	/**
	 * 	Corresponding backend service: 
	 *  <code>MastersService</code>
	 */
	public class ImageDelegate extends BaseDelegate
	{
		public function ImageDelegate(pCommand:IServiceCommand) {
			super( pCommand, "mastersManager" );
			this.className = "ImageDelegate";
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>getAllMasters($sessionKey)</code>
		 */
		public function getAllMasters( sessionKey : String ) : void {
			log("getAllMasters called");
			var token:AsyncToken = manager.getAllMasters( sessionKey );
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>addMaster($sessionKey,$masterObject)</code>
		 */
		public function addMasterImage( sessionKey : String, masterObject : Master ) : void {
			log("addMasterImage called:"+masterObject+"\nTitle: "+masterObject.title+"\nAlternate: "+masterObject.alternate);
			var token:AsyncToken = manager.addMaster( sessionKey, masterObject );
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>updateMaster($sessionKey,$masterObject)</code>
		 */
		public function updateMaster( sessionKey : String, masterObject : Master ) : void {
			log("updateMaster called:"+masterObject+"\nTitle: "+masterObject.title+"\nAlternate: "+masterObject.alternate);
			var token:AsyncToken = manager.updateMaster( sessionKey, masterObject );
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>removeMaster($sessionKey,$masterObject)</code>
		 */
		public function removeMaster( sessionKey : String, masterObject : Master ) : void {
			log("removeMaster called:"+masterObject);
			var token:AsyncToken = manager.removeMaster( sessionKey, masterObject );
			registerCallbacks( token );
		}

		/**
		 * 	Corresponding service's method: 
		 *  <code>getMasterById($sessionKey,$id)</code>
		 */
		public function getMasterById( sessionKey : String, id : int ) : void {
			log("getMasterById called:"+id);
			var token:AsyncToken = manager.getMasterById( sessionKey, id );
			registerCallbacks( token );
		}
		
	}
}