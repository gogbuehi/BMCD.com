package com.hphant.components.buttons
{
	import com.hphant.utils.Logger;
	
	import flash.display.DisplayObject;
	import flash.events.Event;
	
	import mx.collections.ListCollectionView;
	import mx.containers.Box;
	import mx.containers.BoxDirection;
	import mx.controls.Button;
	import mx.controls.Image;
	import mx.controls.listClasses.IListItemRenderer;
	import mx.core.ClassFactory;
	import mx.core.EdgeMetrics;
	import mx.core.IBorder;
	import mx.core.IFactory;
	import mx.core.IFlexAsset;
	import mx.core.ScrollPolicy;

	public class MultiImageButton extends Button
	{
		public function MultiImageButton()
		{
			super();
		}
		private var _dataProvider:ListCollectionView;
		private var _dataProviderChanged:Boolean = false;
		[Inspectable]
		public function get dataProvider():ListCollectionView{return this._dataProvider;}
		public function set dataProvider(value:ListCollectionView):void{
			this._dataProvider = value;
			this._dataProviderChanged = true;
			this.invalidateProperties();
		}
		
	    private var _itemRenderer:IFactory = new ClassFactory(mx.controls.Image);
	    [Inspectable(category="Data")]
	    public function get itemRenderer():IFactory
	    {
	        return _itemRenderer;
	    }
	    public function set itemRenderer(value:IFactory):void
	    {
	        _itemRenderer = value;
	    }
		
		private var _box:Box;
		
		protected override function createChildren():void{
			super.createChildren();
			if(!this._box){
				this._box = new Box();
				this._box.direction = BoxDirection.HORIZONTAL;
				this._box.horizontalScrollPolicy = ScrollPolicy.OFF;
				this._box.verticalScrollPolicy = ScrollPolicy.OFF;
				this._box.setStyle('verticalAlign','middle');
				this._box.setStyle('horizontalAlign','center');
				this._box.setStyle('horizontalGap','0');
				this._box.setStyle('verticalGap','0');
				this._box.setStyle('paddingLeft','0');
				this._box.setStyle('paddingRight','0');
				this._box.setStyle('paddingTop','0');
				this._box.setStyle('paddingBottom','0');
				this.addChild(this._box);
				this.invalidateProperties();
			}
		}
		protected override function commitProperties():void{
			if(this._dataProviderChanged && this._box){
				if(this._dataProvider){
					var i:int = 0;
					for each(var item:Object in this._dataProvider){
						this.setItemAt(item,i);
						i++;
					}
					while(this._box.numChildren>this._dataProvider.length){
						this._box.removeChildAt(this._box.numChildren);
					}
				} else {
					this._box.removeAllChildren();
				}
				this._dataProviderChanged = false;
				this.invalidateDisplayList();
				this.invalidateSize();
			}
		}
		private function addItem(item:Object):void{
			var rend:IListItemRenderer = IListItemRenderer(ClassFactory(this._itemRenderer).newInstance());
			rend.data = item;
			if(rend is Image){
				Image(rend).source = item.@src;
				Image(rend).autoLoad = true;
				Image(rend).maintainAspectRatio = true;
				Image(rend).addEventListener(Event.COMPLETE,this.imageLoaded);
				//Image(rend).addEventListener(FlexEvent.UPDATE_COMPLETE,this.imageLoaded);
			}
			this._box.addChild(DisplayObject(rend));	
		}
		private function imageLoaded(event:Event):void{
			var h:Number = 0;
			var w:Number = 0;
			for each(var image:Image in this._box.getChildren()){
				if(this._box.direction==BoxDirection.VERTICAL){
					h+=image.loaderInfo.height;
					w = (w<image.loaderInfo.width) ? image.loaderInfo.width : w;
				} else {
					w+=image.loaderInfo.width;
					h = (h<image.loaderInfo.height) ? image.loaderInfo.height : h;
				}
			}
			this._box.height = h;
			this._box.width = w;
			this.invalidateDisplayList();
		}
		private function setItemAt(item:Object,index:int):void{
			if(index<this._box.numChildren){
				IListItemRenderer(this._box.getChildAt(index)).data = item;
				if(this._box.getChildAt(index) is Image){
					Image(this._box.getChildAt(index)).source = item.@src;
				}
			} else {
				this.addItem(item);
			}
		}
		protected override function updateDisplayList(unscaledWidth:Number, unscaledHeight:Number):void{
			super.updateDisplayList(unscaledWidth,unscaledHeight);
			this._box.x = this.getStyle('paddingLeft');
			this._box.y = this.getStyle('paddingTop');
			this.swapChildrenAt(this.getChildIndex(this._box),this.numChildren-1);
		}
		 override protected function measure():void
	    {
	       super.measure();
	
	        var w:Number = 0;
	        var h:Number = 0;
	
	         w += getStyle("paddingLeft") + getStyle("paddingRight");
	         h += getStyle("paddingTop") + getStyle("paddingBottom");
	        var currentSkin:Object = this.getStyle('skin');
	        var bm:EdgeMetrics = currentSkin &&
	                             currentSkin is IBorder && !(currentSkin is IFlexAsset) ?
	                             IBorder(currentSkin).borderMetrics :
	                             null;
	        
	        if (bm)
	        {
	            w += bm.left + bm.right;
	            h += bm.top + bm.bottom
	        }
	        /* 
	        // Use the larger of the measured sizes and the skin's preferred sizes.
	        // Each skin should override measure() with their measuredWidth
	        // and measuredHeight.
	        var skinMeasuredWidth:Number;
	        var skinMeasuredHeight:Number;
	        if (currentSkin && (isNaN(skinMeasuredWidth) || isNaN(skinMeasuredHeight)))
	        {
	            skinMeasuredWidth = currentSkin.measuredWidth;
	            skinMeasuredHeight = currentSkin.measuredHeight;
	        }
	
	        if (!isNaN(skinMeasuredWidth))
	            w = Math.max(skinMeasuredWidth, w);
	
	        if (!isNaN(skinMeasuredHeight))
	            h = Math.max(skinMeasuredHeight, h);
	 */
	 		if(this._box){
	 			this._box.validateNow();
	 			h += this._box.height;
	 			w += this._box.width;
	 		}
	        measuredMinWidth = measuredWidth = w;
	        measuredMinHeight = measuredHeight = h;
	    }
	    private function log(message:Object,level:int=0):void{
	    	Logger.log("[MultiImageButton:"+this.name+"] "+message,level);
	    }
	}
}