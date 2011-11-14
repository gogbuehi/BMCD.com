var BrowserManager = {
    MAX_HISTORY:100,
    IFRAME_QUERYSTRING:"?nojs=true&nopage=true",
    history:new Array(),
    currentIndex:-1,

    noJS:false,

    savedHash:"",

    activate:function() {
        if($.browser.msie) {
            this.log("This is an IE Browser");
            history.back = this.back;
            history.forward = this.forward;
        }
        else if (window.top.location.hostname != gVars.HOSTNAME && window.top.location.hostname != ("www." + gVars.HOSTNAME)){
            this.log("This is NOT an IE Browser");
            if (window.top.location == document.location && this.getQuerystring("first_page") == "true") {
                //redirect the top location, without the querystring
                var newUrl = window.top.location.protocol + "//" + window.top.location.hostname + "/#" + window.top.location.pathname;
                window.top.location = newUrl;
            }
        }

        this.savedHash = this.getCurrentHash();
        this.checkSession();
        if (window.top.location.hostname != gVars.HOSTNAME && window.top.location.hostname != ("www." + gVars.HOSTNAME)) {
            if (!this.noJS) {
                this.initIframe();

            }
            this.redirectHash();
            if (!this.noJS) {
                this.watchHash();
            }
        }
    },
    initIframe:function() {
        this.log("Initializing IFrame...");
        var topUri = window.top.location.hash.replace("#","");
        $("iframe").attr("src",window.top.location.protocol + "//" + window.top.location.hostname + topUri + BrowserManager.IFRAME_QUERYSTRING);
        /*
        if (this.getQuerystring("first_page")== "true") {
            //Set the iframe to match the main page's hash
            this.log("Setting the IFrame to match the main page's hash");
            
            document.location.href = topUri + BrowserManager.IFRAME_QUERYSTRING;
        }
        */
    },
    emailSent:function() {

    },
    submitFormData:function(data) {
        this.log("Sending email data...");
        data.d_uri = this.getCurrentHash();
        var uri = '/email';
        $.post(uri,data,emailSent,"text");
        return true;
    },
    watchHash:function() {
    	//this.log("WatchHash: " + this.savedHash + " - " + this.getCurrentHash())
        if (!this.noJS && this.savedHash != this.getCurrentHash()) {
            this.savedHash = this.getCurrentHash();
            this.getPage(this.savedHash);
        }
        setTimeout("BrowserManager.watchHash()",500);
    },
    redirectHash:function() {
        var uri = document.location.pathname;
	if (uri == '/' || window.location.hash != '' || this.noJS) {
            //Just read the hash
            if (($.browser.msie) && this.noJS && (this.getQuerystring("first_page") !== true) && (window.top.location.hash !== ("#" + document.location.pathname))) {
                BrowserManager.log("--");
                BrowserManager.log("Document Location: " + document.location.pathname);
                BrowserManager.log("Window Location: " + window.top.location.hash);
                BrowserManager.log("--");
                window.top.location.href = window.top.location.protocol + "//" + window.top.location.hostname + "/#" +  document.location.pathname;
            }
        }
        else if (uri == '/' && window.top.location.hash == '' && !this.noJS) {
        	//default to the home page
        	this.getPage("/home");
        }
        else {
            window.location = '/#' + uri;
        }
    },
    setBrowserHash:function(uri) {
        window.top.location.hash = "#" + uri;
    },
    getCurrentHash:function() {
        return window.top.location.hash.replace("#","");
    },
    setHash:function(uri) {
        //Set the iframe to the page, as well
        this.log("Setting hash to " + uri);
        if($.browser.msie) {
	        var iframe = $("iframe");
	        if (iframe.attr("src") !== uri + BrowserManager.IFRAME_QUERYSTRING) {
	            iframe.attr("src",uri + BrowserManager.IFRAME_QUERYSTRING);
	        }
        }
        window.location.hash = "#" + uri;
        this.savedHash = uri;
    },
    getPage:function(uri) {
        this.log("Getting page: " + uri);

        var currentUri = getCurrentHash();
        if(uri==""){
            this.log("The requested URI is blank");
            //This situation shouldn't come up
            if(window.top.location.pathname.length>1){
                uri=window.top.location.pathname+currentUri;
            } else {
                uri = currentUri;
            }
        }
        //Process the Uri to request (now stored in "currentUri")
        currentUri = uri;
        if(currentUri=="" || currentUri == "/"){
            //If blank or requesting just a slash, get "/home"
            currentUri = "/home";
        }
        else if(currentUri.indexOf('http://'+location.host)==0){
        	//If an absolute URL os provided for this same site, convert to a relative URL and use Hash.
        	currentUri = currentUri.replace('http://'+location.host,"");
        	uri = currentUri;
        	
        } else if(currentUri.indexOf('http://'+gVars.HOSTNAME)==0 ||
            currentUri.indexOf('http://'+gVars.CONTENT)==0 ||
            currentUri.indexOf('http://'+gVars.SUBDOMAIN_901)==0 ||
            currentUri.indexOf('http://'+gVars.SUBDOMAIN_999)==0){
            this.log("Opening [" + currentUri + "] in the current window");
            //If an absolute URL is provided, within our expected domains,
            //then just redirect the browser to that URL
            window.location = currentUri;
            return;
        }
        else if (currentUri.indexOf('http')==0) {
            this.log("Opening [" + currentUri + "] in a new window.");
            //If it is some other Absolute URL, open it in a new window
            var flsh = getFlexRef();
            flsh.getPageCallbackError(currentUri,"External Link");
            var myWin = window.open(''+currentUri,"newwin");
            myWin.focus();
            return;
        }
        
            this.log("Making AJAX call for [" + currentUri + "]");
            var scope = {
                data:"",
                uri:currentUri,
                supplemental:null,
                get404Page:function() {
                    BrowserManager.getPage('/not_found?fl=drop');
                },
                getPageCallback:function(uri,newHtml,supplemental){
                    BrowserManager.log("getPageCallback called for uri[" + uri + "]");
                    var flsh = getFlexRef();
                    if(newHtml=="Error"){
                        flsh.getPageCallbackError(uri,newHtml);
                    } else {
                        flsh.getPageCallback(uri,{page:newHtml,suplimental:supplemental});
                    }

                    BrowserManager.setHash(uri);
                }
            }
            scope.getPageHTML = function(newHtml) {
                scope.getPageCallback(scope.uri,newHtml,scope.supplemental);
            };
            var ajaxObj = {
                type:"POST",
                url:scope.uri,
                data:scope.data,
                error:scope.get404Page,
                success:scope.getPageHTML,
                dataType:"text"
            }
            $.ajax(ajaxObj);

            gTrack(currentUri);
            cTrack(currentUri);
        
    },
    setPageTitle:function(title) {
        document.title = title;
    },
    /**
     * This function is intended to be used by the admin to send the new page html to the server
     */
    setPage:function(uri,html,session_id,hasDynamicContent) {
        this.log("Attempting to save a new version of the page...");
        var scope = {
            result:null,
            uri:uri,
            html:html,
            displayResult:function(dataObj) {
                this.result = dataObj;
                //Service call is complete
                //"scope" should have the result in it
                var messages = this.result["#document"].response.messages;

                var flsh = getFlexRef();
                if(messages.action === undefined){
                    flsh.setPageCallbackError(this.uri,messages.error);
                } else {
                    flsh.setPageCallback(this.uri,this.html);
                }
            }
        }
        //Send request to page cache updating service
        ServiceHandler.init();
        ServiceHandler.setServiceName('SavePageService');
        var paramsObj = {
            uri:uri,
            pageContent:html,
            hasDynamicContent:hasDynamicContent
        };
        ServiceHandler.setParams(paramsObj);

        ServiceHandler.setExternalCallback(scope, scope.displayResult);

        ServiceHandler.sendRequest();

    },
    getQuerystring:function(field) {
        var qstring = ''+document.location.search;
        qstring = qstring.replace('?', '');
        var tempArray = qstring.split('&');
        var fieldValueArray;
        for (var i = 0; i < tempArray.length; i++) {
            fieldValueArray = tempArray[i].split("=");
            if (fieldValueArray[0] == field) {
                return (fieldValueArray.length > 1 ? fieldValueArray[1] : '');
            }
        }
        return null;
    },
    checkSession:function() {
        if (this.getQuerystring('admin')=='no-js') {
            this.noJS = true;
            return;
        }
        if (this.getQuerystring("nojs")=="true") {
            this.noJS = true;
            return;
        }
        var cookieString = document.cookie;
        var cookieArray = cookieString.split(';');
        var assocArray = new Array();
        var temp,tempArray;
        var tempString = '';
        for (var i=0; i < cookieArray.length; i++) {
            temp = cookieArray[i];
            tempArray = temp.split('=');
            if (tempArray.length > 1) {
                assocArray[$.trim(tempArray[0])] = $.trim(tempArray[1]);
            }
            else {
                assocArray[$.trim(tempArray[0])] = '';
            }
        tempString += '[' + tempArray[0] + ':' + assocArray[tempArray[0]] + ']';
        }
        if (assocArray['admin']=='no-js') {
            //Do not redirect
            this.noJS = true;
        }
    },
    traverse:function(indexOffset) {
        this.currentIndex += indexOffset;
        var uri = this.history[this.currentIndex];
        window.location.href = "#" + uri;
    },
    addHash:function(uri) {
        if (this.currentIndex < (this.history.length + 1)) {
            this.history = this.history.splice(0,this.currentIndex);
        }
        this.history.push(uri);
        if (this.history.length > BrowserManager.MAX_HISTORY) {
            //Remove the first entry
            this.history.shift();
        }
        else {
            this.currentIndex++;
        }
    },
    //Archive functions
    archive_go:history.go,
    //Contextual Functions
    go:function(arg) {
        if (arg === -1) {
            if (BrowserManager.currentIndex > 0) {
                //Go back using our own History Cache

                return true;
            }
            else {
                //Use the browser's Back feature
                BrowserManager.archive_go(-1);
                return false;
            }

            return true;
        }
        else if (arg === 1) {
            var goToIndex = BrowserManager.currentIndex + 1;
            if (goToIndex < BrowserManager.history.length) {
                //Go forward using our own History Cache
                return true;
            }
            else {
                //Use the browser's Forward feature
                BrowserManager.archive_go(1);
                return false;
            }

            return true;
        }
        else {
            //Assume a URI was passed in
            //Consider that "setPage()" should be in this class
            BrowserManager.setHash(arg);
            return true;
        }
        return false;
    },
    back:function() {
        BrowserManager.go(-1);
    },
    forward:function() {
        BrowserManager.go(1);
    },
    //Utility Functions
    log:function(msg) {
    	var preMsg = "TOP: ";
        if ($("iframe").length == 0) {
            preMsg = "IFRAME: ";
        }
        if (window.console !== undefined && window.console.log !== undefined) {
            //Check for an iframe
            
            window.console.log(preMsg + msg);
        }
	/*
        if($.browser.msie) {
    		if (window.ieLog == undefined) {
    			window.ieLog = window.open("","IELog");
    		}
    		window.ieLog.document.write(preMsg + msg + "<br />");
    	}
	   */
    }
}