package com.hphant.modsite.site.modules
{
	import com.hphant.modsite.data.SuplimentalDataBase;
	import com.hphant.modsite.site.modules.interfaces.IModule;
	import com.hphant.modsite.site.modules.interfaces.IModuleLibrary;
	import com.hphant.modsite.system.interfaces.ICSSLoader;
	import com.hphant.modsite.system.interfaces.IURIManager;
	import com.hphant.utils.Logger;
	
	import flash.geom.Rectangle;
	
	public class ModuleLibrary extends Object implements IModuleLibrary
	{
		
		public function get versionMajor():uint{return 0;}
		public function get versionMinor():uint{return 2;}
		public function get versionRevision():uint{return 0;}
		
		private var _instances:Object;
		private var _uri_manager:IURIManager;
		private var _css:ICSSLoader;
		[ArrayElementType("com.hphant.modsite.site.modules.ModuleClassInfo")]
		private var _classes:Array = 
		 [ new ModuleClassInfo("ModCanvas",					
		 					   "Empty",							
		 					   "An empty module"),
		   new ModuleClassInfo("ModArticle",				
		 					   "Article",							
		 					   "A text module",
		 					   true,
		 					   ModuleIcons.text),
		   new ModuleClassInfo("ModArticleTextRight",		
		 					   "Article Image Left",				
		 					   "A text module with an image on the left",
		 					   true,
		 					   ModuleIcons.textImageLeft,
		 					   [new Rectangle(0,0,460,380)]),
		   new ModuleClassInfo("ModArticleTRNoBreaks",		
		 					   "Article Image Left, no breaks",	
		 					   "A text module with an image on the left that the has no space between lines",
		 					   true,
		 					   null,
		 					   [new Rectangle(0,0,460,380)]),
		   new ModuleClassInfo("ModArticleTextLeft",		
		 					   "Article Image Right",				
		 					   "A text module with an image on the right",
		 					   true,
		 					   ModuleIcons.textImageRight,
		 					   [new Rectangle(0,0,460,380)]),
		   new ModuleClassInfo("ModPersonnelImageLeft",		
		 					   "Personnel Image Left",				
		 					   "A personnel info module with an image on the left",
		 					   true,
		 					   ModuleIcons.personImageLeft,
		 					   [new Rectangle(0,0,460,380)]),
		   new ModuleClassInfo("ModPersonnelImageRight",		
		 					   "Personnel Image Right",				
		 					   "A personnel info module with an image on the right",
		 					   true,
		 					   ModuleIcons.personImageRight,
		 					   [new Rectangle(0,0,460,380)]),
		   new ModuleClassInfo("ModPhotoVideoHighlights",	
		 					   "Highlights",						
		 					   "A module to highlight information with an image and multiple videos.",
		 					   true,
		 					   ModuleIcons.showcase,
		 					   [new Rectangle(0,0,460,380)],
		 					   [new Rectangle(0,0,470,280),new Rectangle(0,0,420,280)]),
		   new ModuleClassInfo("ModMultiImageH",			
		 					   "Item Selection",					
		 					   "A module to display multiple items.",
		 					   true,// Temporaraly dissabled the use f the admin  for this module
		 					   null,//ModuleIcons.featuredItems,
		 					   [new Rectangle(0,0,180,135)]),
		   new ModuleClassInfo("ModImageShowcase",			
		 					   "Image Show",						
		 					   "An image module with an image selector and a text area on the right.",
		 					   true,
		 					   ModuleIcons.imagePlayer,
		 					   [new Rectangle(0,0,640,480)]),
		   new ModuleClassInfo("ModVideoShowcase",			
		 					   "Video Show",						
		 					   "A video module with a video selector and a text area on the right.",
		 					   true,
		 					   ModuleIcons.videoPlayer,
		 					   null,
		 					   [new Rectangle(0,0,460,380)]),
		   new ModuleClassInfo("ModInventory",				
		 					   "Inventory",						
		 					   "An inventory module.",
		 					   false,
		 					   null,
		 					   [new Rectangle(0,0,200,150),new Rectangle(0,0,640,480)]),
		   new ModuleClassInfo("ModEventsCalendar",			
		 					   "Events Calendar",					
		 					   "A calendar module.",
		 					   false,
		 					   null,
		 					   [new Rectangle(0,0,200,150),new Rectangle(0,0,640,480)]),
		   new ModuleClassInfo("ModStore",					
		 					   "Store",							
		 					   "A store module.",
		 					   false,
		 					   null,
		 					   [new Rectangle(0,0,200,150),new Rectangle(0,0,640,480)]),
		   new ModuleClassInfo("ModForm",					
		 					   "Form",								
		 					   "A module for displaying a form.",
		 					   true),
		   new ModuleClassInfo("ModModelInfo",				
		 					   "Model Info",						
		 					   "A module for displaying new model information.",
		 					   false,
		 					   null,
		 					   [new Rectangle(0,0,420,280)],
		 					   [new Rectangle(0,0,420,280)]),
		   new ModuleClassInfo("ModBMCD901Header",			
		 					   "901 Header",
		 					   "",
		 					   false),
		   new ModuleClassInfo("ModBMCD999Header",			
		 					   "999 Header",
		 					   "",
		 					   false),
		   new ModuleClassInfo("ModBMCD999Footer",			
		 					   "999 Header",
		 					   "",
		 					   false),
		   new ModuleClassInfo("ModBMCD901Footer",			
		 					   "901 Footer",
		 					   "",
		 					   false)];
		 					   
		 					   
		 					   
		public function ModuleLibrary()
		{
			super();
			this._instances = new Object();
			log("Library supports thes Modules:");
			for each(var i:String in this._classes){
				log("\t"+i);
				this._instances[i] = new Array();
				_createNewInstance(i);
			}
		}
		private function log(message:Object,level:int=0):void{
			Logger.log("[ModuleLibrary] "+message,level);
		}
		public function get uriManager():IURIManager{
			
			return this._uri_manager;
		}
		public function set uriManager(value:IURIManager):void{
			this._uri_manager = value;
			for each (var cls:Array in this._instances){
				for each (var mod:IModule in cls){
					mod.uriManager = value;
				}
			}
		}
		public function set css(cssLoader:ICSSLoader):void{
			this._css = cssLoader;
		} 
		[ArrayElementType("com.hphant.modsite.site.modules.ModuleClassInfo")]
		public function get classes():Array{
			return this._classes.filter(moduleClassFilter);
		}
		public function getClassInfoByName(className:String):ModuleClassInfo{
			for each (var m:ModuleClassInfo in this._classes){
				if(m.name==className){
					return m;
				}
			}
			return null;
		}
		private function moduleClassFilter(item:ModuleClassInfo,index:int,array:Array):Boolean{
			return true;
		}
		public function getModuleInstancesOf(classname:String):Array{
			if(doesClassExist(classname)){
				return this._instances[classname] as Array;
			} else {
				return this._instances["ModCanvas"] as Array;
			}
		}
		private function doesClassExist(name:String):Boolean{
			for each(var mo:ModuleClassInfo in this._classes){
				if(mo.name==name){
					return true;
				}
			}
			return false;
		}
		private function _createNewInstance(classname:String):IModule{
			var instance:IModule;
			log("Checking Library for Module : "+classname);
			switch(classname){
				case "ModArticleTRNoBreaks":
					instance = new ModArticleTRNoBreaks();
					log("Created Instance of "+classname);
				break;
				case "ModForm":
					instance = new ModForm();
					log("Created Instance of "+classname);
				break;
				case "ModStore":
					instance = new ModStore();
					log("Created Instance of "+classname);
				break;
				case "ModArticle":
					instance = new ModArticle();
					log("Created Instance of "+classname);
				break;
				case "ModArticleTextRight":
					instance = new ModArticleTextRight();
					log("Created Instance of "+classname);
				break;
				case "ModArticleTextLeft":
					instance = new ModArticleTextLeft();
					log("Created Instance of "+classname);
				break;
				case "ModPersonnelImageLeft":
					instance = new ModPersonnelImageLeft();
					log("Created Instance of "+classname);
				break;
				case "ModPersonnelImageRight":
					instance = new ModPersonnelImageRight();
					log("Created Instance of "+classname);
				break;
				case "ModModelInfo":
					instance = new ModModelInfo();
					log("Created Instance of "+classname);
				break;
				case "ModMultiImageH":
					instance = new ModMultiImageH();
					log("Created Instance of "+classname);
				break;
				case "ModImageShowcase":
					instance = new ModImageShowcase();
					log("Created Instance of "+classname);
				break;
				case "ModVideoShowcase":
					instance = new ModVideoShowcase();
					log("Created Instance of "+classname);
				break;
				case "ModInventory":
					instance = new ModInventory();
					log("Created Instance of "+classname);
				break;
				case "ModBMCD901Header":
					instance = new ModBMCD901Header();
					log("Created Instance of "+classname);
				break;
				case "ModBMCD999Header":
					instance = new ModBMCD999Header();
					log("Created Instance of "+classname);
				break;
				case "ModEventsCalendar":
					instance = new ModEventsCalendar();
					log("Created Instance of "+classname);
				break;
				case "ModPhotoVideoHighlights":
					instance = new ModPhotoVideoHighlights();
					log("Created Instance of "+classname);
				break;
				case "ModBMCD901Footer":
				case "ModBMCD999Footer":
				case "ModBMCDFooter":
					instance = new ModBMCD901Footer();
					log("Created Instance of ModBMCD901Footer");
				break;
				default:
					instance = new ModCanvas();
					log("Created Instance of ModCanvas");
				break;
			}
			instance.uriManager = this._uri_manager;
			this._instances[classname].push(instance);
			return instance;
		}
		public function createInstanceOf(classname:String):IModule{
			var classexists:Boolean = (this._classes.indexOf(classname)>=0);
			var insts:Array = getModuleInstancesOf(classname);
			var instance:IModule;
			for each (instance in insts){
				if(!instance.xml){
					return instance;
				}
			}
			if(doesClassExist(classname)){
				return _createNewInstance(classname);
			} else {
				log("Module is not part of this library : "+classname);
				instance = new ModCanvas();
				log("Created Instance of ModCanvas");
				instance.uriManager = this._uri_manager;
				this._instances["ModCanvas"].push(instance);
				return instance;
			}
		}
		public function getSupplementalData(id:String):String{
			return SuplimentalDataBase.getSuplimentalData(id);
		}
		public function setSupplementalData(id:String,data:String):void{
			for each (var cls:Array in this._instances){
				for each (var mod:IModule in cls){
					if(mod.modId==id){
						mod.suplimental = XMLList(data);
					}
				}
			}
			SuplimentalDataBase.setSuplimentalData(id,data);
		}
	}
}