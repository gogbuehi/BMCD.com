package com.hphant.components
{
	import com.hphant.components.buttons.PermaClickLinkButton;
	
	import mx.controls.Button;
	import mx.controls.LinkBar;
	import mx.core.ClassFactory;
	import mx.core.mx_internal;
	import mx.events.FlexEvent;
	use namespace mx_internal;
	public class HMLinkBar extends LinkBar
	{
		public function HMLinkBar()
		{
			super();
			navItemFactory = new ClassFactory(PermaClickLinkButton);
		}
		override protected function hiliteSelectedNavItem(index:int):void
	    {
	        var child:Button;
	
	        // Un-hilite the current selection.
	        if (selectedIndex != -1 && selectedIndex < numChildren)
	        {
	            child = Button(getChildAt(selectedIndex));
	            child.enabled = true;
	        }
	
	        // Set new index.
	        //super.selectedIndex = index;
	        this._selectedIndex = index;
	        // Hilite the new selection.
	        if (selectedIndex != -1 && selectedIndex < numChildren)
	        {
		        child = Button(getChildAt(selectedIndex));
		        child.enabled = false;
	        }
	    }
		private var _selectedIndex:int = -1;
		private var _selectedIndexChanged:Boolean = false;
	    [Inspectable]
		[Bindable("valueCommit")]
		public override function get selectedIndex():int{return this._selectedIndex;}
		public override function set selectedIndex(value:int):void{
			this._selectedIndexChanged = (this._selectedIndex!=value);
			if(this._selectedIndexChanged){
				this.hiliteSelectedNavItem(value);
				this.invalidateProperties();
				this.dispatchEvent(new FlexEvent(FlexEvent.VALUE_COMMIT));
			}
		}
		override protected function commitProperties():void
	    {
	        super.commitProperties();
	
	        if (_selectedIndexChanged)
	        {
	            _selectedIndexChanged = false;
	        }
	    }
	}
}