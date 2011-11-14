package com.hphant.components {
	import flash.events.Event;
	
	import mx.core.UIComponent;
	
	public class WaitingCircle extends UIComponent{
		
		public function WaitingCircle():void{
			super();
		}
		/**
		 * The degrees of the current fill
		 * */
		[Inspectable]
		[Bindable(event="degreesChanged")]
		public function get degrees():Number{return this._degrees;}
		public function set degrees(value:Number):void{
			if(this._degrees!=value){
				this._degrees=value;
				this.dispatchEvent(new Event("degreesChanged"));
			}
		}
		private var _degrees:Number = 0;
		/**
		 * The starting angle of the circle fill
		 * */
		[Inspectable]
		[Bindable(event="initdegreeChanged")]
		public function get initdegree():Number{return this._initdegree;}
		public function set initdegree(value:Number):void{
			if(this._initdegree!=value){
				this._initdegree=value;
				this.rotation = this._initdegree;
				this.dispatchEvent(new Event("initdegreeChanged"));
			}
		}
		private var _initdegree:Number = -90;
		/**
		 * The number of lines to draw ti increase precizion of the circle
		 * */
		[Inspectable]
		[Bindable(event="divsChanged")]
		public function get divs():Number{return this._divs;}
		public function set divs(value:Number):void{
			if(this._divs!=value){
				this._divs=value;
				this.rotate();
				this.dispatchEvent(new Event("divsChanged"));
			}
		}
		private var _divs:Number = 30;
		/**
		 * The radius of the circle
		 * */
		[Inspectable]
		[Bindable(event="radiusChanged")]
		public function get radius():Number{return this._radius;}
		public function set radius(value:Number):void{
			if(this._radius!=value){
				this._radius=value;
				this.rotate();
				this.dispatchEvent(new Event("radiusChanged"));
			}
		}
		private var _radius:Number = 10;
		/**
		 * The width of the border
		 * */
		[Inspectable]
		[Bindable(event="borderChanged")]
		public function get border():Number{return this._border;}
		public function set border(value:Number):void{
			if(this._border!=value){
				this._border=value;
				this.rotate();
				this.dispatchEvent(new Event("borderChanged"));
			}
		}
		private var _border:Number = 3;
		/**
		 * The distance to place the circle from the mouse
		 * */
		[Inspectable]
		[Bindable(event="mouseDistanceChanged")]
		public function get mouseDistance():Number{return this._mouseDistance;}
		public function set mouseDistance(value:Number):void{
			if(this._mouseDistance!=value){
				this._mouseDistance=value;
				this.dispatchEvent(new Event("mouseDistanceChanged"));
			}
		}
		private var _mouseDistance:Number = 10;
		/**
		 * Locks the circle to the mouse
		 * */
		[Inspectable]
		[Bindable(event="lockMouseChanged")]
		public function get lockMouse():Boolean{return this._lockMouse;}
		public function set lockMouse(value:Boolean):void{
			if(this._lockMouse!=value){
				this._lockMouse=value;
				this.dispatchEvent(new Event("lockMouseChanged"));
			}
		}
		private var _lockMouse:Boolean = false;
		/**
		 * The color of the circle
		 * */
		[Inspectable]
		[Bindable(event="colorChanged")]
		public function get color():uint{return this._color;}
		public function set color(value:uint):void{
			if(this._color!=value){
				this._color=value;
				this.rotate();
				this.dispatchEvent(new Event("colorChanged"));
			}
		}
		private var _color:uint = 0xFF00FF;
		
		[Inspectable]
		[Bindable(event="percentChanged")]
		public function get percent():Number{return this._percent;}
		public function set percent(value:Number):void{
			if(this._percent!=value){
				this._percent = (value > 100) ? 100 : (value < 0) ? 0 : value;
				this.rotate();
				this.dispatchEvent(new Event("percentChanged"));
			}
		}
		private var _percent:Number = 0;
		
		private function rotate():void{
			this.degrees = this.percent*360/100;
			this.graphics.clear();
			this.degrees = (this.degrees>360) ? this.degrees - 360 : this.degrees;
			var div:Number = this.degrees/this.divs;
			this.graphics.beginFill(this.color);
			
			var xc:Number = this.radius * Math.cos(0); 
			var yc:Number = this.radius * Math.sin(0); 
			for (var i:uint=0; i<divs+1; i++){
				var deg:Number = i*div; 
				var radians:Number = deg * (Math.PI/180);
				xc = this.radius * Math.cos(radians); 
				yc = this.radius * Math.sin(radians); 
				this.graphics.lineTo(xc, yc); 
			}
			this.graphics.lineTo(xc, yc);
			this.graphics.endFill();
			this.graphics.lineStyle(this.border,this.color);
			this.graphics.drawCircle(0, 0, this.radius);
		}
	}
}