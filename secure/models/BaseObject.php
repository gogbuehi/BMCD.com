<?php
require_once 'includes/config/globals.php';

/**
 * Description of BaseObject
 * This is a class just to provide basic services for objects
 * i.e. Class-based logging
 *
 * @author Goodwin Ogbuehi
 */
class BaseObject {
    protected $tLog;
    function __construct() {
        global $tLog;
        $this->tLog = &$tLog;
        $this->tLog->debug("Creating a new BaseObject...");
    }
    function log($msg) {
        return '['.get_class($this).']'.$msg;
    }
    function debug($msg) {
        $this->tLog->debug($this->log($msg));
    }
    function info($msg) {
        $this->tLog->info($this->log($msg));
    }
    function warn($msg) {
        $this->tLog->warn($this->log($msg));
    }
    function error($msg) {
        $this->tLog->error($this->log($msg));
    }
    function fatal($msg) {
        $this->tLog->fatal($this->log($msg));
    }
}
?>