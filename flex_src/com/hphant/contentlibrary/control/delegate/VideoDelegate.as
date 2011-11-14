package com.hphant.contentlibrary.control.delegate
{
	import com.hphant.contentlibrary.model.Video;
	import com.hphant.remoting.BaseDelegate;
	import com.hphant.remoting.IServiceCommand;
	
	import mx.rpc.AsyncToken;


	/**
	 * 	Corresponding backend service: 
	 *  <code>MastersService</code>
	 */
	public class VideoDelegate extends BaseDelegate
	{
		public function VideoDelegate(pCommand:IServiceCommand) {
			super( pCommand, "videoManager" );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>getAll($sessionKey)</code>
		 */
		public function getAll( sessionKey : String ) : void {
			var token:AsyncToken = manager.getAll( sessionKey );
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>add($sessionKey,$masterObject)</code>
		 */
		public function add( sessionKey : String, videoObject : Video ) : void {
			var token:AsyncToken = manager.add( sessionKey, videoObject );
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>update($sessionKey,$masterObject)</code>
		 */
		public function update( sessionKey : String, videoObject : Video ) : void {
			var token:AsyncToken = manager.update( sessionKey, videoObject );
			registerCallbacks( token );
		}
		/**
		 * 	Corresponding service's method: 
		 *  <code>remove($sessionKey,$masterObject)</code>
		 */
		public function remove( sessionKey : String, videoObject : Video ) : void {
			var token:AsyncToken = manager.remove( sessionKey, videoObject );
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
		public function getUploadedFileNames( sessionKey : String) : void {
			var token:AsyncToken = manager.getUploadedFiles( sessionKey);
			registerCallbacks( token );
		}
		
	}
}