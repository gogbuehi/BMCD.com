package com.hphant.configurators
{
	import com.hphant.constants.ImageConstants;

	
	public class ImageCropperConfigurator
	{
		
		public static const WIDTH_CROP		: int = ImageConstants.MASTER_WIDTH;
		public static const HEIGHT_CROP		: int = ImageConstants.MASTER_HEIGHT;
		public static const WIDTH_THUMB		: int = ImageConstants.THUMB_WIDTH;
		public static const HEIGHT_THUMB	: int = ImageConstants.THUMB_HEIGHT;
		
		public static const EMPTY_IMAGE_PATH: String = "assets/images/No_Photo.jpg";
		
		/*
		//	outdated
		public static const UPLOAD_SERVICE_ROOT_URL	: String = "http://hphantdev.com/imgdir/";
		public static const UPLOAD_SERVICE_NAME		: String = "upload.php";
		*/
		
		//"http://hphantdev.com/includes/handlers/upload_handler.php"
		public static const UPLOAD_SERVICE_ROOT_URL	: String = "/";
		public static const UPLOAD_SERVICE_NAME		: String = "upload";
		
		//public static const UPLOAD_STORAGE_URL		: String = Constants.CONTENT_STORAGE_URL_IMAGES;
		
	}
}