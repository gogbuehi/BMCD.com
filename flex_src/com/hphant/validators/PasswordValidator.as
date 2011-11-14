package com.hphant.validators
{
	import mx.validators.IValidatorListener;
	import mx.validators.StringValidator;
	import mx.validators.ValidationResult;

	public class PasswordValidator extends StringValidator
	{
		public function PasswordValidator()
		{
			super();
			this.subFields = ["password","confirmPassword"];
		}
		
	
	private var _noMatchError:String;
	private var noMatchErrorOverride:String;
	
    [Inspectable(category="Errors", defaultValue="null")]
	public function get noMatchError():String 
	{
		return _noMatchError;
	}
	
	public function set noMatchError(value:String):void
    {
        noMatchErrorOverride = value;
		_noMatchError = value != null ?
						value : "The New Password and the Confirmation Password do not match.";
    }
	public static function validatePassword(validator:PasswordValidator,
											  value:Object,
											  baseField:String=null):Array
	{
		var password:String;
		var confirmPassword:String;
		try{
			password = String(value.password);
		}catch (e:Error){
			throw new Error("Missing password");
		}
		try{
			confirmPassword = String(value.confirmPassword);
		}catch (f:Error){
			throw new Error("Missing confirmPassword");
		}
		
		var results:Array = StringValidator.validateString(validator,password,baseField);
		if (results.length==0 && password != confirmPassword){
			results.push(new ValidationResult(
				true, baseField, "noMatch", validator.noMatchError));
			return results;
		}
		return results;
	}
	
	[Inspectable(category="General")]
	public var passwordProperty:String;
	private var _passwordSource:Object;
	
    [Inspectable(category="General")]
	public function get passwordSource():Object
	{
		return _passwordSource;
	}
	public function set passwordSource(value:Object):void
	{
		if (_passwordSource == value)
			return;
		if (value is String)
		{
			var message:String = resourceManager.getString(
				"validators", "CNSAttribute", [ value ]);
			throw new Error(message);
		}
		removeListenerHandler();	
		_passwordSource = value;
		addListenerHandler();
	}
	private var _passordListener:IValidatorListener;
	
    [Inspectable(category="General")]
	public function get passordListener():IValidatorListener
	{
		return _passordListener;
	}
	public function set passordListener(value:IValidatorListener):void
	{
		if (_passordListener == value)
			return;
		removeListenerHandler();
		_passordListener = value;
		addListenerHandler();
	}
	
	
	
	[Inspectable(category="General")]
	public var confirmPasswordProperty:String;
	private var _confirmPasswordSource:Object;
	
    [Inspectable(category="General")]
	public function get confirmPasswordSource():Object
	{
		return _confirmPasswordSource;
	}
	public function set confirmPasswordSource(value:Object):void
	{
		if (_confirmPasswordSource == value)
			return;
		if (value is String)
		{
			var message:String = resourceManager.getString(
				"validators", "CNSAttribute", [ value ]);
			throw new Error(message);
		}
		removeListenerHandler();	
		_confirmPasswordSource = value;
		addListenerHandler();
	}
	private var _confirmPasswordListener:IValidatorListener;
	
    [Inspectable(category="General")]
	public function get confirmPasswordListener():IValidatorListener
	{
		return _confirmPasswordListener;
	}
	public function set confirmPasswordListener(value:IValidatorListener):void
	{
		if (_confirmPasswordListener == value)
			return;
		removeListenerHandler();
		_confirmPasswordListener = value;
		addListenerHandler();
	}
	
	override protected function doValidation(value:Object):Array
    {
		var results:Array = super.doValidation(value);
		var val:String = value ? String(value) : "";
		if (results.length > 0 || ((val.length == 0) && !required))
			return results;
		else
		    return PasswordValidator.validatePassword(this, value, null);
    }
    override protected function getValueFromSource():Object
	{
		var useValue:Boolean = false;
		var value:Object = {};
		if (passwordSource && passwordProperty)
		{
			value.password = passwordSource[passwordProperty];
			useValue = true;
		}
		if (confirmPasswordSource && confirmPasswordProperty)
		{
			value.confirmPassword = confirmPasswordSource[confirmPasswordProperty];
			useValue = true;
		}
		if (useValue)
			return value;
		else
			return super.getValueFromSource();
	}
	}
}