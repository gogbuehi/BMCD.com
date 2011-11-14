<?php
require_once 'models/database_object.php';

/**
 * Description of email
 *
 * @author Goodwin Ogbuehi
 */
class Email extends DBObject {
    public $d_to='';
    public $d_cc='';
    public $bcc='';
    public $d_from='';
    public $d_subject='';
    public $d_template='';
    public $d_form_data='';
    public $attributes;
    public $d_email_sent=false;
    function __construct($value=null,$field='id') {
        parent::__construct($value, $field);

    }
    function setDefaultValues($value,$field) {
        $this->tLog->debug('Setting Email default values...');
        parent::setDefaultValues($value,$field);
        $this->attributes = array();
        $this->d_email_sent = false;
        $this->d_to = '';
        $this->d_from = '';
        $this->d_subject = '';
        $this->d_template = '';
        $this->d_form_data = '';
    }

    function setAttributes($attributes) {
        $this->attributes = $attributes;
        $this->setFormData();
        //$this->save();
    }

    function setFormData() {
        $attributeString = '';
        $delimiter = '';
        foreach($this->attributes as $key => $value) {
            $attributeString .= $delimiter.$key.'=>'.$value;
            $delimiter = ';;;';
        }
        $this->d_form_data = $attributeString;
    }
    function validateValue($key,$value) {
        switch($key) {
            case 'email_sent':
                $value = ($value === true) ? 1 : 0;
            default:
                $value = "$value";
        }
        return parent::validateValue($key, $value);
    }
    function revertValue($key,$value) {
        switch($key) {
            case 'email_sent':
                return ($value == 1) ? true : false;
                break;
            default:
                return parent::revertValue($key, $value);
        }
    }
}
?>
