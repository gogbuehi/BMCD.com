package com.hphant.contentlibrary.control
{
	import com.adobe.cairngorm.*;
	import com.adobe.cairngorm.control.FrontController;
	import com.hphant.contentlibrary.control.command.*;
	import com.hphant.contentlibrary.control.event.*;


	public class ContentClientController extends FrontController {
		
		static private var _instance:ContentClientController;
		
		static public function getInstance():ContentClientController {
			if(!_instance){
				_instance = new ContentClientController();
			}
			return _instance;
		}

		public function ContentClientController()
        {
			if ( _instance )
           	{
           		throw new CairngormError( CairngormMessageCodes.SINGLETON_EXCEPTION, "ClientController" );
            }
           	_instance = this;
			initialiseCommands();
        }
        
        
        /**
        *	Registers commands. 	
        */
        public function initialiseCommands() : void
        {
            
            //	Images-related commands
            addCommand( ImageEvent.GET_ALL_MASTERS,		ImageGetAllCommand );
            addCommand( ImageEvent.ADD_MASTER_IMAGE,	ImageAddMasterCommand );
            addCommand( ImageEvent.UPDATE_MASTER_IMAGE, ImageUpdateMasterCommand );
            addCommand( ImageEvent.GET_MASTER_BY_ID,	ImageGetMasterByIdCommand );
            addCommand( ImageEvent.REMOVE_MASTER_IMAGE,	ImageRemoveMasterCommand );
            
            //	Crops-related commands
            addCommand( CropEvent.GET_SUGGESTED_CROPS, 	CropGetSuggestedCommand );
            addCommand( CropEvent.ADD_CROP,			 	CropAddCommand );
            addCommand( CropEvent.UPDATE_CROP,			CropUpdateCommand );
            addCommand( CropEvent.GET_ALL_CROPS,		CropGetAllCommand );
            addCommand( CropEvent.GET_CROP_BY_ID,		CropGetByIdCommand );
            addCommand( CropEvent.REMOVE_CROP,			CropRemoveCommand );
            
            //	Videos-related commands
            addCommand( VideoEvent.UPDATE_VIDEO,		VideoUpdateCommand );
            addCommand( VideoEvent.ADD_VIDEO,			VideoAddCommand );
            addCommand( VideoEvent.GET_ALL_VIDEOS,		VideoGetAllCommand );
            addCommand( VideoEvent.GET_VIDEO_BY_ID,		VideoGetByIdCommand );
            addCommand( VideoEvent.GET_UPLOADED_FILES,	VideoGetUploadedCommand );
            addCommand( VideoEvent.REMOVE_VIDEO,		VideoRemoveCommand );
            
            
            //	PDFs-related commands
            addCommand( PDFEvent.ADD_PDF,			 	PDFAddCommand );
            addCommand( PDFEvent.UPDATE_PDF,			PDFUpdateCommand );
            addCommand( PDFEvent.GET_ALL_PDFS,		PDFGetAllCommand );
            addCommand( PDFEvent.GET_PDF_BY_ID,		PDFGetByIdCommand );
            addCommand( PDFEvent.REMOVE_PDF,			PDFRemoveCommand );
            
       }
		
	}
}