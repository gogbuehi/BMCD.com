<?php
require_once 'includes/config/globals.php';
require_once 'includes/handlers/ServiceRequest.php';
require_once 'models/exceptions/ServiceException.php';
/**
 * Description of ServiceHandler
 *
 * Catches service requests and processes them appropriately
 * 
 * @author Goodwin
 */
class ServiceHandler {
    protected $tLog;

    protected $request;
    protected $response;
    function __construct() {
        global $tLog;
        $this->tLog = $tLog;

        $this->tLog->debug(get_class($this).' initiated...');
        try {
            $this->request = new ServiceRequest();
            $this->request->receiveRequest();
            $this->processRequest();
        }
        catch (ServiceException $e) {
            //Create error response
        }
    }

    function processRequest() {
        
    }

    function sendResponse($params) {
        
    }
}
?>