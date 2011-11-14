package com.hphant.data.control.delegate
{
	import com.hphant.data.model.InventoryRecord;
	import com.hphant.remoting.BaseDelegate;
	import com.hphant.remoting.IServiceCommand;
	
	import mx.rpc.AsyncToken;


	/**
	 * 	Corresponding backend service: 
	 *  <code>InventoryService</code>
	 */
	public class InventoryDelegate extends BaseDelegate
	{
		public function InventoryDelegate(pCommand:IServiceCommand) {
			super( pCommand, "inventoryManager" );
		}
		
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>add($sessionKey,$cropObject)</code>
		 */
		public function add( sessionKey : String, record : InventoryRecord ) : void {
			var token:AsyncToken = manager.add( sessionKey, record );
			registerCallbacks( token );
		}
		/**
		 * 	Corresponding service's method: 
		 *  <code>remove($sessionKey,$cropObject)</code>
		 */
		public function remove( sessionKey : String, record : InventoryRecord ) : void {
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
		 *  <code>getByVin($sessionKey,$vin)</code>
		 */
		public function getByVin( sessionKey : String, vin : String ) : void {
			var token:AsyncToken = manager.getByVin( sessionKey, vin );
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>getByStockNumber($sessionKey,$stockNum)</code>
		 */
		public function getByStockNumber( sessionKey : String, stockNum : String ) : void {
			var token:AsyncToken = manager.getByStockNumber( sessionKey, stockNum );
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>update($sessionKey,$cropObject)</code>
		 */
		public function update( sessionKey : String,  record : InventoryRecord ) : void {
			var token:AsyncToken = manager.update( sessionKey, record );
			registerCallbacks( token );
		}
	}
}