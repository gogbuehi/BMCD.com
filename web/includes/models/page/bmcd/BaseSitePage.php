<?php
require_once 'includes/models/page/page.php';
require_once 'includes/models/page/bmcd/header_node.php';
//TODO: Get "HeaderNode" class out of "bmcd" directory
/**
 * Basic class structure for a new site page
 * This will be the requirements for an site's unique style of page
 * @author goodwin
 */
interface BaseSitePage extends Page {
    protected $title;
    protected $subtitle;
    protected $header;
    protected $footer;
    protected $menu;

    protected function createMenu();
    protected function createHeader();
    protected function createFooter();
    /**
     *
     * @param <type> $newNode
     */
    public function addToBody(ContentNode $newNode);
    public function setTitle($title);
    public function setSubTitle($subtitle);

    

}
?>
