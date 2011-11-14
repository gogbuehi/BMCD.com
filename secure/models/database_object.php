<?php
require_once 'includes/config/globals.php';
require_once 'includes/services/sql_services.php';

require_once 'includes/models/page/page.php';
/**
 * Description of database_object
 *
 * @author Goodwin Ogbuehi
 */
class DBObject extends SqlServices {
    const NULL='~ooNULL,~; ]\'';
    /**
     * Logger for this object
     * @var <Log> 
     */
    protected $tLog;
    /**
     * Flag that indicates whether current object
     * has a corresponding record in the database
     * @var <boolean> 
     */
    public $isPersistent;
    /**
     * The ID for te persistent record of this object
     * Default is NULL
     * @var <int>
     */
    public $id;
    protected $dt;
    /**
     * Creates a new instance of or
     * retrieves an instance of a database
     * record
     * @global <Log> $tLog
     * @param <mixed> $value    A value to look-up a record by,
     *                          If null, creates a non-persistent instance
     *                          Otherwise, attempts to instantiate  based
     *                          on the provided value
     * @param <String> $field   The field to look-up a record by
     *                          Assumes look-up value is compared against the
     *                          `id` field
     *                          Otherwise, looks up based on the provided
     *                          String. If the field contains non-unique
     *                          values, then the first record will be
     *                          instantiated.
     */
    function __construct($value=null,$field='id') {
        parent::__construct();
        if ($value === false) {
            $this->isPersistent = false;
            $this->setBlankValues();
        }
        else {
            if (is_array($value)) {
                $this->id = self::NULL;
                $this->dt = self::NULL;
                //$this->setBlankValues();
                //$this->tLog->debug('Loading array data: '.json_encode($value));
                $this->loadData($value);
                //$this->save();
            }
            else {
                //$this->tLog->debug('Looking up '.$this->getTable().' by field('.$field.') = value('.$value.')');
                $this->id=self::NULL;
                $this->dt=self::NULL;
                if (!self::isNull($value)) {
                    //Attempt to instantiate this object based on a record look-up
                    $this->loadObjectByField($this->getTable(), $field, $value, $this);
                }
                else {
                    $this->isPersistent = false;
                }
                if (!$this->isPersistent) {
                    //Decide what to do
                    $this->setDefaultValues($value, $field);
                    $this->save();
                }
            }
        }
    }

    function setDefaultValues($value=null,$field='id') {
        $fields = $this->getFields();
        $fields['id'] = self::NULL;
        $fields['dt'] = $_SERVER['REQUEST_TIME'];
        if (!is_null($value)) {
            $fields[$field] = $value;
        }

        $this->isPersistent = false;
    }
    function setBlankValues() {
        //$this->tLog->debug('Setting blank values for '.$this->getTable());
        $this->id = self::NULL;
        $this->dt= $_SERVER['REQUEST_TIME'];
        $fields = $this->getFields();
    }
    /**
     *  The table that corresponds to this type of DBObject
     * @return <String> The table that corresponds to a DBObject should
     *                  have the same name as the DBObject's class name
     */
    function getTable() {
        return strtolower(get_class($this));
    }

    function getId() {
        return array('id'=>$this->id);
    }

    function getIdValue() {
        return $this->id;
    }
    /**
     * A function to prepare the object for insertion
     * or updating of its database representation.
     * @return <array>  An associative array of field/value pairs that
     *                  correspond to this object's database table structure
     *                  Note: This is an empty array, if this object does not
     *                  have any fields to associate in the database
     */
    function &getFields() {
        $dbFieldsAndValues = array();
        //Make sure this includes a reference to the object's ID
        $dbFieldsAndValues['id']=&$this->id;
        $dbFieldsAndValues['dt']=&$this->dt;
        foreach ($this as $key => &$value) {
            /**
             * If variable name starts with ("d_") in it,
             * then it is meant to be used as a database field.
             * If the member variable is of type DatabaseObject,
             * then the "->getId()" value is used to populate the
             * value in the database, and the field name uses the
             * following formula:
             *  - [VARIABLE CLASS]_id
             */
            if (preg_match("/^d_/", $key)) {
                if (is_null($value)) {
                    //$this->tLog->info('The value of '.$key.' is null.');
                    $e='$this->'.$key.'=self::NULL;';
                    //$this->tLog->info("Evaluating: $e");
                    eval($e);
                }
                //This is a database field
                if (preg_match("/^d_o_/",$key)) {
                    $dbField = str_replace('d_o_', '', $key);
                    if (($value instanceof DBObject)) {
                        //Use "getId()" identifier from this Database object
                            $identifier = $value->getId();
                            $dbValue = current($identifier);
                            $dbFieldsAndValues[$dbField] = $dbValue;
                            //eval('$dbFieldsAndValues[$dbField] = &this->'.$key);
                    }
                    else if (!self::isNull($value)) {
                        //Assume it is just an identifier value
                        $dbFieldsAndValues[$dbField] = $value;
                    }
                    else {
                        $e = '$dbFieldsAndValues[\''.$dbField.'\'] = &$this->'.$key.';';
                        eval($e);
                    }
                }
                else {
                        //Assume value can be directly input into the database
                        $dbField = str_replace('d_','',$key);
                        $e = '$dbFieldsAndValues[\''.$dbField.'\'] = &$this->'.$key.';';
                        eval($e);
                        //$this->tLog->debug($key.' value: '.$value);
                    //$dbFieldsAndValues[$dbField] = &eval('return $this->'.$key);
                }
            }
            else {
                //This is not a database field... skip
            }
        }
        return $dbFieldsAndValues;
    }
    /**
     * Updates or creates a persistent instances of this object in the database
     */
    function save() {
        //$this->tLog->debug('Attempting to save '.$this->getTable().' to the DB.');
        if ($this->isPersistent) {
            //Do an update on the database
            
            $this->updateObjectByField($this->getTable(), $this, 'id');
        }
        else {
            //$this->id = $this->insert($this->insertStatement($this->getTable(), $this->getFields()));
            $this->id = $this->createObjectRecord($this->getTable(), $this);
            if ($this->id === false) {
                //Insertion failed
                $this->id = null;
                $this->isPersistent = false;
                $this->tLog->warn('There was an issue trying to create an instance of '.$this);
            }
            else {
                //$this->tLog->debug($this.' is now persistent.');
                $this->isPersistent = true;
            }
        }
    }

    /**
     * Inserts the values from a database recordset into the member variables
     * of this object, to make this object match its persistent data
     * @param <array> $rs   The associative array that represents a record
     *                      in this object's corresponding database table;
     *                      Or, if false, loads no data, as no record was
     *                      retrieved
     */
    function loadData($rs) {
        //$this->tLog->debug('Loading data from '.$this->getTable());
        $loadedData = false;
        if ($rs === false) {
            $loadedData = false;
            $this->tLog->info('There is no record data for this '.get_class($this));
            $this->id = self::NULL;
        }
        else {

            $varArray = &$this->getFields();
            $varArray['id'] = &$this->id;
            $varArray['dt'] = &$this->dt;
            foreach($rs as $key => $value) {
                $rKey = $this->revertKey($key);
                if (isset($varArray[$rKey])) {
                    $varArray[$rKey] = $this->revertValue($key, $value);
                }
                else {
                    $this->tLog->info("Unset field for object array: $rKey => $value");
                }
            }
            $loadedData = true;
        }
        $this->isPersistent = !self::isNull($this->id);
        return $loadedData;
    }
    /**
     * Retrieves a set of object instances from the database, based on a single
     * database field
     * Note: This should be static, but isn't because of the way these classes
     * are inheriting functionality
     * @param <String> $field   The field to match against
     * @param <mixed> $value    The value to match against
     * @param <int> $count      The count of records to limit the results to
     * @return <array:DBObject> An array of DBObjects that correspond to the
     *                          queried database recordset
     */
     function get($field,$value,$count=null) {
        $resultSet = $this->loadObjectsByField($this->getTable(), $field, $value, $this,$count);
        //$this->tLog->info(get_class($this)." count is: ".count($resultSet));
        return $resultSet;
    }

    function getComplex($fieldsAndValues,$count=null) {
        $resultSet = $this->loadObjectsByFields($this->getTable(), $fieldsAndValues, $this, $count);
        return $resultSet;
    }
    /**
     * Takes a non-persistent object and tries to fill it with the rest of it's
     * persistent values.
     */
    function match() {
        try {
            if ($this->isPersistent) {
                //just return true, since this is already a matched object
                //$this->tLog->info("$this IS PERSISTENT and does not need to be Matched.");
                return true;
            }
            return $this->loadObjectMatch($this->getTable(), $this);
        }
        catch (Exception $e) {
            return false;
        }
    }
    function validateValue($key,$value) {
        if (self::isNull($value)) {
            $value = null;
        }
        $result = parent::validateValue($key, $value);
        return $result;
    }
    static function isNull($value) {
        $t1 = ($value === self::NULL);
        $t2 = is_null($value);
        $ta = ($t1 || $t2);
        return ($ta);
    }
    function getAnchorName() {
        return get_class($this).'_'.$this->id;
    }
    function __toString() {
        $dbFieldsAndValues = $this->getFields();
        $stringOutput = $this->getTable()."{\n";
        foreach($dbFieldsAndValues as $key => $value) {
            $stringOutput .= '`'.$key.'` : '.$this->validateValue($key, $value)."\n";
        }
        $stringOutput .= '}';
        return $stringOutput;
    }

    function toDom(Page $page) {
        $ul = $page->createNode('ul');
        $ul->setClass(get_class($this));

        $li = $page->createNode('li');
        $li->setClass('object_class');
        $anchorName = $this->getAnchorName();
        $li->addAnchor(get_class($this),$anchorName);
        //$li->addText(get_class($this),'b');
        $ul->appendChild($li);

        $dbFieldsAndValues = $this->getFields();
        foreach($dbFieldsAndValues as $key => $value) {
            $li = $page->createNode('li');
            $li->addText($key,'b');
            $li->addText(': ');
            $li->addText($this->validateValue($key, $value));
            $ul->appendChild($li);
        }
        
        return $ul;
    }

    function delete() {
        $this->removeObjectRecord($this->getTable(), $this);
    }

    static function cleanupTransientData($transientData) {
        foreach ($transientData as $key => $value) {
            if (is_string($value)) {
                $transientData[$key] = self::stripBackslashes($value);
            }
        }
        return $transientData;
    }

    static function stripBackslashes($value) {
        $searchArray = array(
            "\\/",
            "\\'",
            "\\\""
        );
        $replaceArray = array(
            '/',
            '\'',
            '"'
        );
        return str_replace($searchArray, $replaceArray, $value);
    }
}
?>
