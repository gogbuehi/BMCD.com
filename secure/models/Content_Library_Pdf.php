<?php
require_once 'models/database_object.php';
require_once 'includes/amfphp/services/vo/PDF.php';

/**
 * Description of Content_Library_Pdf
 *
 * @author Goodwin
 */
class Content_Library_Pdf extends DBObject {
    public $d_location; //The file location of the PDF
	public $d_title; //A.K.A. "title"
    public $d_blnvalid;

    public $d_domain;

    function __construct($value=null,$field='id') {
        if ($value instanceof PDF) {
            parent::__construct(false);
            $this->loadDataFromAmfPhp($value);
        }
        else {
            parent::__construct($value, $field);
        }
        if ($value !== FALSE) {
            $this->save();
        }

    }

    function setDefaultValues($value,$field) {
        $this->tLog->debug('Setting '.$this->getTable().' default values...');
        parent::setDefaultValues($value,$field);
        $this->d_location = '';
        $this->d_title = '';
        $this->d_blnvalid = true;
        $this->d_domain = $_SERVER['SERVER_NAME'];
    }

    function revertValue($key,$value) {
        switch($key) {
            case 'id':
                if ($value === -1 || $value === 0) {
                    return self::NULL;
                }
                else {
                    return parent::revertValue($key, $value);
                }
                break;
            
            default:
                return parent::revertValue($key, $value);
        }
    }
    function loadDataFromAmfPhp(PDF $pdf) {
        $transientData = $pdf->getFields();
        $transientData = self::cleanupTransientData($transientData);
        $this->loadData($transientData);
        $this->d_domain = $_SERVER['SERVER_NAME'];
    }

    function getAmfPhpInstance() {
        $data = $this->getFields();
        $pdf = new PDF();
        $pdf->loadData($data);
        return $pdf;
    }
}
?>
