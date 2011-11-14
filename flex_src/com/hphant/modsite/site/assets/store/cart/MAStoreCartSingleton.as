package com.hphant.modsite.site.assets.store.cart
{
	public class MAStoreCartSingleton extends MAStoreCart
	{
		private static var _instance:MAStoreCartSingleton;
		public function MAStoreCartSingleton()
		{
			super();
			if(!MAStoreCartSingleton._instance){
				MAStoreCartSingleton._instance = this;
			} else {
				throw new Error("Only one instance of MAStoreCartSingleton is allowed. Use MAStoreCartSingleton.getInstance()");
			}
		}
		public static function getInstance():MAStoreCartSingleton{
			if(!_instance){
				_instance = new MAStoreCartSingleton();
			}
			return _instance;
		}
		
	}
}