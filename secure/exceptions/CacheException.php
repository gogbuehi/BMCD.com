<?php
require_once 'includes/config/globals.php';
require_once 'exceptions/BaseException.php';

/**
 * Description of CacheException
 *
 * @author Goodwin
 */
class CacheException extends BaseException {
    const CODE_DEFAULT=200;
    const CODE_NO_CACHE_RECORD=201;
    const CODE_CACHE_CONTENT_UNCHANGED=202;
    function  __construct($message,$code=self::CODE_DEFAULT) {
        parent::__construct($message, $code);
    }

    function toResponseString() {
        $text = '';
        switch ($this->code) {
            case self::CODE_NO_CACHE_RECORD:
                $text = 'NO_CACHE_RECORD';
                break;
            case self::CODE_CACHE_CONTENT_UNCHANGED:
                $text = 'CACHE_CONTENT_UNCHANGED';
                break;
            default:
                $text = 'DEFAULT';
        }
        return $this->code.':'.$text;
    }
}
?>
