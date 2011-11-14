package com.hphant.managers
{
	import com.hphant.components.AlertPallet;
	import com.hphant.components.CellEditorPallet;
	import com.hphant.components.containers.Pallet;
	import com.hphant.components.events.AlertCloseEvent;
	import com.hphant.components.events.PalletEvent;
	import com.hphant.events.PalletManagerEvent;
	import com.hphant.utils.Logger;
	
	import flash.events.Event;
	import flash.events.EventDispatcher;
	
	import mx.core.Application;
	import mx.core.Container;
	import mx.core.UIComponent;
	[Event(name="close",type="com.hphant.events.PalletManagerEvent")]
	[Event(name="startDrag",type="com.hphant.events.PalletManagerEvent")]
	[Event(name="stopDrag",type="com.hphant.events.PalletManagerEvent")]
	public class PalletManager extends EventDispatcher
	{
		public function PalletManager()
		{	
			super(this);
			if(_instance){
				throw new Error("Onle one instance of PalletManager is allowed. Use PalletManager.getInstance()");
			}
		} 
		private static var _instance:PalletManager;
		private static var _focusPallet:Pallet;
		public static function getInstance():PalletManager{
			if(!_instance){
				_instance = new PalletManager();
			}
			return _instance;
		}
		public static function openPallet(pallet:Pallet):void{
			try{
				
				if(pallet is AlertPallet && !(pallet is CellEditorPallet)){
					PalletManager.getInstance().disableAllButAlert();
				}
				pallet.enabled = true;
				if(!PalletManager.getInstance().warehouse.contains(pallet)){
					
					PalletManager.getInstance().warehouse.addChild(pallet);
					PalletManager.setFocusePallet(pallet);
					pallet.addEventListener(PalletEvent.CLOSE,palletClosedListener);
					pallet.addEventListener(AlertCloseEvent.ALERT_CLOSE,palletClosedListener);
					pallet.addEventListener(PalletEvent.START_DRAG,palletStartDragListener);
					pallet.addEventListener(PalletEvent.STOP_DRAG,palletStopDragListener);
					pallet.addEventListener(PalletEvent.PALLET_CLICK,palletClicked);
				}
			} catch (e:Error){
				Logger.log("[PalletManager](static) "+e,2);
			}
		}
		public static function closePallet(pallet:Pallet):void{
			try{
				if(pallet is AlertPallet && !(pallet is CellEditorPallet)){
					PalletManager.getInstance().enableAll();
				}
				if(PalletManager.getInstance().warehouse.contains(pallet)){
					var prev:Pallet = prevPallet(pallet);
					if(prev && (pallet is CellEditorPallet)){
						prev.enabled = true;	
					}					
					PalletManager.getInstance().warehouse.removeChild(pallet);
					PalletManager.setFocusePallet(Pallet(PalletManager.getInstance().warehouse.getChildren()[PalletManager.getInstance().warehouse.numChildren-1]));
					PalletManager.getInstance().dispatchEvent(new PalletManagerEvent(PalletManagerEvent.CLOSE,pallet));
					pallet.removeEventListener(PalletEvent.CLOSE,palletClosedListener);
					pallet.removeEventListener(PalletEvent.START_DRAG,palletStartDragListener);
					pallet.removeEventListener(PalletEvent.STOP_DRAG,palletStopDragListener);
					pallet.removeEventListener(PalletEvent.PALLET_CLICK,palletClicked);
					pallet.reset();
				}
			} catch (e:Error){
				Logger.log("[PalletManager](static) "+e,2); 
			}
		}
		
		private var _defaultWarehouseBackground:uint = 0xFFFFFF;
		private var _defaultWarehouseBackgroundAlpha:Number = 0;
		
		private function disableAllButAlert():void{
			for each(var uic:UIComponent in _warehouse.getChildren()){
				if(uic is Pallet){
					if(uic is AlertPallet){
						
					} else {
						uic.enabled = false;
					}
				}
			}
			
			 this._warehouse.setStyle('backgroundColor',0xFFFFFF);
			this._warehouse.setStyle('backgroundAlpha',.5);
		}
		private function enableAll():void{
			for each(var uic:UIComponent in _warehouse.getChildren()){
				if(uic is Pallet){
					uic.enabled = true;
				}
			}
			 this._warehouse.setStyle('backgroundColor',undefined);
			this._warehouse.setStyle('backgroundAlpha',0); 
		}
		
		private var _warehouse:Container;
		[Bindable]
		public function get warehouse():Container{
			return (this._warehouse) ? this._warehouse : Application.application as Container;
		}
		public function set warehouse(value:Container):void{
			for each(var uic:UIComponent in this.warehouse.getChildren()){
				if(uic is Pallet){
					this.warehouse.removeChild(uic);
					value.addChild(uic);
				}
			}
			this._defaultWarehouseBackground = value.getStyle('backgroundColor');
			this._defaultWarehouseBackgroundAlpha = value.getStyle('backgroundAlpha');
			this._warehouse = value;
			
		}
		
		private static function palletClicked(event:PalletEvent):void{
			try{
				setFocusePallet(Pallet(event.currentTarget));
			} catch (e:Error){
				Logger.log("[PalletManager](static) "+e,2);
			}
		}
		private static function nextPallet(pallet:Pallet):Pallet{
			var next:Pallet;
			try{
				next = Pallet(PalletManager.getInstance().warehouse.contains(pallet) ? PalletManager.getInstance().warehouse.getChildAt(PalletManager.getInstance().warehouse.getChildIndex(pallet)+1) : null);
			} catch (e:Error){}
			return next;
		}
		private static function prevPallet(pallet:Pallet):Pallet{
			var prev:Pallet;
			try{
				prev = Pallet(PalletManager.getInstance().warehouse.contains(pallet) ? PalletManager.getInstance().warehouse.getChildAt(PalletManager.getInstance().warehouse.getChildIndex(pallet)-1) : null);
			} catch (e:Error){}
			return prev;
		}
		private static function setFocusePallet(pallet:Pallet):void{
			var prev:Pallet = prevPallet(pallet);
			var next:Pallet = nextPallet(pallet);
			
			if(prev && pallet is CellEditorPallet){
				PalletManager._focusPallet = pallet;
				prev.enabled = false;
				PalletManager.getInstance().warehouse.setChildIndex(pallet,PalletManager.getInstance().warehouse.numChildren-1);
				PalletManager.getInstance().warehouse.setChildIndex(prev,PalletManager.getInstance().warehouse.numChildren-2);
			} else if(next is CellEditorPallet){
				PalletManager._focusPallet = next;
				pallet.enabled = false;
				PalletManager.getInstance().warehouse.setChildIndex(next,PalletManager.getInstance().warehouse.numChildren-1);
				PalletManager.getInstance().warehouse.setChildIndex(pallet,PalletManager.getInstance().warehouse.numChildren-2);
			} else {
				PalletManager.getInstance().warehouse.setChildIndex(pallet,PalletManager.getInstance().warehouse.numChildren-1);
				PalletManager._focusPallet = pallet;
			}
		}
		private static function palletClosedListener(event:Event):void{
			//if(event is PalletEvent){
				Logger.log("[PalletManager](static) "+event); 
				closePallet(Pallet(event.currentTarget));
			//}
		}
		
		private static function palletStartDragListener(event:PalletEvent):void{
			PalletManager.setFocusePallet(Pallet(event.currentTarget));
			PalletManager.getInstance().dispatchEvent(new PalletManagerEvent(PalletManagerEvent.START_DRAG,Pallet(event.currentTarget)));
		}
		
		protected static function palletStopDragListener(event:PalletEvent):void{
			PalletManager.getInstance().dispatchEvent(new PalletManagerEvent(PalletManagerEvent.STOP_DRAG,Pallet(event.currentTarget)));
			
		}
		
		public static function centerPallet(pallet:Pallet):void{
			pallet.x = PalletManager.getInstance().warehouse.width/2 - pallet.width/2;
			pallet.y = PalletManager.getInstance().warehouse.height/2 - pallet.height/2;
		}
	}
}