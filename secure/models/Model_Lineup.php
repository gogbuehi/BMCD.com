<?php
require_once 'models/database_object.php';
/**
 * Description of Model_Lineup
 *
 * @author Goodwin Ogbuehi
 */
class Model_Lineup extends DBObject {
    protected $d_make;
    protected $d_model;
    protected $d_submodel;
    protected $d_descriptions;
    protected $d_videos;
    protected $d_images;
    protected $d_engine;
    protected $d_horsepower;
    protected $d_acceleration_060;
    protected $d_top_speed;
    protected $d_msrp;
    protected $d_brochure;
    protected $d_configurator;
    protected $d_manufacture;
    /**
     * Expects to be passed an array of arguments, otherwise, it will create
     * a non-persistent object
     * @param <type> $value
     * @param <type> $key
     */
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