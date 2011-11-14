<?php
    require_once 'includes/config/globals.php';
	require_once 'includes/utils/url_manager.php';

    require_once 'models/session.php';
    require_once 'models/page_event.php';
    $s = new Session();
    $pe = new Page_Event();

    $requestUriArray = explode("?",$_SERVER['REQUEST_URI']);
    $uri = $requestUriArray[0];
	if ($uri == "" || $uri == "/") {
		require_once 'includes/page_handlers/default.php';
	}
    else {
        switch ($uri) {
            case '/gateway.php':
            case '/json.php':
            case '/globals.php';
                //$fileName = str_replace("/", "", $uri);
                require_once AMFPHP_INCLUDE_PATH_PREPEND.$uri;
                break;
            default:
                $tLog->debug($uri);
                //Do 404 page
                require_once 'includes/page_handlers/not_found.php';
        }
        
    }
?>