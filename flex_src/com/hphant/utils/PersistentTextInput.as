package com.hphant.utils {
	
    import flash.events.Event;
    import flash.net.SharedObject;
    import mx.controls.TextInput;
    
    public class PersistentTextInput extends TextInput
    {
        /**
         * The ID this component will use to save and later look up its
         * associated value.
         */
        public var persistenceId:String = null;
        
        /**
         * The SharedObject name to use for storing values.
         */
        private static const LOCAL_STORAGE_NAME:String = "persistentTextInputStorage";
        
        /**
         * Clears previously stored values for all PersistentTextInput instances.
         *
        public static function clearStoredValues() :void
        {
            var so:SharedObject = SharedObject.getLocal(LOCAL_STORAGE_NAME);
            so.clear();
        }
        */
        
        /**
         * Handles initialization of this component.
         */
        override public function initialize() :void
        {
            super.initialize();
            addEventListener(Event.CHANGE, handleChange);
            restoreSavedValue();
        }
        
        /**
         * Event handler function for CHANGE events from this instance.
         */
        protected function handleChange(event:Event) :void
        {
            saveCurrentValue();
        }
        
        /**
         * Restores the previously saved value associated with the
         * persistenceID of with this instance.
         */
        protected function restoreSavedValue() :void
        {
            if (persistenceId != null)
            {
                var so:SharedObject = SharedObject.getLocal(LOCAL_STORAGE_NAME);
                var value:String = so.data[persistenceId];
                if (value != null)
                {
                    text = value;
                }
            }
        }
        
        /**
         * Saves the text value of this instance. Associates the value with
         * the persistenceId of this instance.
         */
        protected function saveCurrentValue() :void
        {
            if (persistenceId != null)
            {
                var so:SharedObject = SharedObject.getLocal(LOCAL_STORAGE_NAME);
                so.data[persistenceId] = text;
                so.flush();
            }
        }
    }
}