<?php
require_once 'includes/config/globals.php';
require_once 'includes/handlers/ServiceRequest.php';
require_once 'includes/handlers/ServiceResponse.php';
require_once 'includes/handlers/ErrorResponse.php';

require_once 'managers/BaseManager.php';
require_once 'managers/TestManager.php';
require_once 'managers/PageManager.php';
require_once 'managers/PermissionManager.php';
/**
 * Description of ServicePage
 *
 * @author Goodwin
 */
class ServicePage {
    const TEST_MANAGER='testManager';
    const PAGE_MANAGER='pageManager';
    const PERMISSION_MANAGER='permissionManager';
    protected $tLog;

    protected $request;
    protected $response;

    protected $testManager;
    protected $pageManager;
    protected $permissionManager;

    protected $managers;
    function __construct() {
        global $tLog;
        $this->tLog = $tLog;
        
        $this->managers[self::PAGE_MANAGER] = new PageManager();
        $this->managers[self::PERMISSION_MANAGER] = new PermissionManager();
        $this->managers[self::TEST_MANAGER] = new TestManager();

        $this->request = new ServiceRequest();
        try {
            $this->request->receiveRequest();
            //Need a manager to decide what to do with the request
            //The manager will determine what params will go into the response
            $this->logRequest();
            $this->response = $this->handleRequest();
        }
        catch (ServiceException $e) {
            $this->response = new ErrorResponse($this->request->getServiceName(),$this->request->getType(),$e);
        }
        $this->echoResponse();
    }

    function logRequest() {
        $this->tLog->debug('Logging Request...');
        foreach ($_REQUEST as $key => $value) {
            $this->tLog->debug('['.$key.'] => ['.$value.']');
        }
        $this->tLog->debug("$this->request");
    }

    function handleRequest() {
        foreach ($this->managers as $key => $manager) {
            if ($manager->validateService($this->request->getServiceName())) {
                return $manager->processRequest($this->request);
            }
        }
        return $manager->processRequest($this->request);
    }

    function echoResponse() {
        
        header("content-type: text/xml");
        echo "$this->response";
    }
}
new ServicePage();
?>