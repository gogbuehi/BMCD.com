package com.hphant.modsite.admin
{
	import com.hphant.components.AlertPallet;
	import com.hphant.contentlibrary.control.ContentClientController;
	import com.hphant.contentlibrary.control.ContentModelLocator;
	import com.hphant.data.control.DataClientController;
	import com.hphant.managers.JSServiceManager;
	import com.hphant.managers.LinkGeneratorManager;
	import com.hphant.managers.PalletManager;
	import com.hphant.modsite.IModsite;
	import com.hphant.modsite.admin.events.AdminControllEvent;
	import com.hphant.modsite.admin.events.AdminManagerEvent;
	import com.hphant.modsite.admin.events.TemplateHTMLEvent;
	import com.hphant.modsite.admin.model.HeadXML;
	import com.hphant.modsite.admin.model.ModuleContent;
	import com.hphant.modsite.admin.services.CalendarURLService;
	import com.hphant.modsite.admin.services.DataTableIDService;
	import com.hphant.modsite.admin.services.InventoryURLService;
	import com.hphant.modsite.admin.services.ModelInfoURLService;
	import com.hphant.modsite.admin.services.StoreURLService;
	import com.hphant.modsite.site.assets.containers.interfaces.ISiteBody;
	import com.hphant.modsite.site.events.SiteBodyDropEvent;
	import com.hphant.modsite.site.modules.ModuleClassInfo;
	import com.hphant.modsite.site.modules.interfaces.IModule;
	import com.hphant.modsite.site.modules.interfaces.IModuleLibrary;
	import com.hphant.modsite.system.events.URIRequesterEvent;
	import com.hphant.services.js.UserAccountService;
	import com.hphant.utils.Logger;
	import com.hphant.utils.XMLUtility;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.MouseEvent;
	import flash.filters.GlowFilter;
	import flash.geom.Point;
	import flash.utils.Dictionary;
	
	import mx.containers.Canvas;
	import mx.controls.Alert;
	import mx.core.Application;
	import mx.core.Container;
	import mx.core.UIComponent;
	import mx.events.CloseEvent;
	import mx.events.MoveEvent;
	import mx.events.ResizeEvent;
	import mx.modules.ModuleLoader;
	[Event(name="startAdmin",type="com.hphant.modsite.admin.events.AdminManagerEvent")]
	[Event(name="endAdmin",type="com.hphant.modsite.admin.events.AdminManagerEvent")]
	[Event(name="startPageEdit",type="com.hphant.modsite.admin.events.AdminManagerEvent")]
	[Event(name="endPageEdit",type="com.hphant.modsite.admin.events.AdminManagerEvent")]
	[Event(name="startModuleEdit",type="com.hphant.modsite.admin.events.AdminManagerEvent")]
	[Event(name="endModuleEdit",type="com.hphant.modsite.admin.events.AdminManagerEvent")]
	[Event(name="templatesLoaded",type="com.hphant.modsite.admin.events.AdminManagerEvent")]
	[Event(name="changeModuleType",type="com.hphant.modsite.admin.events.AdminManagerEvent")]
	public class AdminManager extends EventDispatcher implements IAdminManager
	{
		private static var _instance:AdminManager; 
		public function AdminManager()
		{
			super(this);
			if(_instance){
				throw new Error("Only one instance of AdminManager is allowed. use AdminManager.getInstance()");
			}
			TemplateHTML.getInstance().addEventListener(TemplateHTMLEvent.LOADED,this.templateLoad);
			TemplateHTML.getInstance().addEventListener(TemplateHTMLEvent.ERROR,this.templateLoadError);
			this._controlls.addEventListener(AdminControllEvent.PAGE_EDIT_CLICK,this.pageEditButtonClick);
			this._controlls.addEventListener(AdminControllEvent.LOGOUT,this.logoutButtonClick);
			this._controlls.addEventListener(AdminControllEvent.MODULE_EDIT_CLICK,this.moduleEditButtonClick);
			this._controlls.addEventListener(AdminControllEvent.MODULE_REMOVE_CLICK,this.moduleRemoveButtonClick);
			this._controlls.addEventListener(AdminControllEvent.ACCOUNT_CLICK,this.accountButtonClick);
			LinkGeneratorManager.getInstance().addGeneratorService(InventoryURLService);
			LinkGeneratorManager.getInstance().addGeneratorService(StoreURLService);
			LinkGeneratorManager.getInstance().addGeneratorService(ModelInfoURLService);
			LinkGeneratorManager.getInstance().addGeneratorService(CalendarURLService);
			JSServiceManager.getInstance().registerService("ChangePasswordService",UserAccountService.getInstance().successCallback,UserAccountService.getInstance().errorCallback);
			log("AdminManager Instance Created.");
		}
		
		public static function getInstance():AdminManager{
			if(!_instance){
				_instance = new AdminManager();
			}
			return _instance;
		}
		
		private var _contentLibraryLoader:ModuleLoader = new ModuleLoader();
		private var _loadedCnt:uint = 0;
		private var _errored:uint = 0;
		private var _templates:uint = 0;
		private var _applicationDisabledOverlayAlpha:Number = 0;
		private var _pageDisabledOverlayAlpha:Number = 0;
		private var _floorDisabledOverlayAlpha:Number = 0;
		private var services:Services = new Services();
		private var contentClient:ContentClientController = ContentClientController.getInstance();
		private var dataClient:DataClientController = DataClientController.getInstance();
		
		private var _controlls:AdminControlls = new AdminControlls();
		private var _current:UIComponent;
		private var _page:ISiteBody;
		private var _pageHolder:UIComponent;
		private var _moduleHolder:UIComponent;
		private var _controllsHolder:UIComponent
		public function set pageHolder(value:UIComponent):void{
			this._pageHolder = value;
		}
		public function get pageHolder():UIComponent{return this._pageHolder;}
		public function set moduleHolder(value:UIComponent):void{
			this._moduleHolder = value;
		}
		public function get moduleHolder():UIComponent{return this._moduleHolder;}
		public function set controllsHolder(value:UIComponent):void{
			PalletManager.getInstance().warehouse = Container(value);
			this._controllsHolder = value;
		}
		public function get controllsHolder():UIComponent{return this._controllsHolder;}
		public function set page(value:ISiteBody):void{
			if(this._page){
				this._page.removeEventListener(SiteBodyDropEvent.DROP_COMPLETE,this.handleSiteBodyDrop);
			}
			this._page = value;
			this._page.addEventListener(SiteBodyDropEvent.DROP_COMPLETE,this.handleSiteBodyDrop);
		}
		private var _site:UIComponent;
		[Bindable]
		public function set site(value:IModsite):void{
			if(_site){
				IModsite(_site).uriManager.removeEventListener(URIRequesterEvent.REQUEST_ERROR,this.uriRequestError);
			}
			this._site = UIComponent(value);
			if(_site){
				IModsite(_site).uriManager.addEventListener(URIRequesterEvent.REQUEST_ERROR,this.uriRequestError);
			}
		}
		public function get site():IModsite{
			return IModsite(this._site);
		}
		
		private function uriRequestError(event:URIRequesterEvent):void{
			AlertPallet.show(event.html,"Error",AlertPallet.OK,AlertPallet.OK);
		}
		private var _library:IModuleLibrary;
		public function set moduleLibrary(value:IModuleLibrary):void{
			
			this._loaded = (this._loaded) ? this._library == value :false;
			this._library = value;
			this.loadTemplates();
			this._controlls.moduleListData.source = value.classes; 
			this._controlls.moduleListData.refresh();
		}
		private var inPageEditMode:Boolean = false;
		private var _head:HeadXML = new HeadXML();
		private function pageEditButtonClick(event:AdminControllEvent):void{
			var alert:AlertPallet
			if(this.pageIsEditable()){
				if(this.inPageEditMode){
					alert = AlertPallet.show("Do you want to save the changes made to this page?",// text
					 "Save Page", // title
					 Alert.YES|Alert.NO, // Flags
					 Alert.YES, // defaultButtonFlag
					 this.pageSaveAlertHandler, // closeHandler
					 null // iconClass
					 );
				//PalletManager.centerAlert(alert);
					
				} else {
					componentToPopUp(UIComponent(this._page),(this._page.parent) ? UIComponent(this._page.parent) : UIComponent(this._page.owner));
					this.inPageEditMode = true;
					this._controlls.setEditPage();
					this._page.dragEnabled = true;
					this._page.setStyle('backgroundAlpha',.25);
					this._controlls.head = this._head;
					this._head.head = XML(site.getPage().head);
					this.dispatchEvent(new AdminManagerEvent(AdminManagerEvent.START_PAGE_EDIT));
				}
			} else {
				
				this.inPageEditMode = false;
				this._page.dragEnabled = false;
				this._page.setStyle('backgroundAlpha',0);
				this._controlls.setEditSite();
				this.dispatchEvent(new AdminManagerEvent(AdminManagerEvent.END_PAGE_EDIT));
				site.uriManager.goToURI(site.uriManager.current);
				alert = AlertPallet.show("This page can not be edited or saved.",// text
					 "Can't Edit Page", // title
					 Alert.OK, // Flags
					 Alert.OK) // defaultButtonFlag);
			}
		}
		private function logoutButtonClick(event:AdminControllEvent):void{
			if(this.inPageEditMode){
				var alert:AlertPallet = AlertPallet.show("Logging out now will discard any changes that you have made to this page.\nAre you sure you want to logout?",// text
				 "Logout", // title
				 Alert.YES|Alert.NO, // Flags
				 Alert.NO, // defaultButtonFlag
				 this.logoutAlertHandler, // closeHandler
				 null // iconClass
				 );
			//PalletManager.centerAlert(alert);
				
			} else {
				this.dispatchEvent(new AdminManagerEvent(AdminManagerEvent.END_ADMIN));
			}
			
			
		}
		
		private function logoutAlertHandler(event:CloseEvent):void{
			switch(event.detail){
				case Alert.YES:
					if(this.isModuleEditMode){
						removePopUp(this._current);
						this.isModuleEditMode = false;
						this._controlls.setEditPage();
						this.dispatchEvent(new AdminManagerEvent(AdminManagerEvent.END_MODULE_EDIT));
					}
					removePopUp(UIComponent(this._page));
					this.inPageEditMode = false;
					this.isModuleEditMode = false;
					this._page.dragEnabled = false;
					this._page.setStyle('backgroundAlpha',0);
					this._controlls.setEditSite();
					this.dispatchEvent(new AdminManagerEvent(AdminManagerEvent.END_PAGE_EDIT));
					
					finishLogout();
					
				break;
				default:
				break;
			}
		}
		private function finishLogout():void{
			this.dispatchEvent(new AdminManagerEvent(AdminManagerEvent.END_ADMIN));
			site.uriManager.goToURI(site.uriManager.current);
		}
		private function pageSaveAlertHandler(event:CloseEvent):void{
			removePopUp(UIComponent(this._page));
			this.inPageEditMode = false;
			this._page.dragEnabled = false;
			this._page.setStyle('backgroundAlpha',0);
			var newHTML:String = XMLUtility.formatEmptyNodes(XMLList(site.getPage()));
					this._controlls.setEditSite();
			this.dispatchEvent(new AdminManagerEvent(AdminManagerEvent.END_PAGE_EDIT));
			switch(event.detail){
				case Alert.YES:
					pageHasDynamicContent = false;
					for each(var mod:IModule in Container(this._page).getChildren()){
						var mc:ModuleContent = new ModuleContent();
						mc.xml = XML(mod.xml);
						if(mc.hasData)
							pageHasDynamicContent = true; 
					} 
					log(DataTableIDService.printIDs());
					log("Dynamic Data Page: "+this.pageHasDynamicContent);
					log("Saving Page: "+site.uriManager.current);
					site.uriManager.goToURI(site.uriManager.current,
											newHTML,
											ContentModelLocator.getInstance().sessionKey,
											this.pageHasDynamicContent);
				break;
				case Alert.NO:
				default:
					log("Reverting Page: "+site.uriManager.current);
					site.uriManager.goToURI(site.uriManager.current);
				break;
			}
			
			
		}
		private function pageIsEditable():Boolean{
			
			var nonEditableCount:uint = 0;
			pageHasDynamicContent = false;
			var mc:ModuleContent;
			DataTableIDService.reset();
			for each(var mod:IModule in Container(this._page).getChildren()){
				mc = new ModuleContent();
				try{
					var mci:ModuleClassInfo = this._library.getClassInfoByName(UIComponent(mod).className);
					if(!mci.useAdmin){
						return false;
					}
					if(TemplateHTML.getInstance().getTemplate(UIComponent(mod).className)){
						mc.xml = XML(TemplateHTML.getInstance().getTemplate(UIComponent(mod).className));
						
						if(mc.hasData){
							pageHasDynamicContent = true;
							/* AlertPallet.show("This page can not be edited with this admin at this time due to the use of dynamic data.",
											 "Can't Edit Page",
											 AlertPallet.OK,
											 AlertPallet.OK);
							return false; */ 
						}
						mc.xml = XML(mod.xml);
						for each(var tbl:XML in mc.data){
							DataTableIDService.addTable(tbl);
						}
						log(DataTableIDService.printIDs());
					} else {
						nonEditableCount++;
					}
				} catch(e:Error){
					nonEditableCount++;
				}
			} 
			if(Container(this._page).getChildren().length==0){
				mc = new ModuleContent();
				mc.xml = XML(TemplateHTML.getInstance().getTemplate("defaultContent"));
				
				var m:UIComponent = UIComponent(this._library.createInstanceOf(mc.moduleClassName));
				IModule(m).xml = XMLList(mc.xml);
				delete IModule(m).xml.@id;
				this.site.insertModule(IModule(m),0);
				return true;
			}/*  else if(nonEditableCount==Container(this._page).getChildren().length){
				AlertPallet.show("This page can not be edited.",
									 "Can't Edit Page",
									 AlertPallet.OK,
									 AlertPallet.OK);
									 
			} */
			return true;//nonEditableCount!=Container(this._page).getChildren().length;
			
		}
		public var pageHasDynamicContent:Boolean = false;
		private var isModuleEditMode:Boolean = false;
		public function moduleClick(event:MouseEvent):void{
			if(this.isModuleEditMode){
			} else {
				var mc:ModuleContent = new ModuleContent();
				mc.xml = XML(IModule(event.currentTarget).xml);
				var mcnew:ModuleContent = new ModuleContent();
				
				var mci:ModuleClassInfo = this._library.getClassInfoByName(mc.moduleClassName);
				try{
					mcnew.xml = XML(TemplateHTML.getInstance().getTemplate(mc.moduleClassName));
					mcnew.useContentFrom(mc);
					mcnew.imageSizes = mci.imageSizes;
					mcnew.videoSizes = mci.vidwoSizes;
					if(!mci.useAdmin || !TemplateHTML.getInstance().getTemplate(mc.moduleClassName)){
						AlertPallet.show("The module is not editable or removable.",
									 "Can't Edit Module",
									 AlertPallet.OK,
									 AlertPallet.OK);
					/* }else if(mcnew.hasData){// && !mcnew.hasImage && !mcnew.hasVideo){
						 AlertPallet.show("The module is a data module and must not be edited or removed.",
										 "Can't Edit Module",
										 AlertPallet.OK,
										 AlertPallet.OK); 
						//setDataModuleEditMode(UIComponent(event.currentTarget),mcnew); */
					}else { 
						setModuleEditMode(UIComponent(event.currentTarget),mcnew);
					 } 
				}catch(e:Error){
					AlertPallet.show("The module is not supported by this admin and must not be edited or removed.",
									 "Can't Edit Module",
									 AlertPallet.OK,
									 AlertPallet.OK);
				}
				
			}	
		}
		public function moduleRollOver(event:MouseEvent):void{
			UIComponent(event.currentTarget).filters = [new GlowFilter(0xFF0000)];
		}
		public function moduleRollOut(event:MouseEvent):void{
			UIComponent(event.currentTarget).filters = null;
		}
		
		private function templateLoad(event:TemplateHTMLEvent):void{
			this._loadedCnt++;
			log("Loaded Template for "+event.classname);
			if(this._loadedCnt+this._errored==this._templates){
				this.dispatchEvent(new AdminManagerEvent(AdminManagerEvent.TEMPLATES_LOADED));
			}
		}
		
		private function templateLoadError(event:TemplateHTMLEvent):void{
			this._errored++;
			log("Template Load Failed: "+event.classname);
			if(this._loadedCnt+this._errored==this._templates){
				this.dispatchEvent(new AdminManagerEvent(AdminManagerEvent.TEMPLATES_LOADED));
			}
		}
		private function moduleRemoveAlertEvent(event:CloseEvent):void{
			switch(event.detail){
				case Alert.YES:
					var old:UIComponent = this._current;
					moduleEditButtonClick();
					try{
						this._page.removeChild(old);
						this._controlls.moduleContent = null;
						this._controlls.module = null;
					} catch (e:Error){
						log("Module Delete Failed",2);
						log("Old module = "+old,2);
					}
				break;
				case Alert.NO:
				default:
					log("No module removed.");
				break;
			}
		}
		private function moduleRemoveButtonClick(event:AdminControllEvent):void{
			var alert:AlertPallet;
			var mci:ModuleClassInfo = this._library.getClassInfoByName(this._controlls.moduleContent.moduleClassName);
			if(!mci.useAdmin){
				alert = AlertPallet.show("The module is not editable or removable.",
									 "Can't Remove Module",
									 AlertPallet.OK,
									 AlertPallet.OK);
			} else if(!mci.icon){
				alert = AlertPallet.show("The module is not removable.",
									 "Can't Remove Module",
									 AlertPallet.OK,
									 AlertPallet.OK);
			} else if(Container(this._page).getChildren().length>1){
				alert = AlertPallet.show("Are you sure you want to delete this module?",// text
					 "Delete Module?", // title
					 Alert.YES|Alert.NO, // Flags
					 Alert.NO, // defaultButtonFlag
					 this.moduleRemoveAlertEvent, // closeHandler
					 null // iconClass
					 );
			} else {
				alert = AlertPallet.show("This is the last module on the page. You can't delete it but you can change it to another type of module.",// text
					 "Can't Delete Module!", // title
					 Alert.OK, // Flags
					 Alert.OK // defaultButtonFlag
					 );
			}
			
		}
		private function accountButtonClick(event:AdminControllEvent):void{
			UserAccountService.getInstance().update();
		}
		private function setModuleEditMode(mod:UIComponent,mc:ModuleContent):void{
			this._current = mod;
			componentToPopUp(mod,UIComponent(this._page));
			this.isModuleEditMode = true;
			this._page.dragEnabled = false;
			this._controlls.moduleContent = mc;
			this._controlls.module = IModule(mod);
					this._controlls.setEditModule();
			this.dispatchEvent(new AdminManagerEvent(AdminManagerEvent.START_MODULE_EDIT));
		}
		private function setDataModuleEditMode(mod:UIComponent,mc:ModuleContent):void{
			this._current = mod;
			componentToPopUp(mod,UIComponent(this._page));
			this.isModuleEditMode = true;
			this._page.dragEnabled = false;
			this._controlls.moduleContent = mc;
			this._controlls.module = IModule(mod);
					this._controlls.setEditData();
			this.dispatchEvent(new AdminManagerEvent(AdminManagerEvent.START_MODULE_EDIT));
		}
		
		private function moduleEditButtonClick(event:AdminControllEvent=null):void{
			if(this.isModuleEditMode){
				removePopUp(this._current);
				this.isModuleEditMode = false;
				this._page.dragEnabled = true;
				this._current = null; 
				this._controlls.moduleContent = null;
				this._controlls.module = null;
					this._controlls.setEditPage();
				this.dispatchEvent(new AdminManagerEvent(AdminManagerEvent.END_MODULE_EDIT));
			} else {
			}	
		}
		
		private function handleSiteBodyDrop(event:SiteBodyDropEvent):void{
			if(event.dropedObject is ModuleClassInfo){
				var mci:ModuleClassInfo = ModuleClassInfo(event.dropedObject);
				var m:UIComponent = UIComponent(this._library.createInstanceOf(mci.name));
				var newmc:ModuleContent = new ModuleContent();
				newmc.imageSizes = mci.imageSizes;
				newmc.videoSizes = mci.vidwoSizes;
				newmc.xml = XML(TemplateHTML.getInstance().getTemplate(mci.name));
				//m.currentState = State(m.states[m.st1ates.length-1]).name
				if(!TemplateHTML.getInstance().getTemplate(mci.name) || !mci.useAdmin){
					AlertPallet.show(mci.label+" is not supported at this time.",
										 "Can't Use Module Type",
										 AlertPallet.OK,
										 AlertPallet.OK);
				} else if(event.dropedOnItem){
					var mc:ModuleContent = new ModuleContent();
					mc.xml = XML(IModule(event.dropedOnItem).xml);
					var emci:ModuleClassInfo = this._library.getClassInfoByName(mc.moduleClassName);
					if(!emci.useAdmin){
						AlertPallet.show("The module is not editable or removable.",
										 "Can't Change Module",
										 AlertPallet.OK,
										 AlertPallet.OK);
					/* } else if(mc.hasData){// && !mcnew.hasImage && !mcnew.hasVideo){
						AlertPallet.show("The module is a data module and must not be changed to a new module type.",
										 "Can't Change Module",
										 AlertPallet.OK,
										 AlertPallet.OK); */
					} else if(!emci.icon){
						AlertPallet.show("The module can not be changed to another type.",
										 "Can't Change Module",
										 AlertPallet.OK,
										 AlertPallet.OK);
					}else {
						modSwitchInfo = {oldMod:event.dropedOnItem,newMod:m,oldContent:mc,newContent:newmc};
						var verifyAlert:AlertPallet = AlertPallet.show("Are you sure you want to change the existing '"+emci.label+"' module into a new '"+mci.label+"' module?",
										 "Verify module type change",
										 AlertPallet.YES|AlertPallet.NO,
										 AlertPallet.NO,
										 moduleChnageVerifiedHandler);
						
					}
					//this._page.removeChild(event.dropedOnItem);
				} else {
					this.site.insertModule(IModule(m),event.targetIndex);
					IModule(m).xml = XMLList(newmc.xml);
					IModule(m).addEventListener(MouseEvent.ROLL_OVER,moduleRollOver);
					IModule(m).addEventListener(MouseEvent.ROLL_OUT,moduleRollOut);
					IModule(m).addEventListener(MouseEvent.CLICK,moduleClick);
					//setModuleEditMode(UIComponent(m),newmc);
				}
			}
		}
		private var modSwitchInfo:Object;
		private function moduleChnageVerifiedHandler(event:CloseEvent):void{
			switch(event.detail){
				case AlertPallet.YES:
					if(modSwitchInfo){
						var mods:Object = modSwitchInfo;
						
						log(mods);
						log(mods.newMod);
						log(mods.oldMod);
						log(mods.newContent);
						log(mods.oldContent);
						
						this.site.replaceModule(IModule(mods.newMod),IModule(mods.oldMod));
						mods.newContent.useContentFrom(mods.oldContent);
						IModule(mods.newMod).xml = XMLList(mods.newContent.xml);
						IModule(mods.oldMod).removeEventListener(MouseEvent.ROLL_OVER,moduleRollOver);
						IModule(mods.oldMod).removeEventListener(MouseEvent.ROLL_OUT,moduleRollOut);
						IModule(mods.oldMod).removeEventListener(MouseEvent.CLICK,moduleClick);
						IModule(mods.newMod).addEventListener(MouseEvent.ROLL_OVER,moduleRollOver);
						IModule(mods.newMod).addEventListener(MouseEvent.ROLL_OUT,moduleRollOut);
						IModule(mods.newMod).addEventListener(MouseEvent.CLICK,moduleClick);
					}
				break;
				default:
				
				break;
			}
			modSwitchInfo = null;
		}
		
		private var _started:Boolean = false;
		private var _loaded:Boolean = false;
		public function start():void{
			/// Show Edit Button for page.s
			PalletManager.openPallet(this._controlls);
			this.inPageEditMode = false;
			this.isModuleEditMode = false;
			this._started = true;
			this.loadTemplates();
			this._controlls.setEditSite();
			this.dispatchEvent(new AdminManagerEvent(AdminManagerEvent.START_ADMIN));
		}
		private function loadTemplates():void{
			if(!this._loaded && this._started){
				var clss:Array = this._library ? this._library.classes : [];
				this._templates = clss.length;
				log("Loading default content template.");
				TemplateHTML.getInstance().loadTemplate("defaultContent");
				for each (var m:Object in clss){
					log("Loading template for "+m.name);
					TemplateHTML.getInstance().loadTemplate(m.name);
					this._loaded = true;
				}
			}
		}
		private var _popups:Dictionary = new Dictionary();
		private function componentToPopUp(component:UIComponent,parent:UIComponent):void{
			var placeholder:Canvas = this.createPlaceHolder(component);
			var point:Point = new Point(component.x,component.y);
			var oldAlpha:Number = UIComponent(parent).getStyle('disabledOverlayAlpha');
			var dsDistance:Number = UIComponent(component).getStyle('shadowDistance');
			var corner:Number = UIComponent(component).getStyle('cornerRadius');
			var bThickness:Number = UIComponent(component).getStyle('borderThickness');
			var dsDirection:String = UIComponent(component).getStyle('shadowDirection');
    		var useDS:Boolean = UIComponent(component).getStyle('dropShadowEnabled');
    		var border:String = UIComponent(component).getStyle('borderStyle');
			point = UIComponent(component).localToGlobal(point);
			UIComponent(parent).setStyle('disabledOverlayAlpha',.5);
			UIComponent(component).setStyle('shadowDistance',5);
			UIComponent(component).setStyle('cornerRadius',15);
			UIComponent(component).setStyle('shadowDistance',5);
			UIComponent(component).setStyle('shadowDirection',"right");
			UIComponent(component).setStyle('borderStyle',"solid");
			UIComponent(component).setStyle('dropShadowEnabled',true);
			UIComponent(parent).enabled = false;
			component.parent.addChildAt(placeholder,component.parent.getChildIndex(component));
			component.parent.removeChild(component);
			UIComponent(placeholder.parent).validateNow();
			this._popups[component] = {component:component,
									   parent:parent,
									   bThickness:bThickness,
									   corner:corner,border:border,
									   oldAlpha:oldAlpha,dsDirection:dsDirection,
									   dsDistancd:dsDistance,
									   useDS:useDS,
									   placeholder:placeholder,
									   layer:(this._page==component) ? this.pageHolder : this.moduleHolder};
			_placeholders[placeholder] = component;
			component.addEventListener(ResizeEvent.RESIZE,this.updatePlaceholder);
			component.addEventListener(Event.RENDER,this.repositionPopUpEvent);
			placeholder.addEventListener(MoveEvent.MOVE,this.repositionPopUpMoveEvent);
			placeholder.addEventListener(Event.ADDED_TO_STAGE,this.repositionPopUpMoveEvent);
			UIComponent(Application.application).validateNow();
		 	UIComponent(this._popups[component].layer).addChild(component);
			//PopUpManager.addPopUp(component,(component==this._page) ? this.pageHolder : this.moduleHolder,(component!=this._page));
			repositionPopUp(placeholder);
		}
		private function removePopUp(component:UIComponent):void{
			
			var pObject:Object = this._popups[component];
			this._popups[component] = null;
			var placeholder:Canvas = Canvas(this._placeholders[component]);
			this._placeholders[component] = null;
			UIComponent(pObject.parent).setStyle('disabledOverlayAlpha',pObject.oldAlpha);
			UIComponent(component).setStyle('cornerRadius',pObject.corner);
			UIComponent(component).setStyle('borderThickness',pObject.bThickness);
			UIComponent(component).setStyle('shadowDistance',pObject.dsDistancd);
			UIComponent(component).setStyle('shadowDirection',pObject.dsDirection);
			UIComponent(component).setStyle('dropShadowEnabled',pObject.useDS);
			UIComponent(component).setStyle('borderStyle',pObject.border);
			UIComponent(pObject.parent).enabled = true;
			try{
				UIComponent(pObject.layer).removeChild(component);
			} catch(e:Error){
				log(e,1);
			}
			//PopUpManager.removePopUp(component);
			component.removeEventListener(Event.RENDER,this.repositionPopUpEvent);
			component.removeEventListener(ResizeEvent.RESIZE,this.updatePlaceholder);
			component.x = placeholder.x;
			component.y = placeholder.y;
			try{
				placeholder.parent.addChildAt(component,placeholder.parent.getChildIndex(placeholder));
				placeholder.parent.removeChild(placeholder);
			} catch(e:Error){
				log(e,1);
			}
		}
		private var _placeholders:Dictionary = new Dictionary();
		private function createPlaceHolder(component:UIComponent):Canvas{
			var placeholder:Canvas;
			if(!_placeholders[component]){
				placeholder = new Canvas();
				_placeholders[component] = placeholder;
			} else {
				placeholder = _placeholders[component];
			}
			placeholder.setStyle('backgroundAlpha',0);
			placeholder.setStyle('borderThickness',0);
			placeholder.width = component.width;
			placeholder.height = component.height;
			placeholder.x = component.x;
			placeholder.y = component.y;
			return placeholder;
		}
		private function updatePlaceholder(event:ResizeEvent):void{
			this._popups[event.currentTarget].placeholder.width = event.currentTarget.width;
			this._popups[event.currentTarget].placeholder.height = event.currentTarget.height;
		}
		private function repositionPopUpEvent(event:Event):void{
			repositionPopUp(Canvas(_placeholders[event.currentTarget]));
		}
		
		private function repositionPopUpMoveEvent(event:Event):void{
			repositionPopUp(Canvas(event.currentTarget));
		}
		private function repositionPopUp(placeholder:Canvas):void{
			var c:UIComponent = UIComponent(_placeholders[placeholder]);
			var p:Point = new Point(placeholder.x,placeholder.y);
			var cp:Point = UIComponent(placeholder.parent).contentToGlobal(p);
			if(c==this._page){
				cp = this.pageHolder.globalToContent(cp);
			} else {
				cp = this.moduleHolder.globalToContent(cp);
			}
			c.x = cp.x;
			c.y = cp.y;
		}
		protected function log(message:Object,level:uint=0):void{
			Logger.log("[AdminManager] "+message,level);
		}
	}
}