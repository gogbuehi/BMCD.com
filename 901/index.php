<?php
	require_once 'includes/utils/url_manager.php';
    require_once 'caching/CacheManager.php';
	require_once 'models/session.php';
    require_once 'models/page_event.php';
    $s = new Session();

    if (isset($_GET['nopage']) && $_GET['nopage']=='true') {
        require_once 'includes/models/page/bmcd/bmcd_901_page.php';
        $blankPage = new Bmcd901Page("Blank");
	echo $blankPage->getHtml();
    }
    else {
        $requestUriArray = explode("?",$_SERVER['REQUEST_URI']);
        $currentUrl = new UrlManager();
        $pageClass = null;
        $uri = $requestUriArray[0];
        switch($uri) {
            case "/":
            case "":
                require_once 'includes/page_handlers/default.php';
                break;
            case "/admin":
                require_once 'includes/page_handlers/LoginPage.php';
                break;
            case '/service':
                require_once 'handlers/ServicePage.php';
                break;
            case '/sitemap':
                require_once 'pages/SiteMap.php';
                break;
            case '/email':
                require_once 'includes/handlers/email_handler.php';
                break;
            case '/upload':
                require_once 'includes/handlers/upload_handler.php';
                break;
            case '/gateway.php':
            case '/json.php':
            case '/globals.php';
                //$fileName = str_replace("/", "", $uri);
                require_once AMFPHP_INCLUDE_PATH_PREPEND.$uri;
                break;
            default:
                $trackPageEvent = true;
                if ((isset($_GET['fl']) && $_GET['fl'] == 'drop') || isset($_GET['nojs'])) {
                    $trackPageEvent = false;
                }
                if ($trackPageEvent) {
                    $pe = new Page_Event();
                }
                $cm = new CacheManager();
                $pageContents =  $cm->getCurrenCache();
                if (!$cm->hasCache()) {
                    if ($trackPageEvent) {
                        $pe->setStatus(404);
                    }
                    require_once 'pages/not_found.php';
                }
                else {
                    echo $pageContents;
                }

        }
    }
	//$testSimpleUrl = new UrlManager('www.bmcd.com');
	//$testRelativeUrl = new UrlManager('/test/page');
	//$testUrlWithQuerystring = new UrlManager('http://www.bcmd.com/test/page?r=1');
	//$testRelativeUrlWithQuerystring = new UrlManager('/test/page?r=1');
	//$testUrlWithoutUri = new UrlManager('http://www.bmcd.com?r=1');
?>