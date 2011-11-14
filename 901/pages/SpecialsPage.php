<?php
	require_once 'includes/models/page/bmcd/bmcd_901_page.php';
	require_once 'includes/models/page/module_node.php';
    class SpecialsPage extends Bmcd901Page {
    	function __construct($url=null) {
    		parent::__construct('Specials',$url);
			$this->makeContent();
    	}

		function makeContent() {
			$floor = $this->makeFloor(); //Todo: This should be "createFloor"
            $module = new ModuleNode($this->doc);
            $module->makeModArticle();

            $module->addBodyText('Specials coming soon.');
				
			//Add the module to the Floor.
			$floor->appendChild($module);
			//Add the floor to the page.
			$this->appendContent($floor);
		}
    }

?>