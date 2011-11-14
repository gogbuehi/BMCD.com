<?php
require_once 'includes/models/page/content_node.php';
require_once 'includes/models/page/page.php';
require_once 'includes/models/page/module_node.php';

require_once 'managers/PermissionManager.php';
/**
 * Description of LoginPage
 *
 * @author Goodwin
 */
class LoginPage extends Page {
    protected $pm;
    function __construct() {
        parent::__construct();
        $this->pm = new PermissionManager();
        $this->checkForLogout();
        $this->build();
    }
    function checkForLogout() {
        if (isset($_GET['logout'])) {
            $this->pm->logout();
        }
    }
    /**
     * Create the content that goes into the <head> node
     * of the page.
     * @return void
     * @param $title String[optional]	The page's title
     */
    function makeHeadNodeContent($title='British Motor Car Distributors: Administration') {
        $this->setTitle($title);
        $this->addScript(ScriptNode::PAGE_SCRIPT,$this->jsGlobals());
        $this->addScript(ScriptNode::PAGE_SCRIPT,$this->getQuerystringFields());
        $this->addScript(ScriptNode::SRC_LINK,'http://'.HOSTNAME.'/scripts/jquery-1.2.6.lined.js');
        $this->addScript(ScriptNode::SRC_LINK,'http://'.HOSTNAME.'/scripts/ObjTree.js');
		$this->addScript(ScriptNode::SRC_LINK,'http://'.HOSTNAME.'/scripts/ServiceHandler.js');
        $this->addScript(ScriptNode::SRC_LINK,'http://'.HOSTNAME.'/scripts/PermissionManager.js');
        $this->addScript(ScriptNode::SRC_LINK,'http://'.HOSTNAME.'/scripts/MessageBox.js');
        $this->addScript(ScriptNode::SRC_LINK,'http://'.HOSTNAME.'/js/login.js');
        $this->addScript(ScriptNode::SRC_LINK,'http://'.HOSTNAME.'/scripts/test_service.js');

        $this->addStyle(StyleNode::PAGE_STYLE,
            ".floor {\n".
            "	text-align:center;\n".
            "	font-family:Arial;\n".
            "	padding:5px;\n".
            "	margin:5px;\n".
            "	border:solid 1px black;\n".
            "}".
            ".hide {\n".
            "	display:none;\n".
            "}"
        );
    }
    private function getQuerystringFields() {
        $fields = "var getValues = new Array();";
        $comma = "\n";
        foreach($_GET as $key => $value) {
            $fields .= $comma.'getValues[\''.urlencode($key).'\']=\''.urlencode($value).'\';';
            //$comma = "\n";
        }
        $fields .= $comma."function remakeQuerystring(qArray) {\n".
            "	var qString = \"\";\n".
            "	var questionMark = \"?\";\n".
            "	var ampersand = \"\";\n".
            "	for (index in qArray) {\n".
            "		if (qArray[index] !== null) {\n".
            "			qString += questionMark + ampersand + index + \"=\" + qArray[index];\n".
            "			questionMark = \"\";\n".
            "			ampersand = \"&\";\n".
            "		}\n".
            "	}\n".
            "	return qString;\n".
            "}";
        return $fields;
    }
    /**
     * Builds the primary content for the page
     */
    function build() {
        $this->makeHeadNodeContent();
        $floor = $this->createNode('div');
		$floor->setClass('floor');
        $this->appendContent($floor);

        $module2 = new ModuleNode($this->doc);
        $module2->makeModArticle();
        $module2->addTitleText('Site Administration');
        $aNode = $this->createLoginForm();
        $module2->appendChild($aNode);
        $bNode = $this->createMessageBox('login');
        $module2->appendChild($bNode);
        $cNode = $this->createLogoutForm();
        $module2->appendChild($cNode);
        
        $floor->appendChild($module2);
        
    }

    function &createLoginForm() {
        $form = $this->createNode('form');
        $form->setAttribute('name','login');
        $form->setAttribute('id','loginForm');
        $form->setAttribute('action','');
        $form->setAttribute('method','post');
        if ($this->pm->isLoggedIn()) {
            $form->setClass("hide");
        }

        $usernameLabel = $this->createNode('label');
        $usernameLabel->setAttribute('for','username');
        $usernameLabel->addText(' Username: ');

        $usernameField = $this->createNode('input');
        $usernameField->setAttribute('id','username');
        $usernameField->setAttribute('name','username');
        $usernameField->setAttribute('type','text');
        $usernameField->setAttribute('value','');

        $passwordLabel = $this->createNode('label');
        $passwordLabel->setAttribute('for','password');
        $passwordLabel->addText(' Password: ');
        
        $passwordField = $this->createNode('input');
        $passwordField->setAttribute('id','password');
        $passwordField->setAttribute('name','password');
        $passwordField->setAttribute('type','password');
        $passwordField->setAttribute('value','');

        $domainField = $this->createNode('input');
        $domainField->setAttribute('id','domain');
        $domainField->setAttribute('name','domain');
        $domainField->setAttribute('type','hidden');
        $domainField->setAttribute('value','');

        /*
        $literalField = $this->createNode('input');
        $literalField->setAttribute('id','literalField');
        $literalField->setAttribute('name','literalField');
        $literalField->setAttribute('type','text');
        $literalField->setAttribute('value','');
         * 
         */

        $submitField = $this->createNode('input');
        $submitField->setAttribute('name','submit');
        $submitField->setAttribute('id','submitLogin');
        $submitField->setAttribute('type','submit');
        $submitField->setAttribute('value','Login');

        $form->appendChild($usernameLabel);
        $form->appendChild($usernameField);
        $form->addText(); //Adds a "br" tag
        $form->appendChild($passwordLabel);
        $form->appendChild($passwordField);
        $form->addText();
        $form->appendChild($domainField);
        //$form->appendChild($literalField);
        $form->appendChild($submitField);

        return $form;
    }
    function &createLogoutForm() {
        $messageNode = $this->createNode('span');
        $messageNode->addText('Status: Logged In');
        $messageNode->addText();
        $a = $this->createNode('a');
        $a->setAttribute('href','?logout');
        $a->setAttribute('id','logoutLink');
        $a->addText('Click here');
        $messageNode->appendChild($a);
        $messageNode->addText(' to logout.');

        return $this->createMessageBox('logout', !$this->pm->isLoggedIn(),$messageNode);
    }

    function &createMessageBox($id,$isHidden=true,ContentNode &$defaultMessageNode=null) {
        $module = $this->createNode('div');
        if($isHidden) {
            $messageBoxClass = "messageBox hide";
        }
        else {
            $messageBoxClass = "messageBox";
        }

        $module->setClass($messageBoxClass);
        $module->setAttribute('id',$id);

        //Message field
        $messageField = $this->createNode('div');
        $messageField->setClass('messageField');
        if (is_null($defaultMessageNode)) {
            $defaultMessageNode = $this->createTextNode("");
        }
        $messageField->appendChild($defaultMessageNode);


        //Close button
        $closeForm = $this->createNode('form');
        $closeButton = $this->createNode('input');
        $closeButton->setClass('closeButton');
        $closeButton->setAttribute('type','image');
        $closeButton->setAttribute('src','http://'.HOSTNAME.'/assets/images/CloseButton_blue.jpg');
        //$closeButton->setAttribute('value','Close');
        $closeForm->appendChild($closeButton);

        

        $module->appendChild($messageField);
        $module->addText();
        $module->appendChild($closeForm);

        return $module;
    }

    function checkAdmin($isAdmin=false) {
        $requestUriArray = explode("?",$_SERVER['REQUEST_URI']);
        if ($this->url != $requestUriArray[0]) {
            return false;
        }

        if (isset($_COOKIE['admin']) && ($_COOKIE['admin']=='no-js')) {
            return true;
        }
        //$this->tLog->debug("ISADMIN: ".($isAdmin ? 'True':'False'));
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
}

$page = new LoginPage();
echo $page->getHtml();
?>