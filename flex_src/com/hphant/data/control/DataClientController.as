package com.hphant.data.control
{
	import com.adobe.cairngorm.*;
	import com.adobe.cairngorm.control.FrontController;
	import com.hphant.data.control.command.*;
	import com.hphant.data.control.event.*;


	public class DataClientController extends FrontController {
		
		static private var _instance:DataClientController;
		
		static public function getInstance():DataClientController {
			if(!_instance){
				_instance = new DataClientController();
			}
			return _instance;
		}

		public function DataClientController()
        {
			if ( _instance )
           	{
           		throw new CairngormError( CairngormMessageCodes.SINGLETON_EXCEPTION, "ClientController" );
            }
           	_instance = this;
			initialiseCommands();
        }
        
        
        /**
        *	Registers commands. 	
        */
        public function initialiseCommands() : void
        {
            
            //	Inventory-related commands
            addCommand( InventoryEvent.GET_ALL,		InventoryGetAllCommand );
            addCommand( InventoryEvent.UPDATE,		InventoryUpdateCommand );
            addCommand( InventoryEvent.REMOVE,		InventoryRemoveCommand );
            addCommand( InventoryEvent.GET_BY_ID,	InventoryGetByIDCommand );
            addCommand( InventoryEvent.GET_BY_VIN,	InventoryGetByVINCommand );
            addCommand( InventoryEvent.GET_BY_STOCK,InventoryGetByStockNumberCommand );
            
            //	Store-related commands
            addCommand( StoreEvent.GET_ALL, 	StoreGetAllCommand );
            addCommand( StoreEvent.ADD_NEW, 	StoreAddNewCommand );
            addCommand( StoreEvent.UPDATE, 		StoreUpdateCommand );
            addCommand( StoreEvent.REMOVE, 		StoreRemoveCommand );
            addCommand( StoreEvent.GET_BY_ID,	StoreGetByIDCommand );
            addCommand( StoreEvent.GET_BY_PRODUCT_ID,	StoreGetByProductIDCommand );
            
            //	Model-related commands
            addCommand( ModelEvent.GET_ALL, 	ModelGetAllCommand );
            addCommand( ModelEvent.ADD_NEW, 	ModelAddNewCommand );
            addCommand( ModelEvent.UPDATE, 		ModelUpdateCommand );
            addCommand( ModelEvent.REMOVE, 		ModelRemoveCommand );
            addCommand( ModelEvent.GET_BY_ID,	ModelGetByIDCommand );
            addCommand( ModelEvent.GET_BY_MODEL,	ModelGetByModelCommand );
            
            //	Calendar-related commands
            addCommand( CalendarEvent.GET_ALL, 		CalendarGetAllCommand );
            addCommand( CalendarEvent.ADD_NEW, 		CalendarAddNewCommand );
            addCommand( CalendarEvent.UPDATE, 		CalendarUpdateCommand );
            addCommand( CalendarEvent.REMOVE, 		CalendarRemoveCommand );
            addCommand( CalendarEvent.GET_BY_ID,	CalendarGetByIDCommand );
            addCommand( CalendarEvent.GET_BY_DATE,	CalendarGetByDateCommand );
            
            //	Suggestions-related commands
            addCommand( SuggestionsEvent.GET_ALL, 		SuggestionGetAllCommand );
            addCommand( SuggestionsEvent.ADD_NEW, 		SuggestionAddNewCommand );
            addCommand( SuggestionsEvent.UPDATE, 		SuggestionUpdateCommand );
            addCommand( SuggestionsEvent.REMOVE, 		SuggestionRemoveCommand );
            addCommand( SuggestionsEvent.GET_BY_ID,		SuggestionGetByIDCommand );
            
            //	Suggestions-related commands
            addCommand( NameReferenceEvent.GET_ALL, 	NameReferenceGetAllCommand );
            addCommand( NameReferenceEvent.ADD_NEW, 	NameReferenceAddNewCommand );
            addCommand( NameReferenceEvent.UPDATE, 		NameReferenceUpdateCommand );
            addCommand( NameReferenceEvent.REMOVE, 		NameReferenceRemoveCommand );
            addCommand( NameReferenceEvent.GET_BY_ID,	NameReferenceGetByIDCommand );
            
            //	DataFilter-related commands
            addCommand( DataFilterEvent.GET_ALL, 		DataFilterGetAllCommand );
            addCommand( DataFilterEvent.ADD_NEW, 		DataFilterAddNewCommand );
            addCommand( DataFilterEvent.UPDATE, 		DataFilterUpdateCommand );
            addCommand( DataFilterEvent.REMOVE, 		DataFilterRemoveCommand );
            addCommand( DataFilterEvent.GET_BY_ID,		DataFilterGetByIDCommand );
            
       }
		
	}
}