<?php
require_once 'models/database_object.php';
require_once 'caching/Page_File.php';

/**
 * Description of Page_Edit
 *
 * @author Goodwin Ogbuehi
 */
class Page_Edit extends DBObject {
    protected $d_o_page_file;
    public $d_has_dynamic_content;
    public $d_domain;
    public $d_o_user;
    /**
     * Generally, this will retrieve the most recent Page_Edit for a Page_File
     * To do this, be sure to pass in the ID of the page_file
     * @param <type> $value The ID of the associated Page_File
     *                      Assumes FALSE, and creates a non-persistent instance
     *                      of Page_Edit
     * @param <type> $key
     */
    function __construct($value=false,$key='page_file') {
        parent::__construct($value,$key);
    }

    function setDefaultValues(Page_File $pf) {
        parent::setDefaultValues();
        $this->d_o_page_file = $pf;
        $this->d_domain = $pf->getDomain();
    }

    function getTimestamp() {
        return $this->dt;
    }

    function validateValue($key,$value) {
        switch($key) {
            case 'has_dynamic_content':
                $key = 'blnvalid';
                break;
        }
        return parent::validateValue($key, $value);
    }
    function revertValue($key,$value) {
        switch($key) {
            case 'has_dynamic_content':
                $key = 'blnvalid';
                break;
        }
        return parent::revertValue($key, $value);
    }

    function toDom(Page $page) {
        $ul = parent::toDom($page);
        //Create Link to page
        //$li = $page->createNode('li');
        //$li->addLink($this->d_uri,$this->d_domain);
        //$li->addMoreText('http://'.$this->d_domain.$this->d_uri);

        //$ul->appendChild($li);

        return $ul;
    }
}
?>
