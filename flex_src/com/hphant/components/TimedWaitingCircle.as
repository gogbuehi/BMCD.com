package com.hphant.components
{
	import flash.events.TimerEvent;
	import flash.utils.Timer;
	
	public class TimedWaitingCircle extends WaitingCircle
	{
		public function TimedWaitingCircle()
		{
			super();
			this.timer = new Timer(50);
			this.timer.addEventListener(TimerEvent.TIMER,updateCircle);
		}
		private var timer:Timer;
		private function updateCircle(event:TimerEvent):void{
			var p:Number = this.timer.currentCount*this.step;
			if(p>100){
				this.timer.reset();
				this.timer.start();
				p = 0;
			}
			this.percent = p;
		}
		[Inspectable]
		[Bindable]
		public function get step():Number{return this._step;}
		public function set step(value:Number):void{
			this._step = value;
		}
		private var _step:Number = 1;
		
		
		public function start():void{
			this.timer.start();
		}
		public function stop():void{
			this.timer.stop();
		}
	}
}