<?php
/**
 *
 * @author Goodwin
 */
abstract class BaseException extends Exception {
    function __toString() {
        return get_class($this).': ['.$this->code.']: '.$this->message."\n";
    }
    abstract function toResponseString();
}
?>
