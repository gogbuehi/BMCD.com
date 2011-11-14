<?php
require_once 'models/database_object.php';

/**
 * Description of Page_Dynamic
 *
 * @author Goodwin Ogbuehi
 */
class Page_Dynamic extends DBObject {
    protected $d_o_page_file;
    protected $d_o_page_edit;

    function __construct($value=false) {
        parent::__construct($value);
        if ($this->match()) {
            $this->isPersistent = true;
            $fields = $this->getFields();
            //$this->tLog->info("A match was found for $this. blnvalid value is: ".self::getBooleanValue($this->d_blnvalid).
            //' and the field value of blnvalid is: '.self::getBooleanValue($fields['blnvalid']));
        }
        else {
            $this->isPersistent = false;
            $this->tLog->info("A match was not found for $this. An entry needs to be created in the DB.");
        }
    }
}
?>
