<?php
	require_once 'includes/config/globals.php';
    require_once 'includes/models/page/page.php';
    require_once 'managers/PermissionManager.php';

    require_once 'caching/Page_File.php';
    $page = new Page();
    $pm = new PermissionManager();
	
	define('SWF_INSTALLER','/swf/playerProductInstall');
	define('SWF_LOCATION','/swf/main');
	define('SWF_NAME','main');
    define('JS_VERSION','trunk1144');
    if ($pm->isLoggedIn()) {
        define('ADMIN_MODE','true');
    }
    else {
        define('ADMIN_MODE','false');
    }
	define('ERRROR_LOGO',CONTENT.'/images/bmcd_logo_white.gif');
	$requestUriArray = explode("?",$_SERVER['REQUEST_URI']);
?>
<html>
	<head>
		<title>British Motor Car Distributors, Jaguar, Land Rover | Lamborghini San Francisco | Lotus San Francisco | Bentley San Francisco</title>
        <meta name="description" content="Welcome to the home of British Motor Car Distributors, Lamborghini San Francisco, Bentley San Francisco, and Lotus San Francisco. The San Francisco Bay Area’s premiere group for ultra-luxury exotics including Jaguar, Land Rover, Lamborghini, Bentley, and Lotus automobiles."></meta>
        <script src="http://<?php echo HOSTNAME; ?>/scripts/jquery-1.2.6.lined.js" type="text/javascript"></script>
        <script type="text/javascript">
            <?php echo $page->jsGlobals(); ?>
        </script>
        <script type="text/javascript" src="http://<?php echo HOSTNAME; ?>/scripts/FlashUtils.js"></script>
        <script type="text/javascript" src="http://<?php echo HOSTNAME; ?>/scripts/BrowserManager.js?<?php echo JS_VERSION; ?>"></script>
		<script type="text/javascript" src="http://<?php echo HOSTNAME; ?>/scripts/ObjTree.js"></script>
        <script type="text/javascript" src="http://<?php echo HOSTNAME; ?>/scripts/ServiceHandler.js"></script>
        <script type="text/javascript" src="http://<?php echo HOSTNAME; ?>/scripts/PermissionManager.js"></script>
        <script type="text/javascript" src="http://<?php echo HOSTNAME; ?>/scripts/MessageBox.js"></script>
        <script type="text/javascript" src="http://<?php echo HOSTNAME; ?>/js/url_manager.js"></script>
		<script type="text/javascript" src="http://<?php echo HOSTNAME; ?>/js/admin_manager.js"></script>
		<script type="text/javascript" src="http://<?php echo HOSTNAME; ?>/js/scroll_manager.js"></script>
        <script type="text/javascript">
            function gTrack(uri) {
                //Just log locally
            }
            function cTrack(uri) {
                //Same as above
            }
        </script>
		<script type="text/javascript">
			redirect_hash('<?php echo $requestUriArray[0]; ?>');
		</script>
		<script src="http://<?php echo HOSTNAME; ?>/js/AC_OETags.js" type="text/javascript" language="javascript"></script>
		
        
        <?php if (TRACK_ANALYTICS) { ?>
        <?php 
        switch($_SERVER['SERVER_NAME']) {
            case SUBDOMAIN_901:
                $googleAnalyticsId = GOOGLE_ANALYTICS_901_ID;
                $clickyAnalyticsId = CLICKY_ANALYTICS_901_ID;
                break;
            case SUBDOMAIN_999:
                $googleAnalyticsId = GOOGLE_ANALYTICS_999_ID;
                $clickyAnalyticsId = CLICKY_ANALYTICS_999_ID;
                break;
            default:
                $googleAnalyticsId = GOOGLE_ANALYTICS_ID;
                $clickyAnalyticsId = CLICKY_ANALYTICS_ID;
                break;
        }
        
        ?>
        <meta name="verify-v1" content="mWE2H1/OHSIjX8TlNwRp4AclIoUWrIlSITV+uQppO18="/>
        <script type="text/javascript">
            var gaJsHost = (("https:" == document.location.protocol) ? "https://ssl." : "http://www.");
            document.write(unescape("%3Cscript src='" + gaJsHost + "google-analytics.com/ga.js' type='text/javascript'%3E%3C/script%3E"));
            </script>
            <script type="text/javascript">
            try {
            var pageTracker = _gat._getTracker("<?php echo $googleAnalyticsId;?>");
            pageTracker._trackPageview();
            } catch(err) {}
            function gTrack(uri) {
                pageTracker._trackPageview(uri);
            }
        </script>
        <?php } ?>

		<script type="text/javascript">
			function getFlexRef() {
				var wind = getWindow();
				return wind.<?php echo SWF_NAME; ?>;
			}
            setWindowResizeListener();
		</script>
		<script language="JavaScript" type="text/javascript">
			// Globals
			// Major version of Flash required
			var requiredMajorVersion = 9;
			// Minor version of Flash required
			var requiredMinorVersion = 0;
			// Minor version of Flash required
			var requiredRevision = 115;
			
			// Version check for the Flash Player that has the ability to start Player Product Install (6.0r65)
			var hasProductInstall = DetectFlashVer(6, 0, 65);
			
			// Version check based upon the values defined in globals
			var hasRequestedVersion = DetectFlashVer(requiredMajorVersion, requiredMinorVersion, requiredRevision);
			
		</script>
		<script language="JavaScript" type="text/javascript">
			var bodyStyle = '<style type="text/css">body { '; 
			if  (!hasProductInstall || !hasRequestedVersion) {
				bodyStyle = bodyStyle + 'color:#FFFFFF; ';
				bodyStyle = bodyStyle + 'text-align:"center"; ';
				bodyStyle = bodyStyle + 'background-color:#000000;';
			} 
			bodyStyle = bodyStyle + 'margin: 0px;';
			bodyStyle = bodyStyle + '}</style>';
			document.write(bodyStyle);
		</script>
        <style type="text/css">
        .IEAnchor {
            display:block;
        }
        iframe {
            display:none;
        }
        </style>
	</head>
	<body>
        
        
		<script language="JavaScript" type="text/javascript">
			
			
			if ( hasProductInstall && !hasRequestedVersion ) {
				// DO NOT MODIFY THE FOLLOWING FOUR LINES
				// Location visited after installation is complete if installation is required
				var MMPlayerType = (isIE == true) ? "ActiveX" : "PlugIn";
				var MMredirectURL = window.location;
			    document.title = document.title.slice(0, 47) + " - Flash Player Installation";
			    var MMdoctitle = document.title;
				
				writeLowFlashVersionError(requiredMajorVersion);
				AC_FL_RunContent(
					"src", "<?php echo SWF_INSTALLER; ?>",
					"FlashVars", "MMredirectURL="+MMredirectURL+'&MMplayerType='+MMPlayerType+'&MMdoctitle='+MMdoctitle+"",
					"width", "100%",
					"height", "100%",
					"align", "middle",
					"id", "<?php echo SWF_NAME; ?>",
					"quality", "high",
					"bgcolor", "#000000",
					"name", "<?php echo SWF_NAME; ?>",
					"allowScriptAccess","sameDomain",
					"type", "application/x-shockwave-flash",
					"pluginspage", "http://www.adobe.com/go/getflashplayer"
				);
			} else if (hasRequestedVersion) {
				// if we've detected an acceptable version
				// embed the Flash Content SWF when all tests are passed
				AC_FL_RunContent(
						"src", "<?php echo SWF_LOCATION; ?>",
						"FlashVars", "adminMode=<?php echo ADMIN_MODE; ?>",
						"width", "100%",
						"height", "100%",
						"align", "middle",
						"id", "<?php echo SWF_NAME; ?>",
						"quality", "high",
						"bgcolor", "#000000",
						"name", "<?php echo SWF_NAME; ?>",
						"allowScriptAccess","sameDomain",
						"type", "application/x-shockwave-flash",
						"pluginspage", "http://www.adobe.com/go/getflashplayer"
				);
			  } else {  // flash is too old or we can't detect the plugin
			    writeNoFlashError(requiredMajorVersion);  // insert non-flash content
				
			  }
			function getSubdomains(){
				return ["http://<?php echo SUBDOMAIN_901; ?>/#/home","http://<?php echo SUBDOMAIN_999; ?>/#/home"];
			}
			function writeNoFlashError(majorVersion){
				var content = '<h1>NO FLASH PLAYER INSTALLED</h1><hr/><p> </p>'
							 +'<img src="http://<?php echo ERRROR_LOGO; ?>" alt="British Motors Car Distributers"/>'
							 +'<h3>ERROR PAGE</h3>'
							 +'<p>This site requires the Adobe Flash Player '+majorVersion+' or later. '
			   	             +'<a href=http://www.adobe.com/go/getflash/>Click here</a> to download the latest version from Adobe.</p>';
							 +'<p> </p><p>1024 x 768 Resolution Recommended</p>'
				document.write(content);
			}
			
			function writeLowFlashVersionError(majorVersion){
				var content = '<h1>NOT PROPER FLASH PLAYER VERSION</h1><hr/><p> </p>'
							 +'<img src="http://<?php echo ERRROR_LOGO; ?>" alt="British Motors Car Distributers"/>'
							 +'<h3>ERROR PAGE</h3>'
							 +'<p>This site requires the Adobe Flash Player '+majorVersion+' or later. '
			   	             +'You need to upgrade your Flash Plugin. An automatic installer will load below, please follow the instructions to update your Flash Plugin to the latest version.</p>';
							 +'<p> </p><p>1024 x 768 Resolution Recommended</p>'
				document.write(content);
			}
			//
		</script>
		<noscript>
            <div>
                <div>
                    <h1>Select a Store</h1>
                </div>
                <div>
                    <h1>British Motor Car Distributors</h1>
                    <ul>
                        <li><a href="http://<?php echo SUBDOMAIN_901; ?>/home">Jaguar San Francisco</a></li>
                        <li><a href="http://<?php echo SUBDOMAIN_901; ?>/home">Land Rover San Francisco</a></li>
                    </ul>
                    <p>
                        901 Van Ness Ave.
                        <br />
                        San Francisco, CA 94109
                        <br />
                        (800)536-8288
                    </p>
                </div>
                <div>
                    <h1>Lamborghini, Bentley, Lotus</h1>
                    <ul>
                        <li><a href="http://<?php echo SUBDOMAIN_999; ?>/home">Lamborghini San Francisco</a></li>
                        <li><a href="http://<?php echo SUBDOMAIN_999; ?>/home">Bentley San Francisco</a></li>
                        <li><a href="http://<?php echo SUBDOMAIN_999; ?>/home">Lotus San Francisco</a></li>
                    </ul>
                    <p>
                        999 Van Ness Ave.
                        <br />
                        San Francisco, CA 94109
                        <br />
                        (800)203-6567
                    </p>
                </div>
                <div>
                    <p>This site requires Javascript. Please be sure to check your browser settings to ensure that Javascript is turned on.</p>
                </div>
            </div>
		  	<!--
            <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000"
					id="<?php echo SWF_NAME; ?>" width="100%" height="100%"
					codebase="http://fpdownload.macromedia.com/get/flashplayer/current/swflash.cab">
					<param name="movie" value="<?php echo SWF_NAME; ?>" />
					<param name="quality" value="high" />
					<param name="bgcolor" value="#000000" />
					<param name="allowScriptAccess" value="sameDomain" />
					<embed src="<?php echo SWF_LOCATION; ?>.swf" quality="high" bgcolor="#000000"
						width="100%" height="100%" name="<?php echo SWF_NAME; ?>" align="middle"
						play="true"
						loop="false"
						quality="high"
						allowScriptAccess="sameDomain"
						type="application/x-shockwave-flash"
						pluginspage="http://www.adobe.com/go/getflashplayer">
					</embed>
			</object>
            -->
		</noscript>
        <?php if (TRACK_ANALYTICS) {?>
        <script src="http://static.getclicky.com/<?php echo $clickyAnalyticsId; ?>.js" type="text/javascript"></script>
        <noscript><p><img alt="Clicky" width="1" height="1" src="http://static.getclicky.com/<?php echo $clickyAnalyticsId; ?>-db9.gif" /></p></noscript>
        <script type="text/javascript">
            function cTrack(uri) {
                clicky.log(uri);
            }
        </script>
        <?php } ?>
    <?php
        switch($_SERVER['SERVER_NAME']) {
            case SUBDOMAIN_901:
            case SUBDOMAIN_999:
                //Do nothing
                break;
            default:
                ?>
        <iframe src="/home?nojs=true&first_page=true" width="100%" height="200">No IFrames available</iframe>
        <?php } ?>
	</body>
</html>
