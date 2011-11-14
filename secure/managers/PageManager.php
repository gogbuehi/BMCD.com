<?php
require_once 'managers/BaseManager.php';
require_once 'managers/PermissionManager.php';
require_once 'exceptions/PermissionException.php';
require_once 'caching/CacheManager.php';
require_once 'exceptions/BaseException.php';

/**
 * Description of PageManager
 *
 * @author Goodwin
 */
class PageManager extends BaseManager {
    protected $pm;

    const SAVE_PAGE_SERVICE_NAME='SavePageService';
    const SAVE_PAGE_PARAM_URI='uri';
    const SAVE_PAGE_PARAM_PAGE_CONTENT='pageContent';
    const SAVE_PAGE_PARAM_HAS_DYNAMIC_CONTENT='hasDynamicContent';

    public $services = array(
        self::SAVE_PAGE_SERVICE_NAME => array(
            self::SAVE_PAGE_PARAM_URI => self::PARAM_TYPE_STRING,
            self::SAVE_PAGE_PARAM_PAGE_CONTENT => self::PARAM_TYPE_STRING,
            self::SAVE_PAGE_PARAM_HAS_DYNAMIC_CONTENT => self::PARAM_TYPE_BOOLEAN
        )
    );

    function __construct() {
        $this->pm = new PermissionManager();

    }

    function handleRequest(ServiceRequest $request,$params) {
        $serviceName = $request->getServiceName();
        $response = new ServiceResponse($serviceName,$request->getType());
        switch($serviceName) {
            case self::SAVE_PAGE_SERVICE_NAME:
                return $this->savePage($response,$params);
                break;
            default:
                $msg = 'Unkown Service: '.$serviceName;
                throw new ServiceException($msg,ServiceException::CODE_INVALID_SERVICE);
        }
    }

    function savePage(ServiceResponse &$response,$params) {
        
        try {
            if ($this->pm->requiresAdmin()) {
                $user = $this->pm->getLoggedInUser();
                $cacheManager = new CacheManager();
                $cacheManager->user=$user;
                $msg = $cacheManager->updateCacheFromService($params[self::SAVE_PAGE_PARAM_URI],$params[self::SAVE_PAGE_PARAM_PAGE_CONTENT], $params[self::SAVE_PAGE_PARAM_HAS_DYNAMIC_CONTENT]);
                $response->addMessage('action', $msg);
            }
        }
        catch (BaseException $e) {
            return new ErrorResponse($response->getServiceName(),$response->getType(),$e);
        }
        return $response;
    }
}
?>
