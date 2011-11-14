<?php
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of PermissionException
 *
 * @author Goodwin
 */
class PermissionException extends BaseException {
    const CODE_DEFAULT=300;
    const CODE_UNKNOWN_USER=301;
    const CODE_INCORRECT_PASSWORD=302;
    const CODE_PERMISSION_DENIED=303;
    const CODE_PASSWORD_CHANGE_ERROR=304;
    function  __construct($message,$code=self::CODE_DEFAULT) {
        parent::__construct($message, $code);
    }
    function toResponseString() {
        $text = '';
        switch ($this->code) {
            case self::CODE_UNKNOWN_USER:
                $text = 'UNKNOWN_USER';
                break;
            case self::CODE_INCORRECT_PASSWORD:
                $text = 'INCORECT_PASSWORD';
                break;
            case self::CODE_PERMISSION_DENIED:
                $text = 'PERMISSION_DENIED';
                break;
            case self::CODE_PASSWORD_CHANGE_ERROR:
                $text = 'PASSWORD_CHANGE_ERROR';
                break;
            default:
                $text = 'DEFAULT';
        }
        return $this->code.':'.$text;
    }
}
?>
