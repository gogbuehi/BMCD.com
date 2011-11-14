<?php
	require_once 'includes/models/page/page.php';
	//Will need to be refactored to use "BmcdPage class"
	require_once 'includes/models/page/bmcd/header_node.php';
    
	//require_once 'models/session.php';
    //require_once 'models/page_event.php';
    //$s = new Session();
    //$pe = new Page_Event();
	class Bmcd999Page extends Page {
		protected $url;
		
		protected $headerNode;
		protected $footerNode;
		function __construct($subtitle=null,$url=null) {
			parent::__construct();
            $requestUriArray = explode("?",$_SERVER['REQUEST_URI']);
            $this->url = (is_null($url) ? $requestUriArray[0] : $url);
			$this->makeHeadNodeContent();
			$this->makeHeader($subtitle);
			$this->setSelectedMenuItem();
			$this->makeFooter();		
		}
			
		function makeHeader($subtitle=null) {
			$headerNode = new HeaderNode($this->doc,'ModBMCD999Header');
            $headerNode->setUrl($this->url);
			$headerNode->addLogo('LamboLogo','/research/model_lineup/lambo','/temp/images/lambologo.png','To Lamborghini');	
			$headerNode->addLogo('BentleyLogo','/research/model_lineup/bentley','/temp/images/bentleylogo.png','To Bentley');
			$headerNode->addLogo('LotusLogo','/research/model_lineup/lotus','/temp/images/lotuslogo.png','To Lotus');
			$headerNode->addTitle('Lamborghini');
			$headerNode->addTitle('Lotus');
			$headerNode->addTitle('Bentley');
			
			$headerNode->addText('San Francisco','h2');
			$headerNode->setMoreClass('Title');
			
			if (!is_null($subtitle)) {
				$headerNode->addSubtitle($subtitle);
			}
			
			$headerNode->addText('888.203.6567','h2');
			$headerNode->setMoreClass('Address');
	
			$headerNode->appendChild( $this->createNode('h3') );	
			$headerNode->setMoreClass('Address');
			$headerNode->addMoreText('999 Van Ness Ave','p');
			$headerNode->addMoreText('San Francisco, CA 94109','p');
			
			////
			// 	 Build Menu Items
			////
			$headerNode->addMenu('MAHeaderMenu');
			// Home
			$headerNode->addMenuItem('Section','/home','Home');
			
			// About Us
			$headerNode->addMenuItem('Section','/about','About Us',true);
			$headerNode->addSubMenuItem('/about','Subsection','/about/general','General');
			//$headerNode->addSubMenuItem('/about','Subsection','/about/history','History');
			$headerNode->addSubMenuItem('/about','Subsection','/about/our_team','Our Team');
			$headerNode->addSubMenuItem('/about','Subsection','/about/contact_us','Contact Us');
			$headerNode->addSubMenuItem('/about','Subsection','https://www.hotlinkhr.com/app/pg_general.asp?xu=SDA89902&xt=326F107C565651&fav=true','Employment');
			// Inventory
			$headerNode->addMenuItem('Section','/inventory','Inventory',true);
			$headerNode->addSubMenuItem('/inventory','Subsection','/inventory/all','All');
			$headerNode->addSubMenuItem('/inventory','Subsection','/inventory/lambo','Lambo');
			$headerNode->addSubMenuItem('/inventory','Subsection','/inventory/lotus','Lotus');
			$headerNode->addSubMenuItem('/inventory','Subsection','/inventory/bentley','Bentley');
			$headerNode->addSubMenuItem('/inventory','Subsection','/inventory/other','Other');
			// Research
			$headerNode->addMenuItem('Section','/research','Research',true);
			$headerNode->addSubMenuItem('/research','Subsection','/research/model_lineup','Model Lineup');
			// Finance
			$headerNode->addMenuItem('Section','/finance','Finance',true);
			$headerNode->addSubMenuItem('/finance','Subsection','/finance/general','General');
			$headerNode->addSubMenuItem('/finance','Subsection','/finance/privacy_policy','Privacy Policy');	
			$headerNode->addSubMenuItem('/finance','Subsection','/forms/quick_quote','Quick Quote');	
			// Parts/Service
			$headerNode->addMenuItem('Section','/parts_service','Service',true);
			$headerNode->addSubMenuItem('/parts_service','Subsection','/forms/service_request','Appointment Scheduler');	
			$headerNode->addSubMenuItem('/parts_service','Subsection','/forms/parts_request','Order Parts');
			
			// Boutique
			$headerNode->addMenuItem('Section','/boutique','Boutique');
			
			// Events
			$headerNode->addMenuItem('Section','/events','Events');
			
			$headerNode->addFooterMenuItem('Section','/about/contact_us','Contact Us');
			$headerNode->addFooterMenuItem('Section','https://www.hotlinkhr.com/app/pg_general.asp?xu=SDA89902&xt=326F107C565651&fav=true','Employment');
	
			$this->headerNode = &$headerNode;
			// The parent version needs to be called
			parent::appendContent($headerNode);
		}
		
		
		//Functions for BmcdPage class
		
		/**
		 * Create the content that goes into the <head> node
		 * of the page.
		 * @return void
		 * @param $title String[optional]	The page's title
		 */
		function makeHeadNodeContent($title='British Motor Car Distributors') {
			$this->setTitle($title);
			$this->addScript(ScriptNode::PAGE_SCRIPT, $this->jsGlobals());
            $this->addScript(ScriptNode::SRC_LINK,'http://'.HOSTNAME.'/scripts/jquery-1.2.6.lined.js');
			$this->addScript(ScriptNode::SRC_LINK,'http://'.HOSTNAME.'/js/url_manager.js');
			//$this->addScript(ScriptNode::PAGE_SCRIPT,"redirect_hash('".$_SERVER["REQUEST_URI"]."');");
			//Just a way to see how styles can be applied; Not necessary
			//$this->addStyle(StyleNode::PAGE_STYLE,"body {background-color:#AFAFFF;}");
            if ($this->checkAdmin()) {
                //Don't redirect
                $this->addScript(ScriptNode::PAGE_SCRIPT,"var a =1 + 1;");
            }
            $this->addStyle(StyleNode::SRC_LINK, '/styles/style.css');
		}
		function setSelectedMenuItem() {
			$this->headerNode->setSelectedMenuItem($this->url);
		}
		function makeFooter() {
			$this->footerNode = $this->headerNode->getFooterModule();
	
			$this->footerNode->addLink('/home',SUBDOMAIN_901);
			$img = $this->createImageNode('/temp/images/jag_lr_logos_footer.png');
			$img->setAttribute('height','32');
			$img->setAttribute('width','114');
			$this->footerNode->addMore($img);
			//$this->footerNode->addMoreText('British Motor Car Distributors');
			$this->footerNode->setMoreAttribute('class','sitereferance');
			
			$this->footerNode->addBodyText('design & development by ');
			$createdBy = $this->createLinkNode('','www.hphant.com');
			$createdBy->addText('Hierophant Media');
			$this->footerNode->child->appendChild($createdBy);
			
			parent::appendContent($this->footerNode);	
		}
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