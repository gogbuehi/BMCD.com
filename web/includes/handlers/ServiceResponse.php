<?php
require_once 'includes/config/globals.php';
require_once 'includes/handlers/ServiceRequest.php';
require_once 'exceptions/ServiceException.php';
/**
 * Description of ServiceResponse
 *
 * @author Goodwin
 */
class ServiceResponse extends ServiceRequest {
    protected $name;
    protected $type;
    protected $params;
    function  __construct($name,$type) {
        $this->name = $name;
        $this->type = $type;
        $this->params = array();

        $this->validateType();

        $this->addParam('serviceName', $this->name);
        $this->addParam('type',$this->type);
    }

    function __toString() {
        switch($this->type) {
            case self::SERVICE_XML:
                return $this->serializeXml();
                break;
            //case self::SERVICE_JSON:
            //    return $this->serializeJson();
            //    break;
            //case self::SERVICE_POST:
            //    return $this->serializePost();
            //    break;
            default:
                $msg = 'Cannot serialize params for service type provided: '.$this->type;
                throw new ServiceException($msg,ServiceException::CODE_INVALID_TYPE);
        }
    }

    function serializeXml() {
        $dom = new DOMDocument();
        $root = $dom->createElement('response');
        $root = $dom->appendChild($root);
        $params = $dom->createElement('params');
        $params = $root->appendChild($params);
        foreach ($this->params as $key => $value) {
            $param = $dom->createElement($key);
            if (!self::isNull($value)) {
                $paramText = $dom->createTextNode($value);
                $param->appendChild($paramText);
            }

            $params->appendChild($param);
        }
        $messages = $dom->createElement('messages');
        $messages = $root->appendChild($messages);
        foreach ($this->messages as $key => $value) {
            $message = $dom->createElement($key);
            if (!self::isNull($value)) {
                $messageText = $dom->createTextNode($value);
                $message->appendChild($messageText);
            }

            $messages->appendChild($message);
        }
        //header("content-type: text/xml");
        return $dom->saveXML();
    }
    function serializeJson() {
        $params = $this->getParams($paramsValue);
        return json_encode($this->params);
    }
    function serializePost() {
        //Use ampersands and "="
        $postData = '';
        $ampersand = '';
        foreach ($this->params as $key => $value) {
            $postData.=$ampersand.urlencode($key).'='.urlencode($value);
            $ampersand = '&';
        }
        return $postData;
    }
}
?>
