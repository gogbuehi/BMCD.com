<?php
require_once 'includes/config/globals.php';
require_once 'exceptions/BaseException.php';
/**
 * Description of ServiceException
 *
 * @author Goodwin
 */
class ServiceException extends BaseException {
    const CODE_DEFAULT=100;
    const CODE_INVALID_SERVICE=101;
    const CODE_INVALID_TYPE=102;
    const CODE_INVALID_PARAMS=103;
    const CODE_INVALID_PARAM_VALUE=104;
    const CODE_INVALID_PARAM_TYPE=105;
    const CODE_INVALID_CLASS_USAGE=106;
    function  __construct($message,$code=self::CODE_DEFAULT) {
        parent::__construct($message, $code);
    }
    
    function toResponseString() {
        $text = '';
        switch ($this->code) {
            case self::CODE_INVALID_SERVICE:
                $text = 'INVALID_SERVICE';
                break;
            case self::CODE_INVALID_TYPE:
                $text = 'INVALID_TYPE';
                break;
            case self::CODE_INVALID_PARAMS:
                $text = 'INVALID_PARAMS';
                break;
            case self::CODE_INVALID_PARAM_TYPE:
                $text = 'INVALID_PARAM_TYPE';
                break;
            case self::CODE_INVALID_PARAM_VALUE:
                $text = 'INVALID_PARAM_VALUE';
                break;
            case self::CODE_INVALID_CLASS_USAGE:
                $text = 'INVALID_CLASS_USAGE';
                break;
            default:
                $text = 'DEFAULT';
        }
        return $this->code.':'.$text;
    }
}
?>
