package com.hphant.contentlibrary.control.delegate
{
	import com.hphant.contentlibrary.model.Crop;
	import com.hphant.remoting.BaseDelegate;
	import com.hphant.remoting.IServiceCommand;
	
	import mx.rpc.AsyncToken;


	/**
	 * 	Corresponding backend service: 
	 *  <code>CropsService</code>
	 */
	public class CropDelegate extends BaseDelegate
	{
		public function CropDelegate(pCommand:IServiceCommand) {
			super( pCommand, "cropsManager" );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>getSuggestedCrops($sessionKey,$cropObject)</code>
		 */
		public function getSuggestedCrops( sessionKey : String ) : void {
			//	TODO
			//	Remove 'new Crop()' ??
			var token:AsyncToken = manager.getSuggestedCrops( sessionKey, new Crop() );
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>addCrop($sessionKey,$cropObject)</code>
		 */
		public function addCrop( sessionKey : String, cropObject : Crop ) : void {
			var token:AsyncToken = manager.addCrop( sessionKey, cropObject );
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>getAllCrops($sessionKey)</code>
		 */
		public function getAllCrops( sessionKey : String) : void {
			var token:AsyncToken = manager.getAllCrops(sessionKey);
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>getCropById($sessionKey,$id)</code>
		 */
		public function getCropById( sessionKey : String, id : int ) : void {
			var token:AsyncToken = manager.getCropById( sessionKey, id );
			registerCallbacks( token );
		}
		/**
		 * 	Corresponding service's method: 
		 *  <code>updateCrop($sessionKey,$cropObject)</code>
		 */
		public function updateCrop( sessionKey : String,  cropObject : Crop ) : void {
			var token:AsyncToken = manager.updateCrop( sessionKey, cropObject );
			registerCallbacks( token );
		}
		/**
		 * 	Corresponding service's method: 
		 *  <code>updateCrop($sessionKey,$cropObject)</code>
		 */
		public function removeCrop( sessionKey : String,  cropObject : Crop ) : void {
			var token:AsyncToken = manager.removeCrop( sessionKey, cropObject );
			registerCallbacks( token );
		}
	}
}