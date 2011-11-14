////////////////////////////////////////////////////////////////////////////////
//
//  ADOBE SYSTEMS INCORPORATED
//  Copyright 2003-2007 Adobe Systems Incorporated
//  All Rights Reserved.
//
//  NOTICE: Adobe permits you to use, modify, and distribute this file
//  in accordance with the terms of the license agreement accompanying it.
//
////////////////////////////////////////////////////////////////////////////////

package com.hphant.components.alertClasses
{

import com.hphant.components.AlertPallet;
import com.hphant.components.events.AlertCloseEvent;

import flash.display.DisplayObject;
import flash.events.KeyboardEvent;
import flash.events.MouseEvent;
import flash.ui.Keyboard;

import mx.controls.Button;
import mx.core.IFlexModuleFactory;
import mx.core.IFontContextComponent;
import mx.core.IUITextField;
import mx.core.UIComponent;
import mx.core.UITextField;
import mx.core.mx_internal;
import mx.managers.IFocusManagerContainer;
import mx.managers.ISystemManager;

use namespace mx_internal;

include "../styles/metadata/LeadingStyle.as"
include "../styles/metadata/TextStyles.as"

[ExcludeClass]

/**
 *  @private
 *  The AlertForm control exists within the AlertPallet control, and contains
 *  messages, buttons, and, optionally, an icon. It is not intended for
 *  direct use by application developers.
 *
 *  @see mx.controls.TextArea
 *  @see mx.controls.AlertPallet
 *  @see mx.controls.Button
 */
public class AlertForm extends UIComponent implements IFontContextComponent
{
    include "../core/Version.as";

	//--------------------------------------------------------------------------
	//
	//  Constructor
	//
	//--------------------------------------------------------------------------

	/**
	 *  Constructor.
	 */
	public function AlertForm()
	{
		super();

		tabChildren = true;
	}

	//--------------------------------------------------------------------------
	//
	//  Variables
	//
	//--------------------------------------------------------------------------

	/**
	 *  The UITextField that displays the text of the AlertPallet control.
	 */
	mx_internal var textField:IUITextField;

	/**
	 *  @private
	 *  Width of the text object.
	 */
	private var textWidth:Number;

	/**
	 *  @private
	 *  Height of the text object.
	 */
	private var textHeight:Number;

	/**
	 *  The DisplayObject that displays the icon.
	 */
	private var icon:DisplayObject;

    /**
     *  An Array that contains any Buttons appearing in the AlertPallet control.
     */
	mx_internal var buttons:Array = [];

	/**
	 *  @private
	 */
	mx_internal var defaultButton:Button;

	/**
	 *  @private
	 */
	private var defaultButtonChanged:Boolean = false;

    //--------------------------------------------------------------------------
    //
    //  Properties
    //
    //--------------------------------------------------------------------------
    
    //----------------------------------
    //  fontContext
    //----------------------------------
    
    /**
     *  @private
     */
    public function get fontContext():IFlexModuleFactory
    {
        return moduleFactory;
    }

    /**
     *  @private
     */
    public function set fontContext(moduleFactory:IFlexModuleFactory):void
    {
        this.moduleFactory = moduleFactory;
    }
    
	//--------------------------------------------------------------------------
	//
	//  Overridden methods
	//
	//--------------------------------------------------------------------------

	/**
 	 *  @private
	 */
	override protected function createChildren():void
	{
		super.createChildren();

		// Create the UITextField to display the message.
		createTextField(-1);

		// Create the icon object, if any.
		var iconClass:Class = AlertPallet(parent).iconClass;
		if (iconClass && !icon)
		{
			icon = new iconClass();
			addChild(icon);
		}

		// Create the button objects

		var alert:AlertPallet = AlertPallet(parent);
		
		var buttonFlags:uint = alert.buttonFlags;
		var defaultButtonFlag:uint = alert.defaultButtonFlag;

		var label:String;
		var button:Button;

		if (buttonFlags & AlertPallet.OK)
		{
			label = String(AlertPallet.okLabel);
			button = createButton(label, "OK");
			if (defaultButtonFlag == AlertPallet.OK)
				defaultButton = button;
		}

		if (buttonFlags & AlertPallet.YES)
		{
			label = String(AlertPallet.yesLabel);
			button = createButton(label, "YES");
			if (defaultButtonFlag == AlertPallet.YES)
				defaultButton = button;
		}

		if (buttonFlags & AlertPallet.NO)
		{
			label = String(AlertPallet.noLabel);
			button = createButton(label, "NO");
			if (defaultButtonFlag == AlertPallet.NO)
				defaultButton = button;
		}

		if (buttonFlags & AlertPallet.CANCEL)
		{
			label = String(AlertPallet.cancelLabel);
			button = createButton(label, "CANCEL");
			if (defaultButtonFlag == AlertPallet.CANCEL)
				defaultButton = button;
		}

		if (!defaultButton && buttons.length)
			defaultButton = buttons[0];

		// Set the default button to have focus.
		if (defaultButton)
		{
			defaultButtonChanged = true;
			invalidateProperties();
		}
	}

	/**
	 *  @private
	 */
	override protected function commitProperties():void
	{
		super.commitProperties();

        // if the font changed and we already created the label, we will need to 
        // destory it so it can be re-created, possibly in a different swf context.
        if (hasFontContextChanged() && textField != null)
        {
        	var index:int = getChildIndex(DisplayObject(textField));
			removeTextField();
			createTextField(index);
        }
 
		if (defaultButtonChanged && defaultButton)
		{
			defaultButtonChanged = false;

			AlertPallet(parent).defaultButton = defaultButton;

			if (parent is IFocusManagerContainer)
			{
				var sm:ISystemManager = AlertPallet(parent).systemManager;
				sm.activate(IFocusManagerContainer(parent));
			}
			defaultButton.setFocus();
		}
	}

	/**
	 *  @private
	 */
	override protected function measure():void
	{
		super.measure();

		// Get the width of the title text
		

		// Calculate the width based solely on the title and the buttons
		var numButtons:int = Math.max(buttons.length, 2);
		var buttonWidth:Number = numButtons * buttons[0].width +
								 (numButtons - 1) * 8;
		
		// Set the textField to word-wrap if the text is more
		// than twice as wide as the buttons and title
		textField.width = 2 * buttonWidth;
		textField.validateNow();
		textWidth = textField.textWidth + UITextField.TEXT_WIDTH_PADDING;

		// Window is wider of buttons or text, but not more than twice as
		// wide as buttons.
		var prefWidth:Number = Math.max(buttonWidth, textWidth);
		//prefWidth = Math.min(prefWidth, 2 * buttonAndTitleWidth);

		// Need this because TextField likes to use multiple lines
		// even for single words.
		if (textWidth < prefWidth && textField.multiline == true)
		{
			textField.multiline = false;
			textField.wordWrap = false;
		}
		else if (textWidth >= prefWidth && textField.multiline == false)
		{
			textField.wordWrap = true;
			textField.multiline = true;
		}

		// Add space for 8-pixel padding along the left/right.
		prefWidth += 16;
		// Add space for icon, if any.
		if (icon)
			prefWidth += icon.width + 8;

		// Make height tall enough for text and icon.
		textField.validateNow();
		textHeight = textField.textHeight + UITextField.TEXT_HEIGHT_PADDING;
		textField.height = textHeight;
		var prefHeight:Number = textHeight;

		if (icon)
			prefHeight = Math.max(prefHeight, icon.height);

		// Limit the height if it exceeds the height of the Stage.
		prefHeight = Math.min(prefHeight, screen.height * 0.75);
		// Add space for buttons, spacing between buttons and text,
		// and top/bottom margins
		prefHeight += buttons[0].height + (3 * 8);

		measuredWidth = prefWidth;
		measuredHeight = prefHeight;
	}

	/**
	 *  @private
	 */
	override protected function updateDisplayList(unscaledWidth:Number,
												  unscaledHeight:Number):void
	{
		super.updateDisplayList(unscaledWidth, unscaledHeight);

		var newX:Number;
		var newY:Number;
		var newWidth:Number;

		// Layout buttons first.
		newY = unscaledHeight - buttons[0].height;
		newWidth = buttons.length * (buttons[0].width + 8) - 8;

		// Center the buttons.
		newX = (unscaledWidth - newWidth) / 2;
		for (var i:int = 0; i < buttons.length; i++)
		{
			buttons[i].move(newX, newY);
			buttons[i].tabIndex = i + 1;
			newX += buttons[i].width + 8;
		}

		// Get the width of the text and icon together.
		newWidth = textWidth;
		if (icon)
			newWidth += icon.width + 8;

		// Center the text and icon horizontally and vertically.
		newX = (unscaledWidth - newWidth) / 2;
		if (icon)
		{
			icon.x = newX;
			icon.y = (newY - icon.height) / 2;
			newX += icon.width + 8;
		}

		var newHeight:Number = textField.getExplicitOrMeasuredHeight();
		textField.move(newX, (newY - newHeight) / 2);
		//textField.setActualSize(textWidth+5, newHeight);
	}

    /**
     *  @private
     */
	override public function styleChanged(styleProp:String):void
	{
		super.styleChanged(styleProp);

		if (!styleProp ||
			styleProp == "styleName" ||
			styleProp == "buttonStyleName")
		{
			if (buttons)
			{
				var buttonStyleName:String = getStyle("buttonStyleName");

				var n:int = buttons.length;
				for (var i:int = 0; i < n; i++)
				{
					buttons[i].styleName = buttonStyleName;
				}
			}
		}
	}

	/**
	 *  @private
	 *  Updates the button labels.
	 */
	override protected function resourcesChanged():void
	{
		super.resourcesChanged();

		var b:Button;
		
		b = Button(getChildByName("OK"));
		if (b)
			b.label = String(AlertPallet.okLabel);
		
		b = Button(getChildByName("CANCEL"));
		if (b)
			b.label = String(AlertPallet.cancelLabel);
		
		b = Button(getChildByName("YES"));
		if (b)
			b.label = String(AlertPallet.yesLabel);
		
		b = Button(getChildByName("NO"));
		if (b)
			b.label = String(AlertPallet.noLabel);
	}

	//--------------------------------------------------------------------------
	//
	//  Methods
	//
	//--------------------------------------------------------------------------

    /**
     *  @private
     *  Creates the title text field child
	 *  and adds it as a child of this component.
     * 
     *  @param childIndex The index of where to add the child.
	 *  If -1, the text field isappended to the end of the list.
     */
    mx_internal function createTextField(childIndex:int):void
    {
        if (!textField)
        {
			textField = IUITextField(createInFontContext(UITextField));

			textField.styleName = this;
			textField.text = AlertPallet(parent).text;
			textField.multiline = true;
			textField.wordWrap = true;
			textField.selectable = true;
			textField.percentWidth = 100;
            if (childIndex == -1)
                addChild(DisplayObject(textField));
            else 
                addChildAt(DisplayObject(textField), childIndex);
        }
    }

    /**
     *  @private
     *  Removes the title text field from this component.
     */
    mx_internal function removeTextField():void
    {
        if (textField)
        {
            removeChild(DisplayObject(textField));
            textField = null;
        }
    }

    /**
     *  @private
     */
	private function createButton(label:String, name:String):Button
	{
		var button:Button = new Button();

		button.label = label;

		// The name is "YES", "NO", "OK", or "CANCEL".
		button.name = name;

		var buttonStyleName:String = getStyle("buttonStyleName");
		if (buttonStyleName)
			button.styleName = buttonStyleName;

		button.addEventListener(MouseEvent.CLICK, clickHandler);
		button.addEventListener(KeyboardEvent.KEY_DOWN, keyDownHandler);
        button.owner = parent;
		addChild(button);

		button.setActualSize(AlertPallet.buttonWidth, AlertPallet.buttonHeight);

		buttons.push(button);

		return button;
	}

    /**
     *  @private
     *  Remove the popup and dispatch Click event corresponding to the Button Pressed.
     */
	private function removeAlert(buttonPressed:String):void
	{
		var alert:AlertPallet = AlertPallet(parent);

		alert.visible = false;

		var closeEvent:AlertCloseEvent = new AlertCloseEvent(AlertCloseEvent.ALERT_CLOSE);
		if (buttonPressed == "YES")
			closeEvent.detail = AlertPallet.YES;
		else if (buttonPressed == "NO")
			closeEvent.detail = AlertPallet.NO;
		else if (buttonPressed == "OK")
			closeEvent.detail = AlertPallet.OK;
		else if (buttonPressed == "CANCEL")
			closeEvent.detail = AlertPallet.CANCEL;
		alert.dispatchEvent(closeEvent);

	}

	//--------------------------------------------------------------------------
	//
	//  Overridden event handlers: UIComponent
	//
	//--------------------------------------------------------------------------

	/**
	 *  @private
	 */
	override protected function keyDownHandler(event:KeyboardEvent):void
	{
		var buttonFlags:uint = AlertPallet(parent).buttonFlags;

		if (event.keyCode == Keyboard.ESCAPE)
		{
			if ((buttonFlags & AlertPallet.CANCEL) || !(buttonFlags & AlertPallet.NO))
				removeAlert("CANCEL");
			else if (buttonFlags & AlertPallet.NO)
				removeAlert("NO");
		}
	}

	//--------------------------------------------------------------------------
	//
	//  Event handlers
	//
	//--------------------------------------------------------------------------

    /**
     *  @private
     *  On a button click, dismiss the popup and send notification.
     */
	private function clickHandler(event:MouseEvent):void
	{
		var name:String = Button(event.currentTarget).name;
		removeAlert(name);
	}
}

}
