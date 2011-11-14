/***********************************
 * MiniCalendar v1.2
 * 
 * Build Date: 04/19/2008
 * 
 * Adam Jackett
 * adam@darkhousemedia.com
 * www.darkhousemedia.com
 ***********************************/

package com.dhmpire {
	
	import caurina.transitions.Tweener;
	
	import com.dhmpire.Events.CalendarEvent;
	import com.hphant.modsite.data.calendar.BMCDEventItemData;
	
	import flash.display.DisplayObjectContainer;
	import flash.display.Graphics;
	import flash.display.MovieClip;
	import flash.display.Sprite;
	import flash.display.Stage;
	import flash.events.Event;
	import flash.events.EventDispatcher;
	import flash.events.IEventDispatcher;
	import flash.events.IOErrorEvent;
	import flash.events.MouseEvent;
	import flash.filters.DropShadowFilter;
	import flash.filters.GlowFilter;
	import flash.net.URLLoader;
	import flash.net.URLRequest;
	import flash.text.AntiAliasType;
	import flash.text.TextField;
	import flash.text.TextFieldAutoSize;
	import flash.text.TextFormat;
	import flash.text.TextFormatAlign;
	
	import mx.core.UIComponent;
	import mx.styles.CSSStyleDeclaration;
	import mx.styles.StyleManager;

	[Style(name="days",type="Array",arrayType="String")]
	[Style(name="dateFormat",type="Array",arrayType="String")]
	[Style(name="months",type="Array",arrayType="String")]
	[Style(name="monthFontFamily",type="String")]
	[Style(name="dayFontFamily",type="String")]
	[Style(name="dateFontFamily",type="String")]
	[Style(name="eventFontFamily",type="String")]
	[Style(name="dateLabelAlign",type="String",enumeration="C,TL,BL,TR,BR")]
	[Style(name="dateWidth",type="Number")]
	[Style(name="dateHeight",type="Number")]
	[Style(name="datePadding",type="Number")]
	[Style(name="transitionDelay",type="Number")]
	[Style(name="transitionTime",type="Number")]
	[Style(name="weekStart",type="uint")]
	[Style(name="monthFontSize",type="uint")]
	[Style(name="dayFontSize",type="uint")]
	[Style(name="eventFontSize",type="uint")]
	[Style(name="dateFontSize",type="uint")]
	[Style(name="monthColor",type="uint",format="Color")]
	[Style(name="dayColor",type="uint",format="Color")]
	[Style(name="eventColor",type="uint",format="Color")]
	[Style(name="dateColor",type="uint",format="Color")]
	[Style(name="dateBackgroundColor",type="uint",format="Color")]
	[Style(name="dateHighlightColor",type="uint",format="Color")]
		
	public class MiniCalendar implements IEventDispatcher{
		
		private var container:DisplayObjectContainer;
		public function get sprite():DisplayObjectContainer{
			return this.container;
		}
		private var dispatcher:EventDispatcher;
		private var stage:Stage;
		private var loader:URLLoader;
		private var _xml:XML;
		private var events:Object = new Object();
		private var firstRun:Boolean = true;
		public function get height():Number{
			return dates.y+(incX+this.datePadding)*6;
		}
		public function get width():Number{
			return (incY+this.datePadding)*7 + this.datePadding;
		}
		private var monthTextFormat:TextFormat;
		private var dateTextFormat:TextFormat;
		private var dayTextFormat:TextFormat;
		private var eventTextFormat:TextFormat;
		private var todayStroke:GlowFilter;
		
		private var monthDays:Array = new Array(31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31);
		
		private var today:Date = new Date();
		private var calendar:Date = new Date(today.fullYear, today.month);
		
		private var incX:Number;
		private var incY:Number;
		private var day:Number = 0;
		private var week:Number = 0;
		private var days:Array = new Array();
		private var frame:Sprite = new Sprite();
		private var monthLabel:TextField;
		
		private var dayLabels:Sprite = new Sprite();
		
		private var arrowLeft:Sprite;
		private var arrowRight:Sprite;
		private var arrowUp:Sprite;
		private var arrowDown:Sprite;
		
		private var dates:Sprite = new Sprite();
		
		
		private var dateLabel:TextField;
		private var maskContent:Sprite;
		private var scrollContent:Sprite;
		private var autoDisplayEvent:Boolean = false;
		
		public function get dayLabelNames():Array{
			var s:Object = this.getStyle("days");
			return (s) ? s as Array : ["S", "M", "T", "W", "T", "F", "S"];
		}
		public function get dateFormat():Array{
			var s:Object = this.getStyle("dateFormat");
			return (s) ? s as Array : ["m", " ", "d", ",", " ", "y"];
		}
		public function get months():Array{
			var s:Object = this.getStyle("months");
			return (s) ? s as Array : ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
		}
		public function get monthFontFamily():String{
			var s:Object = this.getStyle("monthFontFamily");
			return (s) ? String(s) : "Times";
		}
		public function get dayFontFamily():String{
			var s:Object = this.getStyle("dayFontFamily");
			return (s) ? String(s) : "Times";
		}
		public function get dateFontFamily():String{
			var s:Object = this.getStyle("dateFontFamily");
			return (s) ? String(s) : "Times";
		}
		public function get eventFontFamily():String{
			var s:Object = this.getStyle("eventFontFamily");
			return (s) ? String(s) : "Times";
		}
		public function get dateLabelAlign():String{
			var s:Object = this.getStyle("dateLabelAlign");
			return (s) ? String(s) : "C";
		}
		public function get dateWidth():Number{
			var s:Object = this.getStyle("dateWidth");
			return (s) ? Number(s) : 50;
		}
		public function get dateHeight():Number{
			var s:Object = this.getStyle("dateHeight");
			return (s) ? Number(s) : 50;
		}
		public function get datePadding():Number{
			var s:Object = this.getStyle("datePadding");
			return (s) ? Number(s) : 1;
		}
		public function get transitionDelay():Number{
			var s:Object = this.getStyle("transitionDelay");
			return (s) ? Number(s) : 0;
		}
		public function get transitionTime():Number{
			var s:Object = this.getStyle("transitionTime");
			return (s) ? Number(s) : 1000;
		}
		public function get weekStart():uint{
			var s:Object = this.getStyle("weekStart");
			return (s && s<7) ? uint(s) : 0;
		}
		public function get monthFontSize():uint{
			var s:Object = this.getStyle("monthFontSize");
			return (s) ? uint(s) : 10;
		}
		public function get dayFontSize():uint{
			var s:Object = this.getStyle("dayFontSize");
			return (s) ? uint(s) : 10;
		}
		public function get eventFontSize():uint{
			var s:Object = this.getStyle("eventFontSize");
			return (s) ? uint(s) : 10;
		}
		public function get dateFontSize():uint{
			var s:Object = this.getStyle("dateFontSize");
			return (s) ? uint(s) : 10;
		}
		public function get monthColor():uint{
			var s:Object = this.getStyle("monthColor");
			return (s) ? uint(s) : 0x000000;
		}
		public function get dayColor():uint{
			var s:Object = this.getStyle("dayColor");
			return (s) ? uint(s) : 0x000000;
		}
		public function get eventColor():uint{
			var s:Object = this.getStyle("eventColor");
			return (s) ? uint(s) : 0x000000;
		}
		public function get dateColor():uint{
			var s:Object = this.getStyle("dateColor");
			return (s) ? uint(s) : 0x000000;
		}
		public function get dateBackgroundColor():uint{
			var s:Object = this.getStyle("dateBackgroundColor");
			return (s) ? uint(s) : 0xFFFFFF;
		}
		public function get dateHighlightColor():uint{
			var s:Object = this.getStyle("dateHighlightColor");
			return (s) ? uint(s) : 0xFF0000;
		}
		private var cssDeclaration:CSSStyleDeclaration;
		private function getStyle(name:String):Object{
			return cssDeclaration.getStyle(name);
		}
		
		public function MiniCalendar(objContainer:DisplayObjectContainer, arrows:Object) {
			this.dispatcher = new EventDispatcher(this);
			this.cssDeclaration = StyleManager.getStyleDeclaration("MiniCalendar");
			stage = objContainer.stage;
			var cntr:UIComponent = new UIComponent();
			objContainer.addChild(cntr);
			var sprt:Sprite = new Sprite();
			cntr.addChild(sprt);
			container = sprt;
			container.addChild(this.frame);
			container.addChild(dates);
			for (var istr:String in arrows) {
				switch (istr) {					
					case "left":
						arrowLeft = arrows[istr];
						break;
					case "right":
						arrowRight = arrows[istr];
						break;
					case "up":
						arrowUp = arrows[istr];
						break;
					case "down":
						arrowDown = arrows[istr];
						break;
				}
			}
			
			loader = new URLLoader();
			
			
		}
		public function get xml():XML{return this._xml;}
		public function set url(val:String):void{
			loader.load(new URLRequest(val));
			loader.addEventListener(Event.COMPLETE, this.initCalendar);
			loader.addEventListener(IOErrorEvent.IO_ERROR,this.xmlError);
		}
		public function set xml(val:XML):void{
			var isNew:Boolean = true;
			if(this._xml){
				isNew = false;
			}
			this._xml = val;
			calendar = (this._xml) ? new Date(this._xml.@year, Number(this._xml.@month)-1) : new Date();
			this.setEventData();
			if(isNew){
				this.initCalendar();
			} else {
				this.changeCalendar();
			}
		}
		private function setEventData():void{
			var xmlList:XMLList = this._xml.li.(attribute("class")=="CalendarItem");
			for each(var tr:XML in this._xml.tbody.tr){
				var di:BMCDEventItemData = new BMCDEventItemData();
				di.row = tr;
				var tempDate:String = String(di.date.data);
				var eDate:Array = tempDate.split("/");
				var eYear:String = "y"+eDate[2];
				var eMonth:String = "m"+eDate[0];
				var eDay:String = "d"+eDate[1];
				if(events[eYear] == undefined) events[eYear] = new Object();
				if(events[eYear][eMonth] == undefined) events[eYear][eMonth] = new Object();
				if(events[eYear][eMonth][eDay] == undefined) events[eYear][eMonth][eDay] = new Array();
				events[eYear][eMonth][eDay].push(di);
			}
		}
		private function xmlError(e:IOErrorEvent):void{
			trace(e.text);
		}
		private function cleanQuotesFromCSSString(obj:Object,prop:String):void{
			var font:Array = String(obj[prop]).split("\"");
			if(font.length==3){
				obj[prop] = font[1];
			}
		}

		private function initCalendar(e:Event=null):void {
			if(e){
				this._xml = new XML(e.target.data);
			}
			
			incX = this.dateWidth + this.datePadding;
			incY = this.dateHeight + this.datePadding;
			
			monthTextFormat = new TextFormat();
			monthTextFormat.align = TextFormatAlign.CENTER;
			monthTextFormat.font = this.monthFontFamily;
			monthTextFormat.size = this.monthFontSize;
			monthTextFormat.color = this.monthColor;
			
			dateTextFormat = new TextFormat();
			dateTextFormat.font = this.dateFontFamily;
			dateTextFormat.size = this.dateFontSize;
			dateTextFormat.color = this.dateColor;
			dateTextFormat.leading = -2;
			
			eventTextFormat = new TextFormat();
			eventTextFormat.font = this.eventFontFamily;
			eventTextFormat.size = this.eventFontSize;
			eventTextFormat.color = this.eventColor;
			
			
			dayTextFormat = new TextFormat();
			dayTextFormat.align = TextFormatAlign.CENTER;
			dayTextFormat.font = this.dayFontFamily;
			dayTextFormat.size = this.dayFontSize;
			dayTextFormat.color = this.dayColor;
			//findEmbededFont(dayTextFormat);
			
			switch(dateLabelAlign) {
				case "C":
					dateTextFormat.align = TextFormatAlign.CENTER;
					break;
				case "TL":
				case "BL":
					dateTextFormat.align = TextFormatAlign.LEFT;
					break;
				case "TR":
				case "BR":
					dateTextFormat.align = TextFormatAlign.RIGHT;
					break;
			}
			
			
			todayStroke = new GlowFilter(this.dateHighlightColor, 1, 1.1, 1.1, 10, 2, true);
			
			
			monthLabel = new TextField();
			monthLabel.cacheAsBitmap=true;
			monthLabel.antiAliasType = AntiAliasType.ADVANCED;
			monthLabel.embedFonts = true;
			monthLabel.width = incX * 7 - this.datePadding;
			monthLabel.wordWrap=true;
			monthLabel.autoSize = TextFieldAutoSize.CENTER;
			monthLabel.height = Number(monthTextFormat.size);
			monthLabel.selectable = false;
			monthLabel.defaultTextFormat = monthTextFormat;
			monthLabel.text = String(this.months[calendar.month]) + " " + String(calendar.fullYear);
			container.addChild(monthLabel);
			
			for (var j:int = 0; j < dayLabelNames.length; j++) {
				var jx:int = j;
				if (weekStart > 0) jx -= weekStart;
				if (jx < 0) jx += 7;
				var dayLabel:TextField = new TextField();
				dayLabel.cacheAsBitmap = true;
				dayLabel.antiAliasType = AntiAliasType.ADVANCED;
				dayLabel.embedFonts = true;
				dayLabel.x = incX * jx;
				dayLabel.width = incX - this.datePadding;
				dayLabel.height = Number(dayTextFormat.size);
				dayLabel.selectable = false;
				dayLabel.defaultTextFormat = dayTextFormat;
				dayLabel.text = dayLabelNames[jx];
				dayLabels.addChild(dayLabel);
			}
			container.addChild(dayLabels);
			
			dayLabels.y = Number(monthTextFormat.size) + 10;
			
			dates.y = dayLabels.y + dayLabels.height + 10;
			if(arrowLeft){
				arrowLeft.width = arrowLeft.height = this.monthFontSize;
			arrowLeft.x = (incX - this.datePadding) / 2;
			arrowLeft.y = Number(monthTextFormat.size) / 2;
			arrowLeft.buttonMode = true;
			arrowLeft.mouseChildren = false;
			arrowLeft.addEventListener(MouseEvent.CLICK, prevMonth);
			container.addChild(arrowLeft);
			}
			if(arrowRight){
				arrowRight.width = arrowRight.height = this.monthFontSize;
			arrowRight.x = incX * 7 - this.datePadding - (incX - this.datePadding) / 2;
			arrowRight.y = Number(monthTextFormat.size) / 2;
			arrowRight.buttonMode = true;
			arrowRight.mouseChildren = false;
			arrowRight.addEventListener(MouseEvent.CLICK, nextMonth);
			container.addChild(arrowRight);
			}
			
			
			
			dateLabel = new TextField();
			dateLabel.cacheAsBitmap=true;
			dateLabel.antiAliasType = AntiAliasType.ADVANCED;
			dateLabel.autoSize = TextFieldAutoSize.LEFT;
			dateLabel.embedFonts = true;
			dateLabel.width = 0;
			dateLabel.selectable = false;
			dateLabel.defaultTextFormat = dateTextFormat;
			dateLabel.height = dateLabel.textHeight * dateLabel.numLines;
		
			dates.graphics.beginFill(0x000000,0);
			dates.graphics.drawRect(0,0,this.dateWidth*7+this.datePadding*5,this.dateHeight*6+this.datePadding*5);
			dates.graphics.endFill();
			for (var d:int = 1; d <= 31; d++) {
				var cd:MovieClip = new MovieClip();
				var cdbg:Sprite = new Sprite();
				cdbg.cacheAsBitmap = true;
				cdbg.graphics.beginFill(this.dateBackgroundColor);
				cdbg.graphics.drawRect(0, 0, this.dateWidth, this.dateHeight);
				cdbg.graphics.endFill();
				cd.addChild(cdbg);
				var av:Sprite = new Sprite();
				av.cacheAsBitmap = true;
				cd.addChild(av);
				var cdfg:Sprite = new Sprite();
				cdfg.cacheAsBitmap = true;
				cdfg.graphics.beginFill(this.dateBackgroundColor,0);
				cdfg.graphics.drawRect(0, 0,this.dateWidth, this.dateHeight);
				cdfg.graphics.endFill();
				
				var ds:DropShadowFilter = new DropShadowFilter(2);
				var filters:Array = cdbg.filters;
				if(!filters){
					cdbg.filters = [ds];
				} else {
					filters.push(ds);
					cdbg.filters = filters;
				}
				
				var txtLabel:TextField = new TextField();
				txtLabel.cacheAsBitmap = true;
				txtLabel.name = "tLabel"+String(d);
				txtLabel.antiAliasType = AntiAliasType.ADVANCED;
				txtLabel.autoSize = TextFieldAutoSize.LEFT;
				txtLabel.embedFonts = true;
				txtLabel.width = 0;
				txtLabel.height = 0;
				txtLabel.selectable = false;
				txtLabel.defaultTextFormat = this.dateTextFormat;
				txtLabel.text = String(d);
				
				switch(this.dateLabelAlign) {
					case "C":
						txtLabel.autoSize = TextFieldAutoSize.CENTER;
						txtLabel.x = cd.width / 2 - txtLabel.width / 2;
						txtLabel.y = cd.height / 2 - txtLabel.height / 2;			
						break;
					case "TL":
						break;
					case "TR":
						txtLabel.x = cd.width - txtLabel.width;
						txtLabel.autoSize = TextFieldAutoSize.RIGHT;
						break;
					case "BL":
						txtLabel.y = cd.height - txtLabel.height;
						break;
					case "BR":
						txtLabel.x = cd.width - txtLabel.width;
						txtLabel.y = cd.height - txtLabel.height;
						txtLabel.autoSize = TextFieldAutoSize.RIGHT;
						break;
				}
				
				cd.addChild(txtLabel);
				cd.addChild(cdfg);
				dates.addChild(cd);
				days.push(cd);
				cd.buttonMode = true;
				cd.cacheAsBitmap=true;
				cd.addEventListener(MouseEvent.CLICK, clickEvents);
				cd.addEventListener(MouseEvent.MOUSE_OVER, mouseOverEvent);
				cd.addEventListener(MouseEvent.MOUSE_OUT, mouseOutEvent);
			}
			
			this.drawFrame();	
			changeCalendar();
			this.dispatchEvent(new CalendarEvent(CalendarEvent.LOADED,zeropad(calendar.fullYear,2),zeropad(calendar.month+1,2)));
		}
		private function drawFrame():void{
			this.frame.graphics.beginFill(0xffffff,0);
			this.frame.graphics.drawRect(0,0,incX*6+this.datePadding*5,dates.y+incY*5+this.datePadding*5);
			this.frame.graphics.endFill();
		}
		private function nextMonth(e:MouseEvent):void {
			var month:Number = calendar.month + 1;
			var year:Number = calendar.fullYear;
			if(month == 12){
				month = 0;
				year += 1;
			}
			calendar = new Date(year, month);
			changeCalendar();
			this.dispatchEvent(new CalendarEvent(CalendarEvent.MONTH_NEXT,zeropad(year,2),zeropad(month+1,2)));
		}

		private function prevMonth(e:MouseEvent):void {
			var month:Number = calendar.month - 1;
			var year:Number = calendar.fullYear;
			if(month == -1){
				month = 11;
				year -= 1;
			}
			calendar = new Date(year, month);
			changeCalendar();
			this.dispatchEvent(new CalendarEvent(CalendarEvent.MONTH_PREVIOUS,zeropad(year,2),zeropad(month+1,2)));
		}
		public function toMonth(year:Number, month:Number):void{
			month--;
			if(month == -1){
				month = 11;
				year -= 1;
			} else if(month == 12){
				month = 0;
				year += 1;
			}
			calendar = new Date(year, month);
			changeCalendar();
		}
		
		private function changeCalendar():void {
			monthLabel.text = String(this.months[calendar.month]) + " " + String(calendar.fullYear);
			if(calendar.month == 1) monthDays[1] = (calendar.fullYear % 4 == 0) ? 29 : 28;
			day = calendar.day;
			week = 0;
			var delay:Number = this.transitionDelay;
			for(var d:int = 0; d < 31; d++){
				var cd:MovieClip = days[d];
				
				var dayx:int = day;
				if (weekStart > 0) dayx -= weekStart;
				if (dayx < 0) dayx += 7;
				
				var newX:Number = dayx * incX;
				var newY:Number = week * incY;
				var newAlpha:Number = 0.5;
				if(d >= monthDays[calendar.month]){
					newAlpha = 0;
				} else {
					newAlpha = 0.5;
				}
				var cdbg:Sprite = Sprite(cd.getChildAt(0));
				var filters:Array = cdbg.filters;
				var ds:DropShadowFilter;
				for(var dsi:uint=0;dsi<filters.length;dsi++){
					if(filters[dsi] is DropShadowFilter){
						ds = filters[dsi];
					}
				}
				if(calendar.fullYear == today.fullYear && calendar.month == today.month && today.date == d+1){
					ds.color=todayStroke.color;
				} else {
					ds.color=0x000000;
				}
				cdbg.filters=filters;
				var xYear:String = "y"+calendar.fullYear;
				var xMonth:String = "m"+zeropad(calendar.month+1, 2);
				var xDay:String = "d"+zeropad(d+1, 2);
				cd.date = new Array(xYear, xMonth, xDay);
				cd.dateText = dateText(calendar.month, d+1, calendar.fullYear);
				var bg:Sprite = Sprite(cd.getChildAt(0));
				var av:Sprite = Sprite(cd.getChildAt(1));
				var tf:TextField = TextField(cd.getChildAt(2));
				var tft:TextFormat = tf.getTextFormat();
				tf.setTextFormat(this.dateTextFormat);
				av.graphics.clear();
				if(events[xYear] != undefined){
					if(events[xYear][xMonth] != undefined){
						if(events[xYear][xMonth][xDay] != undefined){
							newAlpha = 1;
							if (events[xYear][xMonth][xDay][0] != undefined) {
								switch(this.dateLabelAlign) {
									case "TL":
									case "TR":
									break;
								}
								tft.color = this.dateBackgroundColor;
								tf.setTextFormat(tft);
								this.drawFullCircle(av.graphics,bg.height/4);
								/* switch(String(events[xYear][xMonth][xDay][0].subTitle)){
									case "Booked":
									case "Event":
										tft.color = Number("0x"+String(this.dateCSS.backgroundColor).split("#")[1]);
										tf.setTextFormat(tft);
										this.drawFullCircle(av.graphics,bg.height/4);
									break;
									case "Partial":
										tft.color = Number("0x"+String(this.dateCSS.backgroundColor).split("#")[1]);
										tf.setTextFormat(tft);
										this.drawHalfCircle(av.graphics,bg.height/4);
									break;
									case "Available":
									default:
									break;
								} */
							}
						}
					}
				}
				if (firstRun) {
					cd.x = newX;
					cd.y = newY;
					cd.alpha = newAlpha;
				} else {
					Tweener.addTween(cd, { x: newX, y: newY, alpha: newAlpha, time:this.transitionTime, delay: delay * d } );
				}
				day++;
				if(day == 7) day = 0;
				if(day == weekStart) week++;
			}
			
			if (firstRun) firstRun = false;
		}
		private function drawFullCircle(g:Graphics,r:Number):void{
			g.beginFill(this.eventColor,.75);
			g.drawRect(0, 0, this.dateWidth, this.dateHeight);
			g.endFill();
				
		}
		private function drawHalfCircle(g:Graphics,r:Number):void{
			g.beginFill(this.eventColor,.75);
			g.drawRect(0, 0, this.dateWidth/2, this.dateHeight);
			g.endFill();
			g.beginFill(this.dateBackgroundColor);
			g.drawRect(this.dateWidth/2, 0, this.dateWidth/2, this.dateHeight);
			g.endFill();
		}
		private function clickEvents(e:MouseEvent):void {
			var event:Array = e.currentTarget.date;
			var dateObject:Object;
			var year:String = String(event[0]).replace("y","");
			var month:String = String(event[1]).replace("m","");
			var day:String = String(event[2]).replace("d","");
			if(events[event[0]]){
				if(events[event[0]][event[1]]){
					if(events[event[0]][event[1]][event[2]]){
						 event = events[event[0]][event[1]][event[2]]
					}
				}
			}
			if(event[0] is BMCDEventItemData){
				dateObject = event;
			} else {
				dateObject = null;
			}
			//trace("year="+year+",month="+month+",day="+day+"data="+dateObject);
			this.dispatchEvent(new CalendarEvent(CalendarEvent.DAY_SELECT,year,month,day,dateObject));
		}
		private function mouseOverEvent(e:MouseEvent):void {
			var s:Sprite=Sprite(MovieClip(e.currentTarget).getChildAt(0));
			var filters:Array = s.filters;
			for(var i:uint=0;i<filters.length;i++){
				if(filters[i] is DropShadowFilter){
					var ds:DropShadowFilter = DropShadowFilter(s.filters[0]);
					ds.distance=3;
				}
			}
			s.filters = filters;
			MovieClip(e.currentTarget).x-=1;
		}
		private function mouseOutEvent(e:MouseEvent):void {
			var s:Sprite=Sprite(MovieClip(e.currentTarget).getChildAt(0));
			var filters:Array = s.filters;
			for(var i:uint=0;i<filters.length;i++){
				if(filters[i] is DropShadowFilter){
					var ds:DropShadowFilter = DropShadowFilter(s.filters[0]);
					ds.distance=2;
				}
			}
			s.filters = filters;
			MovieClip(e.currentTarget).x+=1;
		}
		
		
		private function dateText(dMonth:Number, dDay:Number, dYear:Number):String {
			var dText:String = "";
			for each(var df:* in dateFormat) {
				switch(df) {
					case "F":
						dText += this.months[dMonth];
						break;
					case "m":
						dText += zeropad(dMonth+1, 2);
						break;
					case "n":
						dText += (dMonth+1);
						break;
					case "d":
						dText += zeropad(dDay, 2);
						break;
					case "j":
						dText += dDay;
						break;
					case "Y":
						dText += dYear;
						break;
					case "y":
						var shortYear:Array = String(dYear).split("");
						dText += shortYear[2];
						dText += shortYear[3];
						break;
					default:
						dText += df;
						break;
				}
			}
			return dText;
		}
		
		private function zeropad(num:Number, len:Number):String {
			var newnum:String = String(num);
			for(var i:int = 0; i < len-newnum.length; i++){
				newnum = "0"+newnum;
			}
			return newnum;
		}
		public function addEventListener(type:String, listener:Function, useCapture:Boolean=false, priority:int=0, useWeakReference:Boolean=false):void
		{
			this.dispatcher.addEventListener(type,listener,useCapture,priority,useWeakReference);
		}
		
		public function removeEventListener(type:String, listener:Function, useCapture:Boolean=false):void
		{
			this.dispatcher.removeEventListener(type,listener,useCapture);
		}
		
		public function dispatchEvent(event:Event):Boolean
		{
			return this.dispatcher.dispatchEvent(event);
		}
		
		public function hasEventListener(type:String):Boolean
		{
			return this.dispatcher.hasEventListener(type);
		}
		
		public function willTrigger(type:String):Boolean
		{
			return this.dispatcher.willTrigger(type);
		}
		
	}

}