<?php
    require_once 'includes/models/page/module_node.php';
	
	class ArticleTextRightModule extends ModuleNode {
		function __construct(&$doc) {
			parent::__construct($doc);
			$this->setClass('ModArticleTextRight');
		}
		
		
	}
?>