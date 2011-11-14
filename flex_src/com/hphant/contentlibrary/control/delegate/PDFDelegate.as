package com.hphant.contentlibrary.control.delegate
{
	import com.hphant.contentlibrary.model.PDF;
	import com.hphant.remoting.BaseDelegate;
	import com.hphant.remoting.IServiceCommand;
	
	import mx.rpc.AsyncToken;


	/**
	 * 	Corresponding backend service: 
	 *  <code>PDFsService</code>
	 */
	public class PDFDelegate extends BaseDelegate
	{
		public function PDFDelegate(pCommand:IServiceCommand) {
			super( pCommand, "pdfManager" );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>getSuggestedPDFs($sessionKey,$PDFObject)</code>
		 */
		public function getSuggestedPDFs( sessionKey : String ) : void {
			//	TODO
			//	Remove 'new PDF()' ??
			var token:AsyncToken = manager.getSuggestedPDFs( sessionKey, new PDF() );
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>addPDF($sessionKey,$PDFObject)</code>
		 */
		public function addPDF( sessionKey : String, PDFObject : PDF ) : void {
			var token:AsyncToken = manager.addPDF( sessionKey, PDFObject );
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>getAllPDFs($sessionKey)</code>
		 */
		public function getAllPDFs( sessionKey : String) : void {
			var token:AsyncToken = manager.getAllPDFs(sessionKey);
			registerCallbacks( token );
		}
		
		/**
		 * 	Corresponding service's method: 
		 *  <code>getPDFById($sessionKey,$id)</code>
		 */
		public function getPDFById( sessionKey : String, id : int ) : void {
			var token:AsyncToken = manager.getPDFById( sessionKey, id );
			registerCallbacks( token );
		}
		/**
		 * 	Corresponding service's method: 
		 *  <code>updatePDF($sessionKey,$PDFObject)</code>
		 */
		public function updatePDF( sessionKey : String,  PDFObject : PDF ) : void {
			var token:AsyncToken = manager.updatePDF( sessionKey, PDFObject );
			registerCallbacks( token );
		}
		/**
		 * 	Corresponding service's method: 
		 *  <code>updatePDF($sessionKey,$PDFObject)</code>
		 */
		public function removePDF( sessionKey : String,  PDFObject : PDF ) : void {
			var token:AsyncToken = manager.removePDF( sessionKey, PDFObject );
			registerCallbacks( token );
		}
	}
}