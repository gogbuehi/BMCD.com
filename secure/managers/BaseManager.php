<?php
require_once 'includes/handlers/ServiceRequest.php';
require_once 'includes/handlers/ServiceResponse.php';
require_once 'includes/handlers/ErrorResponse.php';
require_once 'exceptions/ServiceException.php';

/**
 * Description of BaseManager
 *
 * @author Goodwin
 */
class BaseManager {
    const PARAM_TYPE_STRING='string';
    const PARAM_TYPE_BOOLEAN='bool';
    const PARAM_TYPE_NUMBER='number';
    const PARAM_VALUE_NULL='!`(-';
    const PARAM_VALUE_TRUE='true';
    const PARAM_VALUE_FALSE='false';

    //const TEST_SERVICE_NAME='TestService';

    public $services = array();
    /**
     * Evaluates if the provided service name is valid for this manager class
     * @param <String> $name
     * @return <boolean>    True, if this manager can handle the service
     *                      requested
     *                      False, otherwise
     */
    function validateService($serviceName) {
        return isset($this->services[$serviceName]);
    }
    function validateParam($paramKeys,$paramName) {
        return isset($paramKeys[$paramName]);
    }

    function getParamKeys($serviceName) {
        if ($this->validateService($serviceName)) {
            return $this->services[$serviceName];
        }
        else {
            $msg = 'Invalid Service: '.$serviceName;
            throw new ServiceException($msg,ServiceException::CODE_INVALID_SERVICE);
        }
    }

    function getParamType($serviceName,$paramName) {
        $paramKeys = $this->getParamKeys($serviceName);
        if ($this->validateParam($paramKeys, $paramName)) {
            return $paramKeys[$paramName];
        }
        else {
            $msg = 'Invalid param: ['.$paramName.']; For service: ['.$serviceName.']; No Type Available';
            throw new ServiceException($msg,ServiceException::CODE_INVALID_PARAMS);
        }
    }
    function processValue($value,$type=self::PARAM_TYPE_STRING,$required = false) {
        if (is_null($value)) {
            if ($required) {
                $msg = 'Required value is NULL';
                throw new ServiceException($msg,ServiceException::CODE_INVALID_PARAM_VALUE);
            }
            else {
                return self::PARAM_VALUE_NULL;
            }
        }
        switch($type) {
            case self::PARAM_TYPE_STRING:
                return strval($value);
                break;
            case self::PARAM_TYPE_NUMBER:
                if (is_numeric($value)) {
                    if (is_float($value)) {
                        return floatval($value);
                    }
                    else if (is_int($value)) {
                        return intval($value);
                    }
                }
                else {
                    $msg = 'Value('.$value.') is exptected to be numeric.';
                    throw new ServiceException($msg,ServiceException::CODE_INVALID_PARAM_VALUE);
                }
                break;
            case self::PARAM_TYPE_BOOLEAN:
                return ($value === self::PARAM_VALUE_TRUE);
                break;
            default:
                $msg = 'Unknown param type: '.$type;
                throw new ServiceException($msg,ServiceException::CODE_INVALID_PARAM_TYPE);
        }
    }
    function processRequest(ServiceRequest $request) {
        $serviceName = $request->getServiceName();
        $paramKeys = $this->getParamKeys($serviceName);
        $paramValues = array();
        foreach ($paramKeys as $paramName => $type) {
            $aValue = $request->getParamValue($paramName);
            $paramValues[$paramName] = $this->processValue($aValue, $type);
        }
        return $this->handleRequest($request,$paramValues);
    }

    function handleRequest(ServiceRequest $request, $params) {
        return new ErrorResponse(
            $request->getServiceName(),
            $request->getType(),
            new ServiceException('BaseManager cannot be used.',ServiceException::CODE_INVALID_CLASS_USAGE)
        );
    }
}
?>