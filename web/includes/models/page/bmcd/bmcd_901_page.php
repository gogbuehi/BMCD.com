<?php
	require_once 'includes/models/page/page.php';
	require_once 'includes/models/page/bmcd/header_node.php';

    
	
	class Bmcd901Page extends Page {
		protected $url;
		
		protected $headerNode;
		protected $footerNode;

        protected $floorCount = 0;
        const FLOOR_IDENTIFIER = 'floor_';
        
		function __construct($subtitle=null,$url=null) {
			parent::__construct();
            $requestUriArray = explode("?",$_SERVER['REQUEST_URI']);
            $this->url = (is_null($url) ? $requestUriArray[0] : $url);
            $this->makeHeadNodeContent();
            $this->makeHeader($subtitle);
            if (!is_null($subtitle) && $subtitle !== '') {
                $this->pTitle->appendContent(" - $subtitle");
            }
            $this->setSelectedMenuItem();
            $this->makeFooter();
		}
		/**
		 * Create the content that goes into the <head> node
		 * of the page.
		 * @return void
		 * @param $title String[optional]	The page's title
		 */
		function makeHeadNodeContent($title='British Motor Car Distributors') {
            global $s;
            //$this->tLog->debug("SESSION KEY: {$s->d_key}");
            //$this->tLog->debug("SESSION USER: {$s->d_o_user}");
			$this->setTitle($title);

            $this->addScript(ScriptNode::PAGE_SCRIPT, $this->jsGlobals());
            $this->addScript(ScriptNode::SRC_LINK,'http://'.HOSTNAME.'/scripts/jquery-1.2.6.lined.js');
            $this->addScript(ScriptNode::SRC_LINK,'http://'.HOSTNAME.'/scripts/ObjTree.js');
            $this->addScript(ScriptNode::SRC_LINK,'http://'.HOSTNAME.'/scripts/ServiceHandler.js');
            $this->addScript(ScriptNode::SRC_LINK,'http://'.HOSTNAME.'/scripts/BrowserManager.js');
			$this->addScript(ScriptNode::SRC_LINK,'http://'.HOSTNAME.'/js/url_manager.js');
            if ($this->checkAdmin()) {
                //Don't redirect
                $this->addScript(ScriptNode::PAGE_SCRIPT,"var a =1 + 1;");
            }
            //$this->addScript(ScriptNode::PAGE_SCRIPT,"redirect_hash('".$_SERVER["REQUEST_URI"]."');");
			//$this->addScript(ScriptNode::SRC_LINK,'/scripts/jquery-1.2.6.lined.js');
			//Just a way to see how styles can be applied; Not necessary
			$this->addStyle(StyleNode::SRC_LINK, '/styles/style.css');
		}
        //Refactore to use a base "bmcd_page" class
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
		 * Make the page's header and menu
		 * @return void
		 */
		function makeHeader($subtitle=null) {
			$headerNode = new HeaderNode($this->doc,'ModBMCD901Header');
            $headerNode->setUrl($this->url);
			$headerNode->addLogo('BMCDLogo','/','/temp/images/bmcdlogo.png','BMCD');
			$headerNode->addLogo('JaguarLogo','/research/model_lineup/jaguar','/temp/images/jaguarlogo.png','Jaguar');
			$headerNode->addLogo('LandRoverLogo','/research/model_lineup/land_rover','/temp/images/landroverlogo.png','Land Rover');
			$headerNode->addTitle('British Motor Car Distributors');
			if (!is_null($subtitle)) {
				$headerNode->addSubtitle($subtitle);
			}
			$headerNode->addText('800.536.8288','h2');
			$headerNode->setMoreClass('Address');
			$headerNode->addAddress('');
			$headerNode->addMoreText('901 Van Ness Ave.','p');
			$headerNode->addMoreText('San Francisco, CA 94109','p');
			$headerNode->addMenu('MAHeaderMenu');

			//$nClass,$href,$label,$isSelected=false,$subMenu=null
			// ABOUT US
			$headerNode->addMenuItem('Section','/about','About Us',true);
			$headerNode->addSubMenuItem('/about','Subsection','/about/general','General');
			$headerNode->addSubMenuItem('/about','Subsection','/about/history','History');
			$headerNode->addSubMenuItem('/about','Subsection','/about/our_team','Our Team');
			$headerNode->addSubMenuItem('/about','Subsection','/about/testimonials','Testimonials');
			$headerNode->addSubMenuItem('/about','Subsection','/about/contact_us','Contact Us');
			$headerNode->addSubMenuItem('/about','Subsection','https://www.hotlinkhr.com/app/pg_general.asp?xu=SDA89902&xt=326F107C565651&fav=true','Employment');
			// INVENTORY 
			$headerNode->addMenuItem('Section','/inventory','Inventory');
			$headerNode->addSubMenuItem('/inventory','Subsection','/inventory/all','All');
			$headerNode->addSubMenuItem('/inventory','Subsection','/inventory/jaguar','Jaguar');
			$headerNode->addSubMenuItem('/inventory','Subsection','/inventory/land_rover','Land Rover');	
			$headerNode->addSubMenuItem('/inventory','Subsection','/inventory/other','Other');
            //SPECIALS
            $headerNode->addMenuItem('Section','/specials','Specials');
			// RESEARCH 
			$headerNode->addMenuItem('Section','/research','Research');
			$headerNode->addSubMenuItem('/research','Subsection','/research/model_lineup','Model Lineup');
			//$headerNode->addSubMenuItem('/research','Subsection','/forum','Forum');	
			//$headerNode->addSubMenuItem('/research','Subsection','/news_reviews','News/Reviews');	
			// FINANCE
			$headerNode->addMenuItem('Section','/finance','Finance');
			$headerNode->addSubMenuItem('/finance','Subsection','/finance/privacy_policy','Privacy Policy');
			//$headerNode->addSubMenuItem('/finance','Subsection','/finance/tax_benefits','Tax Benefits');	
			$headerNode->addSubMenuItem('/finance','Subsection','/finance/purchasing_options','Bank Vendors');	
			$headerNode->addSubMenuItem('/finance','Subsection','/forms/quick_quote','Quick Quote');	
			//$headerNode->addSubMenuItem('/finance','Subsection','/finance/specials','Specials');
			
			// PARTS/SERVICE
			$headerNode->addMenuItem('Section','/parts_service','Parts/Service');
			$headerNode->addSubMenuItem('/parts_service','Subsection','/forms/service_request','Appointment Scheduler');
			$headerNode->addSubMenuItem('/parts_service','Subsection','/forms/parts_request','Order Parts');	
			
			// EVENTS
			$headerNode->addMenuItem('Section','/events','Events');
			
			// BOUTIQUE 
			$headerNode->addMenuItem('Section','/boutique','Boutique');
			
			
			$headerNode->addFooterMenuItem('Section','/about/contact_us','Contact Us');
			$headerNode->addFooterMenuItem('Section','https://www.hotlinkhr.com/app/pg_general.asp?xu=SDA89902&xt=326F107C565651&fav=true','Employment');
			
			$this->headerNode = &$headerNode;
			// The parent version needs to be called
			parent::appendContent($headerNode);
		}
		function setSelectedMenuItem() {
			$this->headerNode->setSelectedMenuItem($this->url);
		}
		function makeFooter() {
			//$footerNode = $this->createNode('div');
			//$footerNode->setClass('footer');
			//$footerText = $this->createTextNode('THIS NODE NEEDS A FOOTER_NODE CLASS CREATED FOR IT.');
			//$footerNode->appendChild($footerText);
			
	
			
			$this->footerNode = $this->headerNode->getFooterModule();
			
			$this->footerNode->addLink('/home',SUBDOMAIN_999);
			$img = $this->createImageNode('/temp/images/bent_lamb_lot_logos_footer.png');
			$img->setAttribute('height','35');
			$img->setAttribute('width','126');
			$this->footerNode->addMore($img);
			//$this->footerNode->addMoreText('Lamborghini | Lotus | Bentley San Francisco');
			$this->footerNode->setMoreAttribute('class','sitereferance');
			
			$this->footerNode->addBodyText('design & development by ');
			$createdBy = $this->createLinkNode('','www.hphant.com');
			$createdBy->addText('Hierophant Media');
			$this->footerNode->child->appendChild($createdBy);
			
			//The parent version needs to be called
			parent::appendContent($this->footerNode);
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