<?php
require_once 'includes/models/page/content_node.php';
require_once 'includes/models/page/page.php';
require_once 'includes/models/page/module_node.php';
/* 
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * A 404 Page for bad URI requests
 *
 * @author Goodwin Ogbuehi
 */
class NotFoundPage extends Page {
    function __construct() {
        parent::__construct();
        header("HTTP/1.0 404 Not Found");
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
        }

    /**
     * Builds the primary content for the page
     */
    function build() {
        $this->makeHeadNodeContent();
        $floor = $this->createNode('div');
		$floor->setClass('floor');
        $this->appendContent($floor);

        $module = new ModuleNode($this->doc);
        $module->makeModArticle();
        $module->addTitleText('Page Not Found');
        $module->addBodyText("The page you requested is not available. The page will automatically redirect to the home page in 10 seconds.");
        $module->addMoreText('If the page does not reload, ');
        $module->addMoreLink('',HOSTNAME);
		$module->child->addMoreText('click here');
        $module->addMoreText('.');

        $floor->appendChild($module);
        $this->addScript(ScriptNode::BODY_SCRIPT,"var counter = 7; function count() { if (counter == 0 ) window.location = 'http://'+window.location.hostname; counter--;setTimeout('count()',1000);} count();");
    }
}
$page = new NotFoundPage();
echo $page->getHtml();
?>
