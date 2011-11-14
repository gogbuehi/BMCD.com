<?php
require_once 'includes/config/globals.php';
require_once 'exceptions/ServiceException.php';

/**
 * Description of ServiceRequest
 *
 * A handler for creating or receiving formatted requests
 * Required REQUEST Fields are:
 *  - service
 *      Has the name of the service being requested
 *  - type
 *      Describes the type of request (XML, JSON, POST, etc)
 *  - params
 *      Provides the string of formatted parametes being passed
 *      This is not necessary for type "POST"
 * Examples:
 * XML Request:
 * <request>
 *      <service>getUser</service>
 *      <type>xml</type>
 *      <params>
 *          <sessionKey>bm43r4p9bxql3i8v7h3jkifd9et0oyuv</sessionKey>
 *          <id>25</id>
 *      </params>
 * </request>
 *
 * @author Goodwin
 */
class ServiceRequest {
    const NULL = '~|:|~';
    //Request Field Names
    const SERVICE_NAME='service';
    const SERVICE_TYPE='type';
    const PARAMS = 'params';

    //Request Types
    const SERVICE_XML='xml';
    const SERVICE_JSON='json';
    const SERVICE_POST='post'; //Retrieves "GET" values as well
    
    protected $name;
    protected $type;
    protected $params;

    protected $messages;
    /**
     * The expected parameters for this request
     * Assumes none are expected
     *
     * @var <Array>     An associative array
     *                  Keys are the expected parameter name
     *                  Values are a boolean, indicating whether parameter is required
     */
    protected $expectedParams;
    function __construct($expectedParams = array()) {
        $this->params = array();
        $this->messages = array();
        $this->expectedParams = $expectedParams;

    }

    function receiveRequest() {
        $this->name = self::requestValue(self::SERVICE_NAME);
        $this->validateService();
        $this->type = self::requestValue(self::SERVICE_TYPE);
        $this->validateType();
        $this->retrieveParams(self::requestValue(self::PARAMS));
        $this->validateParams();
    }
    function getServiceName() {
        return $this->name;
    }
    function getType() {
        return $this->type;
    }
    function getParams() {
        return $this->params;
    }
    function getMessages() {
        return $this->messages;
    }
    function getMessageValue($field) {
        if (isset($this->messages[$field])) {
            $value = $this->messages[$field];
            if (self::isNull($value)) {
                return '';
            }
            return $value;
        }
    }
    function getParamValue($field,$required=false) {
        if (isset($this->params[$field])) {
            $value = $this->params[$field];
            if (self::isNull($value)) {
                return null;
            }
            return $value;
        }
        if ($required) {
            $msg = 'Param('.$field.') was not sent with this request.';
            throw new ServiceException($msg,ServiceException::CODE_INVALID_PARAMS);
        }
        return null;
    }

    function addParam($field,$value) {
        $this->params[$field] = is_null($value) ? self::NULL : $value;
    }
    function addMessage($field,$value) {
        $this->messages[$field] = is_null($value) ? self::NULL : $value;
    }
    function addParams($params) {
        foreach($params as $key => $value) {
            $this->addParam($key, $value);
        }
    }
    function validateService() {
        if (self::isNull($this->name)) {
            $msg = 'No service name provided';
            throw new ServiceException($msg,ServiceException::CODE_INVALID_SERVICE);
        }
        return true;
    }
    function validateType() {
        if (self::isNull($this->type)) {
            //Assume the type is "xml" for now
            $this->type = self::SERVICE_XML;
        }
        switch($this->type) {
            case self::SERVICE_XML:
            //case self::SERVICE_JSON:
            //case self::SERVICE_POST:
                return true;
                break;
            default:
                $msg = 'Invalid service type provided: '.$this->type;
                throw new ServiceException($msg,ServiceException::CODE_INVALID_TYPE);
        }
        return true;
    }
    function validateParams() {
        foreach($this->expectedParams as $key => $value) {
            $this->getParamValue($key,$value);
        }
        return true;
    }
    function retrieveParams($paramsValue) {
        $paramsValue = trim($paramsValue);
        $parsedParams = array();
        switch ($this->type) {
            case self::SERVICE_XML:
                $parsedParams = $this->parseXmlParams($paramsValue);
                break;
            case self::SERVICE_JSON:
                $parsedParams = $this->parseJsonParams($paramsValue);
                break;
            case self::SERVICE_POST:
                $parsedParams = $this->parsePostParams($paramsValue);
                break;
            default:
                $msg = 'Cannot retrieve params for service type provided: '.$this->type;
                throw new ServiceException($msg,ServiceException::CODE_INVALID_TYPE);
        }
        foreach($parsedParams as $key => $value) {
            $this->addParam($key, $value);
        }
    }

    function parseXmlParams($params) {
        $xml = new DOMDocument();
        $xml->loadXML($params);
        $xp = new DOMXPath($xml);
        $xPathString = "//request/params/child::*";

        $nodes = $xp->query($xPathString);

        return $this->processNodeListToArray($nodes);
    }
    function parseXmlMessages($messages) {
        $xml = new DOMDocument();
        $xml->loadXML($params);
        $xp = new DOMXPath($xml);
        $xPathString = "//request/messages/child::*";

        $nodes = $xp->query($xPathString);

        return $this->processNodeListToArray($nodes);
    }

    function processNodeListToArray(DOMNodeList $nodes) {
        $numberOfNodes = $nodes->length;
        $paramArray = array();
        for ($i = 0; $i < $numberOfNodes; $i++) {
            $node = $nodes->item($i);
            $nodeName = $node->nodeName;
            if (isset($node->wholeText)) {
                return $node->wholeText;
            }
            if ($node->hasChildNodes()) {
                $paramArray[$nodeName] = $this->processNodeListToArray($node->childNodes);
            }
            else {
                $paramArray[$nodeName] = self::NULL;
            }
        }
        return $paramArray;
    }

    function parseJsonParams($params) {
        return json_decode($params, true);
    }

    function parsePostParams($params) {
        return $_REQUEST;
    }

    static function requestValue($field) {
        if (isset($_REQUEST[$field])) {
            return $_REQUEST[$field];
        }
        return self::NULL;
    }
    static function isNull($value) {
        return (is_null($value) || $value === self::NULL);
    }

    function __toString() {
        $paramString = 'PARAMS[';
        foreach($this->getParams() as $key => $value) {
            $paramString .= "\n".$key.'|'.$value;
        }
        $paramString .= "\n]";
        return '['.get_class($this).'|'.$this->getServiceName().'|'.$this->getType()."]\n".$paramString;
    }
}
?>
