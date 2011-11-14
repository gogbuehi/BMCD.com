<?php
require_once 'includes/handlers/ServiceResponse.php';
require_once 'exceptions/ServiceException.php';

/**
 * Description of ErrorResponse
 *
 * @author Goodwin
 */
class ErrorResponse extends ServiceResponse {
    protected $serviceException;
    function __construct($name,$type,BaseException $e) {
        parent::__construct($name, $type);
        $this->serviceException = $e;
        $this->addMessage('error', $this->serviceException->__toString());
    }
    /*
    function serializeXml() {
        $dom = new DOMDocument();
        $root = $dom->createElement('response');
        $root = $dom->appendChild($root);
        $params = $dom->createElement('params');
        $params = $root->appendChild($params);

        $params = $dom->createElement('message');
        $params = $root->appendChild($params);
        foreach ($this->params as $key => $value) {
            $param = $dom->createElement($key);
            if (!self::isNull($value)) {
                $paramText = $dom->createTextNode($value);
                $param->appendChild($paramText);
            }

            $params->appendChild($param);
        }
        //header("content-type: text/xml");
        return $dom->saveXML();
    }
    */

}
?>
