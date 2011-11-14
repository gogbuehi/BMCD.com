<?php
require_once 'models/BaseObject.php';

/**
 * Description of Persistent_Object
 *
 * @author Goodwin Ogbuehi
 */
class Persistent_Object extends BaseObject {
    const NULL='~__~';
    protected $d_id;
    protected $d_dt;

    function __construct() {
        parent::__construct();

    }
    /**
     * Get an array of all the available fields
     * @return <Array>  An array with a reference to all member variables that
     *                  are meant to be persisted in the database.
     */
    function getFields() {
        $allVars = get_object_vars($this);
        foreach ($this as $key => $value) {
            if (preg_match("/^d_/", $key)) {
                //This is a database field variable

                if (preg_match("/^d_o_/",$key)) {
                    /**
                     * This is a member variable that represents another
                     * persistent object.
                     */

                }
            }
        }
        return null;
    }

}
?>
