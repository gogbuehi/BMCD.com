package com.hphant.data.control.delegate
{
	import com.hphant.data.model.ModelRecord;
	import com.hphant.remoting.BaseDelegate;
	import com.hphant.remoting.IServiceCommand;
	
	import mx.rpc.AsyncToken;


	/**
	 * 	Corresponding backend service: 
	 *  <code>ModelService</code>
	 */
	public class ModelDelegate extends BaseDelegate
	{
		public function ModelDelegate(pCommand:IServiceCommand) {
			super( pCommand, "modelManager" );
		}
		
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>add($sessionKey,$cropObject)</code>
		 */
		public function add( sessionKey : String, record : ModelRecord ) : void {
			var token:AsyncToken = manager.add( sessionKey, record );
			registerCallbacks( token );
		}
		/**
		 * 	Corresponding service's method: 
		 *  <code>remove($sessionKey,$cropObject)</code>
		 */
		public function remove( sessionKey : String, record : ModelRecord ) : void {
			var token:AsyncToken = manager.remove( sessionKey, record );
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>getAll($sessionKey)</code>
		 */
		public function getAll( sessionKey : String) : void {
			var token:AsyncToken = manager.getAll(sessionKey);
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>getById($sessionKey,$id)</code>
		 */
		public function getById( sessionKey : String, id : int ) : void {
			var token:AsyncToken = manager.getById( sessionKey, id );
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>getByModel($sessionKey,$model,$submodel)</code>
		 */
		public function getByModel( sessionKey : String, make :String, model : String, submodel:String ) : void {
			var token:AsyncToken = manager.getById( sessionKey, make, model, submodel);
			registerCallbacks( token );
		}
		/**
		 * 	Corresponding service's method: 
		 *  <code>update($sessionKey,$cropObject)</code>
		 */
		public function update( sessionKey : String,  record : ModelRecord ) : void {
			var token:AsyncToken = manager.update( sessionKey, record );
			registerCallbacks( token );
		}
	}
}