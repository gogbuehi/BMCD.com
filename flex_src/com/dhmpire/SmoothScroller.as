package com.dhmpire {
	
	import flash.display.DisplayObject;
	import flash.events.Event;
	
	public class SmoothScroller {
		
		public var target:DisplayObject;
		public var axis:String;
		public var min:Number;
		public var max:Number;
		public var speed:Number;
		public var inc:Number;
		private var dir:String;
		private var diff:Number;
		
		public var slider:DisplayObject;
		public var slideType:String;
		public var slidePct:Number = 0;
		public var slideMin:Number;
		public var slideMax:Number;
		public var slideRange:Number;
				
		public function SmoothScroller(targ:DisplayObject, props:Object) {
			target = targ;			
			for (var istr:String in props) {
				switch (istr) {
					case "axis":
						axis = props[istr];
						break;
					case "speed":
						speed = props[istr];
						break;
					case "min":
						min = props[istr];
						break;
					case "max":
						max = props[istr];
						break;
					case "increment":
						inc = props[istr];
						break;
				}
			}			
		}
		
		public function scroll(direction:String):void {
			dir = direction;
			target.addEventListener(Event.ENTER_FRAME, doScroll);
		}
		
		private function doScroll(e:Event):void {
			switch (dir) {
				case "inc":
					if(target[axis] > max + inc){
						target[axis] -= inc/speed;
					} else {
						if(target[axis] > max){
							target[axis] -= (target[axis] - max)/speed;
						} else {
							target.removeEventListener(Event.ENTER_FRAME, doScroll);
						}
					}
					break;
				case "dec":
					if(target[axis] < min - inc){
						target[axis] += inc/speed;
					} else {
						if(target[axis] < min){
							target[axis] += (min - target[axis])/speed;
						} else {
							target.removeEventListener(Event.ENTER_FRAME, doScroll);
						}
					}
					break;
			}			
		}
		
		public function endScroll():void {
			target.removeEventListener(Event.ENTER_FRAME, doScroll);
			switch(dir) {
				case "inc":
					diff = (target[axis] > max + inc) ? target[axis] - inc : max;
					break;
				case "dec":
					diff = (target[axis] < min - inc) ? target[axis] + inc : min;
					break;
			}
			target.addEventListener(Event.ENTER_FRAME, doEndScroll);
		}
		
		private function doEndScroll(e:Event):void {
			switch (dir) {
				case "inc":
					if(target[axis] > diff){
						target[axis] -= (target[axis] - diff)/speed;
					} else {
						target.removeEventListener(Event.ENTER_FRAME, doEndScroll);
					}
					break;
				case "dec":
					if(target[axis] < diff){
						target[axis] += (diff - target[axis])/speed;
					} else {
						target.removeEventListener(Event.ENTER_FRAME, doEndScroll);
					}
					break;
			}
		}
		
		public function killScroll():void {
			target.removeEventListener(Event.ENTER_FRAME, doScroll);
			target.removeEventListener(Event.ENTER_FRAME, doEndScroll);
			target[axis] = min;
		}
		
		public function slide(type:String, sMin:Number, sMax:Number, sliderObj:DisplayObject = null):void {
			diff = max - min;
			slider = (sliderObj != null) ? sliderObj : target.parent;
			slideType = type;
			slideMin = sMin;
			slideMax = sMax;
			slideRange = slideMax - slideMin;
			target.addEventListener(Event.ENTER_FRAME, doSlide);
		}
		
		private function doSlide(e:Event):void {
			switch(slideType) {
				case "slider":
					slidePct = (slider[axis] - slideMin) / slideRange;
					break;
				case "mouse":
					if(slider.hitTestPoint(slider.stage.mouseX, slider.stage.mouseY)){
						slidePct = (target.parent["mouse" + axis.toUpperCase()] - slideMin) / slideRange;
					}
					if (slidePct < 0) slidePct = 0;
					if (slidePct > 1) slidePct = 1;
					break;
			}
			target[axis] += (min + (diff * slidePct) - target[axis]) / speed;			
		}
		
		public function endSlide():void {
			target.removeEventListener(Event.ENTER_FRAME, doSlide);
		}
		
	}
	
}