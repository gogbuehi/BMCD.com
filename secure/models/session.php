<?php
require_once 'models/database_object.php';
require_once 'models/user.php';
require_once 'models/page_event.php';
/**
 * Description of session
 *
 * @author Goodwin Ogbuehi
 */
class Session extends DBObject {
    const EXPIRATION_DELAY=86400; //24 hours, in seconds
    public $d_key;
    public $d_expiration;
    public $d_o_user;
    public $d_ip;
    protected $hasExpired;

    function __construct($key=null) {
        if (self::isNull($key)) {
            //Get the session key
            $key = session_id();
        }
        parent::__construct($key,'key');

        if ($this->isPersistent) {
            setcookie('SESSION',$this->d_key);
        }
        /*
        if ($this->isExpired()) {
            //Create a new session
            session_regenerate_id();
        }
         * 
         */
       
    }
    function setDefaultValues($value=null,$field='key') {
        if (self::isNull($value)) {
            $value = session_id();
        }
        $this->tLog->debug("Key/Value = $value");
        parent::setDefaultValues($value, $field);
        if (self::isNull($this->d_expiration)) {
            //Set the expiration of this session to 24 hours from now
            $this->d_expiration = $_SERVER['REQUEST_TIME'] + self::EXPIRATION_DELAY;
        }
        if (self::isNull($this->d_ip)) {
            $this->d_ip = $_SERVER['REMOTE_ADDR'];
        }
    }
    function getId() {
        return array('key'=>$this->d_key);
    }
    
    function loadData($rs) {
        //$this->tLog->debug("RECORD_SET['user']: {$rs['user']}");
        parent::loadData($rs);
        //Change object IDs to object instances
        if (!self::isNull($this->d_o_user) &&(!$this->d_o_user instanceof User )) {
            $this->d_o_user = new User($this->d_o_user);
        }
        
    }
    function isExpired() {
        return ($_SERVER['REQUEST_TIME'] > $this->d_expiration);
    }
    function expireSession() {
        $this->d_expiration = $_SERVER['REQUEST_TIME'];
        $this->save();
    }
    function validateValue($key,$value) {
        switch($key) {
            case 'expiration':
                //Treat this as a Date/Time value
                return parent::validateValue('dt', $value);
                break;
            default:
                return parent::validateValue($key, $value);
        }
    }
    function revertValue($key,$value) {
        switch($key) {
            case 'expiration':
                return $this->convertMysqlDateToTimestamp($value);
                break;
            default:
                return parent::revertValue($key, $value);
        }
    }
    function getRecentEvents($count=-1) {
        $p = new Page_Event(true);
        $pe = $p->get('session', $this->d_key,$count);
        return $pe;
    }

    function getCurrentUser() {
        return $this->d_o_user;
    }

    function setCurrentUser($user=self::NULL) {
        $this->d_o_user = $user;
        $this->save();
    }

    function cleanup() {
        $dt = $_SERVER['REQUEST_TIME'] - (90 * 24 * 60 * 60); //Only keep 3 months worth of Page_Events
        $dt = $this->validateValue('dt', $dt);
        $this->cleanupObjectsByDate($this->getTable(), $dt);
    }
}
?>
