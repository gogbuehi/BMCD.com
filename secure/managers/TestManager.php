<?php
require_once 'managers/BaseManager.php';

/**
 * Description of TestManager
 *
 * @author Goodwin
 */
class TestManager extends BaseManager {

    const TEST_SERVICE_NAME='TestService';

    public $services = array(
        self::TEST_SERVICE_NAME => array(
            'param1' => self::PARAM_TYPE_STRING,
            'param2' => self::PARAM_TYPE_STRING
        )
    );

    function handleRequest(ServiceRequest $request,$params) {
        $serviceName = $request->getServiceName();
        $response = new ServiceResponse($serviceName,$request->getType());
        switch($serviceName) {
            case self::TEST_SERVICE_NAME:
                return $response;
                break;
            default:
                $msg = 'Unkown Service: '.$serviceName;
                throw new ServiceException($msg,ServiceException::CODE_INVALID_SERVICE);
        }
    }
}
?>