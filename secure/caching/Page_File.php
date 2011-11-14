<?php
require_once 'models/database_object.php';

/**
 * Description of Page_File
 *
 * @author Goodwin Ogbuehi
 */
class Page_File extends DBObject {
    protected $d_domain;
    protected $d_uri;
    protected $d_page_name;
    protected $d_blnvalid;
    protected $d_use_decendent_uri;
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
            //Try to find ascendent page_file
            $ascendent = $this->getAscendentPageFile();
            if (!is_null($ascendent)) {
                $this->loadData($ascendent->getFields());
                //$this->tLog->debug("An ascendent was found for $this.");
            }
            else {
                $this->isPersistent = false;
                $this->tLog->info("A match was not found for $this. An entry needs to be created in the DB.");
            }
        }
    }
    function getId() {
        return array(
            'page_name'=>$this->d_page_name,
            'domain'=>$this->d_domain
        );
    }
    function getUri() {
        return $this->d_uri;
    }
    function getDomain() {
        return $this->d_domain;
    }

    function setDefaultValues() {
        $this->getId();
        $this->getFields();
        $this->d_domain = $_SERVER['SERVER_NAME'];
        $this->d_uri = $_SERVER['REQUEST_URI'];
        $this->d_blnvalid = false;
        $this->d_use_decendent_uri = false;
        parent::setDefaultValues();
    }

    function getAscendentPageFile($uri=null) {
        require_once 'includes/utils/url_manager.php';
        $pageUrl = new UrlManager($uri);
        $fieldsAndValues = array(
            'use_decendent_uri' => 1,
            'domain' => $_SERVER['SERVER_NAME']
        );
        //$ascendentPageFiles = $this->get('use_decendent_uri', 1);
        $ascendentPageFiles = $this->getComplex($fieldsAndValues);
        foreach ($ascendentPageFiles as $key => $value) {
            $ascendentUrl = new UrlManager($value->getUri());
            if ($pageUrl->isDecendentUrl($ascendentUrl)) {
                return $value;
            }
        }
        return null;
    }

    function getName() {
        return $this->d_page_name;
    }

    function validateValue($key,$value) {
        switch($key) {
            case 'use_decendent_uri':
                $key = 'blnvalid';
                break;
        }
        return parent::validateValue($key, $value);
    }

    function revertValue($key,$value) {
        switch($key) {
            case 'use_decendent_uri':
                $key = 'blnvalid';
                break;
        }
        return parent::revertValue($key, $value);
    }

    public static function setArgs($domain=null,$uri=null,$page_name=null) {
        if (is_null($uri)) {
            $uriArray =  explode("?",$_SERVER['REQUEST_URI']);
            $uri = $uriArray[0];
        }
        $args = array(
            'domain' => is_null($domain) ? $_SERVER['SERVER_NAME'] : $domain,
            'uri' => $uri,
            'page_name' => is_null($page_name) ? self::NULL : $page_name
         );

         return $args;
    }

    function toDom(Page $page) {
        $ul = parent::toDom($page);
        //Create Link to page
        $li = $page->createNode('li');
        $li->setClass('link');
        $li->addLink($this->d_uri,$this->d_domain);
        $li->addMoreText('http://'.$this->d_domain.$this->d_uri);
        $li->setMoreAttribute('target','_blank');

        $ul->appendChild($li);

        return $ul;
    }
}
?>