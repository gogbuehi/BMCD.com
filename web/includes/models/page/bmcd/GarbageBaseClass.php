<?php
require_once 'includes/models/page/page.php';
require_once 'includes/models/page/bmcd/header_node.php';
//TODO: Get "HeaderNode" class out of "bmcd" directory

/**
 * Description of GarbageBaseClass
 *
 * A base class to determine what should go into the real
 * BaseSitePage class
 *
 * @author goodwin
 */
class GarbageBaseClass extends Page {
    //Legit Member Variables
    //protected $title; //In Page Class
    protected $subtitle;
    protected $header;
    protected $footer;
    protected $menu;

    //Helper Member Variables (may eventually get refactored out of this class)
    protected $url;
    protected $scripts;
    protected $styles;

    //Legacy Member Variables
    protected $headerNode;
    protected $footerNode;
    protected $floorCount = 0;
    const FLOOR_IDENTIFIER = 'floor_';
    const SITE_TITLE = 'New Site';

    const SITE_PHONE_NUMBER='';
    const SITE_ADDRESS='';
    const SITE_CITY_STATE_ZIP='';
    /*
    function __construct($subtitle=null,$url=null) {
        parent::__construct();
        //$requestUriArray = explode("?",$_SERVER['REQUEST_URI']);
        //$this->url = (is_null($url) ? $requestUriArray[0] : $url);
        $this->makeHeadNodeContent();
        $this->makeHeader($subtitle);
        if (!is_null($subtitle) && $subtitle !== '') {
            $this->pTitle->appendContent(" - $subtitle");
        }
        $this->setSelectedMenuItem();
        $this->makeFooter();
    }
    */
    function __construct() {
        parent::__construct();
        $this->determineUrl();
        $this->pageScripts();
        $this->pageStyles();
        $this->setTitle(self::SITE_TITLE);
        $this->bodyHeader();
        $this->bodyFooter();
    }
    /**
     * Ensures the class has an available URL to work with
     * if a URL has not already been set for the class
     */
    function determineUrl() {
        if (is_null($this->url) || !isset($this->url)) {
            $tempUrl = explode('?',$_SERVER['REQUEST_URI']);
            $this->url = $tempUrl[0];
        }
    }

    function pageScripts() {
        $this->addPageScript($this->jsGlobals());
        $this->addLinkScript('/scripts/jquery-1.2.6.lined.js');
        $this->addLinkScript('/scripts/ObjTree.js');
        $this->addLinkScript('/scripts/ServiceHandler.js');
        $this->addLinkScript('/scripts/BrowserManager.js');
        $this->addLinkScript('/js/url_manager.js');
    }
    function pageStyles() {
        $this->addLinkStyle('/styles/style.css');
    }
    function addPageScript($scriptString) {
        $this->addScript(ScriptNode::PAGE_SCRIPT, $scriptString);
    }
    function addLinkScript($link,$host=HOST) {
        $this->addScript(ScriptNode::SRC_LINK,'http://'.$host.$link);
    }
    function addPageStyle($styleString) {
        $this->addStyle(StyleNode::PAGE_STYLE, $styleString);
    }
    function addLinkStyle($link,$host=HOST) {
        $this->addStyle(StyleNode::SRC_LINK, $link);
    }

    function bodyHeader() {
        $this->header = new HeaderNode($this->doc,'ModHeader');
        $this->header->setUrl($this->url); //This is just to manage the Menu
        $this->header->addLogo('Logo','/','/noimage','Alternate Text'); //Primary Logo
        $this->header->addLogo('Logo','/','/noimage','Alternate Text'); //Secondary logo
        $this->header->addLogo('Logo','/','/noimage','Alternate Text'); //Tertiary logo
        $this->header->addTitle(self::SITE_TITLE);
        if (!is_null($subtitle)) {
            $this->header->addSubtitle($subtitle);
        }
        $this->header->addText(self::SITE_PHONE_NUMBER,'h2');
        $this->header->setMoreClass('Address');
        $this->header->addAddress('');
        $this->header->addMoreText(self::SITE_ADDRESS,'p');
        $this->header->addMoreText(self::SITE_CITY_STATE_ZIP,'p');
        $this->header->addMenu('HeaderMenu');

        $this->header->addMenuItem('Section','/home','Home');
        $this->header->addSubMenuItem('/home','Subsection','/home','Sub Item');
        
        $this->headerNode = &$this->header;
        // The parent version needs to be called
        parent::appendContent($this->header);
    }
    function bodyFooter() {
        $this->header->addFooterMenuItem('Section','/home','Additional Footer Link');

        $this->footer = $this->headerNode->getFooterModule();
        
        $this->footer->addLink('/home'); //Link goes home
        $img = $this->createImageNode('/noimage');
        $img->setAttribute('height','35');
        $img->setAttribute('width','126');
        $this->footer->addMore($img);
        $this->footer->setMoreAttribute('class','sitereferance');

        $this->footer->addBodyText('design & development by ');
        $createdBy = $this->createLinkNode('','www.hphant.com');
        $createdBy->addText('Hierophant Media');
        $this->footer->child->appendChild($createdBy);

        //The parent version needs to be called
        parent::appendContent($this->footerNode);
    }
    //Refactored to use a base "bmcd_page" class
    /**
     * Depracated
     * @param <type> $isAdmin
     * @return <type>
     */
    function checkAdmin($isAdmin=false) {
        $requestUriArray = explode("?",$_SERVER['REQUEST_URI']);
        if ($this->url != $requestUriArray[0]) {
            return false;
        }

        if (isset($_COOKIE['admin']) && ($_COOKIE['admin']=='no-js')) {
            return true;
        }
        $this->tLog->debug("ISADMIN: ".($isAdmin ? 'True':'False'));
        if ($isAdmin ||
            (isset($_GET['admin']) && ($_GET['admin']=='no-js'))) {
            setcookie('admin', 'no-js');
            return true;
        }
        if (isset($_GET['admin']) && ($_GET['admin']=='js')) {
            setcookie('admin', 'no-js', -1);
            return false;
        }
        return false;
    }
   
    function setSelectedMenuItem() {
        $this->headerNode->setSelectedMenuItem($this->url);
    }
    /**
     * Appends content nodes before the footerNode
     * @return void
     * @param $cNode ContentNode	The ContentNode to insert into the page
     */
    function appendContent($cNode) {
        parent::appendContent($cNode,$this->footerNode);
    }

    /**
     * Creates a floor node
     * @return ContentNode	A node that can be used as a "floor" node on a page
     */
    function makeFloor() {
        $module = $this->createNode('div');
        $module->setClass('floor');
        return $module;
    }

    function makeModule($nClass=null) {
        $module = $this->createNode('div');
        if (!is_null($nClass)) {
            $module->setClass($nClass);
        }
        return $module;
    }
    function makeVideoList() {
        $module = $this->createNode('ul');
        $module->setClass('MAVideoListController');

        return $module;
    }

    function addFloor() {
        return $this->appendChild($this->makeFloor());
    }
    function addMoreModule($nClass=null) {
        return $this->addMore($this->makeModule($nClass));
    }
    function addMoreToModule($cNode) {
        return $this->child->addMore($cNode);
    }
    function setMoreToAttribute($field,$value) {
        $this->child->setMoreAttribute($field,$value);
    }

    function makeVideoListItem($embedSrc,$caption='',$domain=CONTENT) {
        $module = $this->createNode('li');
        $module->setClass('Video');

        $embed = $this->createNode('embed');
        $embed->setAttribute('src',"http://$domain$embedSrc");
        $embed->setAttribute('width','420');
        $embed->setAttribute('height','280');
        $embed->setAttribute('type','video/quicktime');
        $embed->setAttribute('pluginspage','http://www.apple.com/quicktime/download/');

        $p = $this->createNode('p');
        $pText = $this->createTextNode($caption);
        $p->appendChild($pText);

        $module->appendChild($embed);
        $module->appendChild($p);

        return $module;
    }
}
?>
