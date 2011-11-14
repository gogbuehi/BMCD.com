<?php
require_once 'includes/models/page/bmcd/bmcd_999_page.php';
require_once 'includes/models/page/module_node.php';
require_once 'caching/CacheManager.php';
require_once 'caching/Page_File.php';

/**
 * Description of SiteMap
 *
 * @author Goodwin Ogbuehi
 */
class SiteMap extends Bmcd999Page {
    protected $cm;
    protected $message;
    protected $messageList;
    function __construct() {
        parent::__construct('Site Map');
        $this->message = $this->createNode('div');
        $this->message->setClass('message');
        $this->message->addText('MESSAGES: ');
        $this->messageList = $this->createNode('ol');
        $this->messageList->setClass('message');
        $this->message->appendChild($this->messageList);
        $this->cm = new CacheManager();
        $this->updateCache();
        $this->makeContent();
    }
    function checkAdmin() {
        return parent::checkAdmin(true);
    }

    function makeContent() {
        $floor = $this->makeFloor();
        $floor->appendChild($this->message);


        $div = $this->createNode('div');
        $div->setClass('link');
        $div->addDecendentLink('?all=1');
        $div->addMoreText('[UPDATE ALL CACHES]');

        $floor->appendChild($div);


        $pf = new Page_File();
        $pages = $pf->get('domain', $_SERVER['SERVER_NAME']);


        $module = new ModuleNode($this->doc);
        $module->setClass('SiteMap');


        foreach($pages as $key => $value) {
            $hr = $this->createNode('hr');
            $hr->setAttribute('class','list_break');
            $module->appendChild($hr);
            //$this->tLog->debug("Found page $value");
            $ul = $value->toDom($this);

            //Add a link to update the cache
            $li = $this->createNode('li');
            $li->setClass('link');
            $li->addDecendentLink('?pf='.$value->id.'#'.$value->getAnchorName());
            $li->addMoreText('[UPDATE CACHE]');
            $ul->appendChild($li);


            $this->cm->setPageFile($value);

            $caches = $this->cm->getPriorCaches();
            $className = 'Page_Edit first';
            foreach($caches as $aKey => $aValue) {
                $li = $this->createNode('li');
                $li->setClass($className);
                $li->appendChild($aValue->toDom($this));
                $ul->appendChild($li);

                $className = 'Page_Edit';
            }
            $module->appendChild($ul);

        }
        $floor->appendChild($module);
        $this->appendContent($floor);
    }

    function updateCache() {
        /*
        if (isset($_REQUEST['pf'])) {
            //$this->tLog->debug("PF is set to {$_REQUEST['pf']}. Updating cache...");
            $pf_id = $_REQUEST['pf'];
            $this->cm->setPageFile(new Page_File($pf_id));
            $this->addMessage($this->cm->updateCache());
        }
        else if (isset($_REQUEST['all'])) {
            //$this->tLog->debug("ALL is set to {$_REQUEST['all']}. Updating all caches...");
            $reviewedClasses = array();
            $pf = new Page_File();
            $pages = $pf->get('domain', $_SERVER['SERVER_NAME']);
            foreach ($pages as $key => $value) {
                $className = $value->getName();
                if (isset($reviewedClasses[$className])) {
                    $this->addMessage("$className already reviewed for update.");
                }
                else {
                    $reviewedClasses[$className] = true;
                    $this->cm->setPageFile($value);
                    $this->addMessage($this->cm->updateCache());
                }
            }
        }
        else
         *
         */
        if (isset($_REQUEST['special'])) {
            //$this->tLog->debug("ALL is set to {$_REQUEST['all']}. Updating all caches...");
            $reviewedClasses = array();
            $pf = new Page_File();
            $pages = $pf->get('domain', $_SERVER['SERVER_NAME']);
            foreach ($pages as $key => $value) {
                $className = $value->getName();
                if (isset($reviewedClasses[$className])) {
                    $this->addMessage("$className already reviewed for update.");
                }
                else {
                    $reviewedClasses[$className] = true;
                    $this->cm->setPageFile($value);
                    $this->addMessage($this->cm->updateHeadersAndFooters());
                }
            }
        }
        else if (isset($_REQUEST['cleanup'])) {
            $aPe = new Page_Event(false);
            $aSession = new Session(false);
            $aPe->cleanup();
            $aSession->cleanup();
        }
    }

    function addMessage($msg) {
        $li = $this->createNode('li');
        $li->setClass('message');
        $li->addText($msg);
        $this->messageList->appendChild($li);
    }
}
$page = new SiteMap();
echo $page->getInnerHtml();
?>