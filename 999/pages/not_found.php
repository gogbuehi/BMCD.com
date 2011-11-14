<?php
require_once 'includes/models/page/bmcd/bmcd_999_page.php';
require_once 'includes/models/page/module_node.php';

/**
 * Description of not_found
 *
 * @author Goodwin Ogbuehi
 */
class NotFoundPage  extends Bmcd999Page {
    function __construct() {
        parent::__construct('');
        if (isset($_REQUEST['fl']) && $_REQUEST['fl']=='drop') {
            //do nothing
        }
        else {
            header("HTTP/1.0 404 Not Found");
        }
        $this->build();
    }

    /**
     * Create the content that goes into the <head> node
     * of the page.
     * @return void
     * @param $title String[optional]	The page's title
     */
    function makeHeadNodeContent($title='British Motor Car Distributors: Page Not Found') {
        $this->setTitle($title);
        $this->addScript(ScriptNode::PAGE_SCRIPT, $this->jsGlobals());
        $this->addScript(ScriptNode::SRC_LINK,'http://'.HOSTNAME.'/js/url_manager.js');
        $this->addScript(ScriptNode::PAGE_SCRIPT,"redirect_hash('".$_SERVER["REQUEST_URI"]."');");
    }

    /**
     * Builds the primary content for the page
     */
    function build() {
        $this->makeHeadNodeContent();
        $floor = $this->makeFloor();

        $module = new ModuleNode($this->doc);
        $module->makeModArticle();
        $module->addTitleText('Page Not Found');
        $module->addBodyText("The page you requested is not available.");

        //Add the module to the Floor.
        $floor->appendChild($module);
        //Add the floor to the page.
        $this->appendContent($floor);
    }
}
$page = new NotFoundPage();
echo $page->getHtml();
?>