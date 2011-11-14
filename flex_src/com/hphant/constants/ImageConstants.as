package com.hphant.constants
{
	import flash.geom.Rectangle;
	
	public class ImageConstants
	{
		public static const MASTER_WIDTH	: int = 570;
		public static const MASTER_HEIGHT	: int = 500;
		public static const THUMB_WIDTH		: int = 93;
		public static const THUMB_HEIGHT	: int = 70;
		[ArrayElementType("flash.geom.Rectangle")]
		public static const CROP_SIZES		: Array = [ new Rectangle(0,0,640,	480),
														new Rectangle(0,0,470,	280),
														new Rectangle(0,0,460,	380),
														new Rectangle(0,0,460,	350),
														new Rectangle(0,0,420,	280),
														new Rectangle(0,0,200,	150),
														new Rectangle(0,0,180,	135),
														new Rectangle(0,0,93,	70)]
		//according to DB structure described at: http://docs.google.com/Doc?id=djfhmk9_4gbfcdfd9
		public static const MASTER_IMAGE_DESCRIPTION_MAX_LENGHT	: int = 200;
		
		/*
		public static const CONTENT_STORAGE_URL_IMAGES	: String = "http://content.hphantdev.com/images/";//"http://hphantdev.com/imgdir/";
		//	TODO
		public static const CONTENT_STORAGE_URL_VIDEOS	: String = "";
		*/

		
		public static const EDIT_MODE_CUSTOM_CROP	: String = "edit_mode_custom_crop";
		public static const EDIT_MODE_THUMB			: String = "edit_mode_thumb";
		public static const EDIT_MODE_CROP			: String = "edit_mode_crop";
		
	}
}