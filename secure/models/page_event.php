<?php
require_once 'models/database_object.php';
require_once 'models/session.php';
/**
 * Description of page_event
 *
 * @author Goodwin Ogbuehi
 */
class Page_Event extends DBObject {
    public $d_o_session;
    public $d_uri;
    public $d_domain;
    public $d_status;

    function __construct($value=null) {
        if ($value!==true) {
            //Not static means make a regular object
            parent::__construct($value);
        }
        else {
            parent::__construct(false);
        }
    }

    function setStatus($value) {
        $this->d_status = $value;
        $this->save();
    }

    function setDefaultValues() {
        parent::setDefaultValues();
        $this->d_o_session = session_id();
        $this->d_uri = $_SERVER['REQUEST_URI'];
        $this->d_domain = $_SERVER['SERVER_NAME'];
        $this->d_status = 200;
    }

    function loadData($rs) {
        parent::loadData($rs);
        if ($this->isPersistent) {
            //Get complete session object
            if (!self::isNull($this->d_o_session) && !($this->d_o_session instanceof Session)) {
                $this->d_o_session = new Session($this->d_o_session);
            }
            else {
                if (self::isNull($this->d_o_session)) {
                    $this->tLog->info('Session is null for this page event');
                }
            }
        }
    }
    static function getInstance() {
        
    }
    function __toString() {
        $fields = $this->getFields();
        return $this->validateValue('dt',$fields['dt']).
            ': http://'.
            $fields['domain'].
            $fields['uri']."<br />\n";
    }

    function cleanup() {
        $dt = $_SERVER['REQUEST_TIME'] - (30 * 24 * 60 * 60); //Only keep a month's worth of Page_Events
        $dt = $this->validateValue('dt', $dt);
        $this->cleanupObjectsByDate($this->getTable(), $dt);
    }

    
}
?>
