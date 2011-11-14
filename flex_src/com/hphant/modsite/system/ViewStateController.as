package com.hphant.modsite.system
{
	import com.hphant.modsite.system.events.ViewStateChangeEvent;
	import com.hphant.utils.Logger;
	
	import flash.events.EventDispatcher;
	
	import mx.core.IUIComponent;
	import mx.core.UIComponent;

	public class ViewStateController extends EventDispatcher
	{
		private var modules:Object = new Object();
		private var _moduleCount:uint = 0;
		public function clear():void{
			this.modules = new Object();
			this._moduleCount = 0;
			this.atStateCount = 0;
			this.completeCount = 0;
			this.count = 0;
		}
		public function get moduleCount():uint{
			return this._moduleCount;
		}
		public function set moduleCount(value:uint):void{
			log(this+" Changing moduleCount from "+this._moduleCount+" to "+value);
			this._moduleCount = value;
		}
		private var atStateCount:uint=0;
		private var completeCount:uint=0;
		private var count:uint = 0;
		private static var instanceCount:uint=0;
		private var instanceNumber:uint;
		private var logging:Boolean = true;
		[Inspectable]
		public var reverse:Boolean = false;
		public function ViewStateController()
		{
			super(this);
			instanceCount++;
			this.instanceNumber = instanceCount;
				log(this+" Created.");
		}
		public function addItem(module:IUIComponent):void{
				log(this+" Adding "+module+" for "+((this.reverse) ? "break down." : "build out.")+" : "+this.moduleCount);
			if(this.modules[module.name]!==module){
				this.moduleCount++;
				module.addEventListener(ViewStateChangeEvent.STATE_REACHED,this.reportStateReached);
				module.addEventListener(ViewStateChangeEvent.CHANGE_COMPLETE,this.reportChangeComplete);
				var mod:Object = {inTransition:false,mod:module,comp:false,start:Number(String(UIComponent(module).currentState).replace('state',"")),count:0}
				modules[module.name]=mod;
				log(this+" Item added for "+((this.reverse) ? "break down." : "build out.")+" : "+mod.start+" : "+module+" : "+this.moduleCount);
			}
		}
		private function reportChangeComplete(event:ViewStateChangeEvent):void{
			if(this.moduleCount>0){
				this.moduleCount--;
				var module:UIComponent = UIComponent(event.currentTarget);
				var mod:Object = this.getModData(module);
				mod.inTransition = false;
				if(mod){
				mod.comp=true;
				var info:String = ((this.reverse) ? "break down state"+(mod.start-mod.count) : "build out state"+(mod.start+mod.count))+". : "+module.currentState;
				log(this+" Item completed "+info+" : "+this.moduleCount+" items remain. : "+module);
				}
				this.removeItem(UIComponent(module));
				if(allModsComplete()){
					log(this+" All Items completed : "+module);
					this.count = 0;
					this.completeCount = 0;
					this.moduleCount = 0;
					this.modules = new Object();
					this.dispatchEvent(new ViewStateChangeEvent(ViewStateChangeEvent.CHANGE_COMPLETE,this.count));
				}else if(allModsAtState()){
					log(this+" Calling start() from ChangeConmplete listener : "+event.currentTarget);
					this.start();
				}
			} else {
				log(this+" Module "+event.target+" fired a late ChangeComplete Event.");
			}
		}
		private function reportStateReached(event:ViewStateChangeEvent):void{
			this.atStateCount++;
			var module:UIComponent = UIComponent(event.currentTarget);
			var mod:Object = this.getModData(module);
			mod.inTransition = false;
			var info:String = ((this.reverse) ? "break down state"+(mod.start-mod.count) : "build out state"+(mod.start+mod.count))+". : "+module.currentState;
			log(this+" Item reported state reached for "+info+" : "+module.name+" : "+this.moduleCount);
			if(allModsAtState()){
				log(this+" "+(this.atStateCount)+" Items reached step number "+mod.count+" for "+info+" : "+module);
				this.dispatchEvent(new ViewStateChangeEvent(ViewStateChangeEvent.STATE_REACHED,this.count));
				this.start();
			} else {
				log(this+" No action taken for "+info+" : "+module);
			}
		}
		private function getModData(module:IUIComponent):Object{
			return modules[module.name];
		}
		private function allModsAtState():Boolean{
			return this.moduleCount==this.atStateCount;
		}
		private function allModsComplete():Boolean{
			return this.moduleCount==0;
		}
		public function removeItem(module:IUIComponent):void{
			module.removeEventListener(ViewStateChangeEvent.STATE_REACHED,this.reportStateReached);
			module.removeEventListener(ViewStateChangeEvent.CHANGE_COMPLETE,this.reportChangeComplete);
			this.modules[module.name]=null;
		}
		public function start():void{
			var mc:Number = 0;
			if(this.moduleCount>0){
				this.atStateCount = 0;
				count = (this.moduleCount-this.completeCount) ? count+1 : 0;
				log(this+" "+(this.moduleCount)+" Items going to step "+this.count+" : "+((this.reverse) ? "break down" : "build out"));
				
				for each (var mod:Object in this.modules){
					if(mod && !mod.inTransition){
						mod.inTransition = true;
						mc++;
						mod.count++;
						var info:String = ((this.reverse) ? "break down state"+(mod.start-mod.count) : "build out state"+(mod.start+mod.count))+".";
						if(!mod.comp){
							var state:Number = (this.reverse) ? (mod.start-mod.count) : (mod.start+mod.count);
							try{
							log(this+" Item going to state number "+state+" : "+((this.reverse) ? "break down" : "build out")+" : "+mod.mod);
							UIComponent(mod.mod).currentState = "state"+state;
							} catch (e:Error){
								log(mod.mod+" : "+e.message,1);
								log("\t"+e.getStackTrace());
							}
						}
					}
				}
				//this.moduleCount = mc;
			} 
			if(this.moduleCount==0){
				this.dispatchEvent(new ViewStateChangeEvent(ViewStateChangeEvent.CHANGE_COMPLETE,this.count));
			}
		}
		public function stop():void{
			log(this+" is stopped. "+(this.moduleCount-this.completeCount)+" Items going to step "+this.count+" : "+((this.reverse) ? "break down" : "build out"));
			for each(var module:UIComponent in this.modules){
				if(module){
					module.removeEventListener(ViewStateChangeEvent.STATE_REACHED,this.reportStateReached);
					module.removeEventListener(ViewStateChangeEvent.CHANGE_COMPLETE,this.reportStateReached);
				}
			}
			this.completeCount = 0;
			this.moduleCount = 0;
			this.modules = new Object();
		}
		private function log(message:Object,level:int=0):void{
			 Logger.log(this+" "+String(message),level);
		}
		public override function toString():String{return "[ViewStateController"+this.instanceNumber+"]";}
	}
}