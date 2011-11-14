package com.hphant.modsite.admin.util
{
	import com.hphant.contentlibrary.control.ContentModelLocator;
	import com.hphant.contentlibrary.control.event.CropEvent;
	import com.hphant.contentlibrary.model.Crop;
	import com.hphant.modsite.admin.model.ImageXML;
	
	
	public class CropConverter
	{
		public function CropConverter()
		{ throw new Error("CropConverter is a utillity class and is not to be instantiated.");
		}
		public static function toImageXML(crop:Crop):ImageXML{
			var imageXML:ImageXML = new ImageXML();
			imageXML.text = crop.shortDescription;
			imageXML.alternat = crop.alternate;
			imageXML.title = crop.title;
			imageXML.source = crop.cropLocation;
			return imageXML;
		}
		public static function toImageListXMLItem(crop:Crop):ImageXML{
			var imageXML:ImageXML = new ImageXML();
			imageXML.text = crop.shortDescription;
			imageXML.alternat = crop.alternate;
			imageXML.title = crop.title;
			imageXML.link = crop.cropLocation;
			var updatedCrops:Boolean = false;
			try{
			imageXML.source = ContentModelLocator.getInstance().getMasterOfCrop(crop).thumbnailLocation;
			} catch (e:Error){
				var ce:CropEvent = new CropEvent(CropEvent.REMOVE_CROP);
				ce.data = crop;
				ce.dispatch();
			}
			return imageXML;
		}
		public static function toImageXMLList(crops:Object):Array{
			var imageXMLs:Array= new Array();
			for each(var crop:Crop in crops){
				imageXMLs.push(toImageXML(crop));
			}
			return imageXMLs;
		}
		public static function toImageListXMLItemList(crops:Object):Array{
			var imageXMLs:Array = new Array();
			for each(var crop:Crop in crops){
				imageXMLs.push(toImageListXMLItem(crop));
			}
			return imageXMLs;
		}
	}
}