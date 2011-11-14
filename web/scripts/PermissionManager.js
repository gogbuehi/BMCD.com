var PermissionManager = {
    activateLoginFields:function() {
        //check if ?logout requested
        if (getValues['logout']==='') {
            getValues['logout']=null;
            window.location.search = remakeQuerystring(getValues);
        }

        var self = this;
        var usernameField = $.find("input#username");
        var passwordField = $.find("input#password");
        var domainField = $.find("input#domain");
        var loginForm = $.find("form#loginForm");

        var logoutLink = $.find("a#logoutLink");

        //Add listener to submit button
        $(loginForm).submit(function() {
            //Retrieve fields
            var username = $(usernameField).val();
            var password = $(passwordField).val();
            $(domainField).val(window.location.hostname);
            var domain = $(domainField).val();

            //Validate fields
            var msgs = self.validateFields(username, password, domain);
            if (msgs.length > 0) {
                self.displayMessage(msgs,MessageBox.TYPE_ERROR);
                return false;
            }
            //Submit the form to Login
            self.sendLoginRequest(username,password,domain,false);
            return false;
        });
        //Add a listener to the logout link
        $(logoutLink).click(function() {
            self.sendLogoutRequest(false);
            return false;
        });
        //determine destination
        if (getValues["destination"] !== null && getValues["destination"] !== undefined) {
            this.destination = unescape(getValues["destination"]);
        }
    },
    sendLoginRequest:function(username,password, domain,useFlashScope) {
        var scope = this.flashScope;
        if (useFlashScope !== null && useFlashScope === false){
            scope = this.loginScope;
        }
        scope.username = username;
        scope.domain = domain;
        //Send request to page cache updating service
        ServiceHandler.init();
        ServiceHandler.setServiceName('LoginService');
        var paramsObj = {
            username:username,
            password:password,
            domain:domain
        };
        ServiceHandler.setParams(paramsObj);

        ServiceHandler.setExternalCallback(scope, scope.displayResult);

        ServiceHandler.sendRequest();
    },
    sendLogoutRequest:function(useFlashScope) {
        var scope = this.flashScope;
        if (useFlashScope !== null && useFlashScope === false){
            scope = this.logoutScope;
        }
        //Send request to page cache updating service
        ServiceHandler.init();
        ServiceHandler.setServiceName('LogoutService');
        var paramsObj = {
        };
        ServiceHandler.setParams(paramsObj);

        ServiceHandler.setExternalCallback(scope, scope.displayResult);

        ServiceHandler.sendRequest();
    },
    sendAccountUpdateRequest:function(oldPassword,newPassword,newPasswordConfirm, domain,useFlashScope) {
        var scope = this.flashScope;
        if (useFlashScope !== null && useFlashScope === false){
            scope = this.loginScope;
        }
        //scope.username = username;
        //scope.domain = domain;
        //Send request to page cache updating service
        ServiceHandler.init();
        ServiceHandler.setServiceName('ChangePasswordService');
        var paramsObj = {
            password:oldPassword,
            newPassword:newPassword,
            newPasswordConfirm:newPasswordConfirm,
            domain:domain
        };
        ServiceHandler.setParams(paramsObj);

        ServiceHandler.setExternalCallback(scope, scope.displayResult);

        ServiceHandler.sendRequest();
    },
    sendPasswordRequest:function(username, domain,useFlashScope) {
         var scope = this.flashScope;
        if (useFlashScope !== null && useFlashScope === false){
            scope = this.loginScope;
        }
        ServiceHandler.init();
        ServiceHandler.setServiceName('ForgotPasswordService');
        var paramsObj = {
            username:username
        };
        ServiceHandler.setParams(paramsObj);

        ServiceHandler.setExternalCallback(scope, scope.displayResult);

        ServiceHandler.sendRequest();
    },
    getFlashScope:function(){
    	return this.flashScope;
    },
    flashScope:{
        result:null,
        username:null,
        domain:null,
        messages:null,
        destination:null,
        displayResult:function(dataObj) {
            this.result = dataObj;
            this.messages = this.result["#document"].response.messages;
            var callbackObj = {
                serviceName:this.result["#document"].response.params.serviceName,
                messageType:null,
                message:null
            }
            if(this.messages.action === undefined) {
                callbackObj.messageType = MessageBox.TYPE_ERROR;
                callbackObj.message = this.messages.error;
            } else {
                callbackObj.messageType = MessageBox.TYPE_INFO
                callbackObj.message = this.messages.action;
            }
            //PermissionManager.displayFlashMessage(callbackObj);
            //Call flash callbackMethod()
            getFlexRef().callbackMethod(callbackObj);
        }

    },
    loginScope:{
        result:null,
        username:null,
        domain:null,
        messages:null,
        destination:null,
        displayResult:function(dataObj) {
            this.result = dataObj;
            //Service call is complete
            //"scope" should have the result in it
            this.messages = this.result["#document"].response.messages;
            
            if(this.messages.action === undefined) {
                PermissionManager.displayMessage(this.messages.error,MessageBox.TYPE_ERROR);

            } else {
                PermissionManager.displayMessage(this.messages.action,MessageBox.TYPE_INFO);
                var loginForm = $.find("form#loginForm");
                var logoutForm = $.find("div#logout");
                $(loginForm).hide("fast");
                loginForm[0].reset();
                $(logoutForm).show("slow");
            }
        }
    },
    logoutScope:{
        result:null,
        messages:null,
        displayResult:function(dataObj) {
            this.result = dataObj;
            this.messages = this.result["#document"].response.messages;
            if(this.messages.action === undefined) {
                PermissionManager.displayMessage(this.messages.error,MessageBox.TYPE_ERROR);
            } else {
                PermissionManager.displayMessage(this.messages.action,this.proceedToDestination,MessageBox.TYPE_INFO);
                var loginForm = $.find("form#loginForm");
                var logoutForm = $.find("div#logout");
                loginForm[0].reset();
                $(loginForm).show("slow");
                $(logoutForm).hide("fast");
            }
        }
    },
    displayMessage:function(messages,messageType,followUpFunction,followUpScope) {
        var messageConsolidation = "";
        if (messages === String(messages)) {
            messageConsolidation = messages;
        }
        else {
            for(message in messages) {
                messageConsolidation += ": " + messages[message] + "<br />";
            }
        }
        MessageBox.openMessage("login", messageConsolidation, messageType,5000);
        /*
        if (followUpFunction != null) {
            if (followUpScope == null) {
                followUpScope = this;
            }
            followUpFunction.call(followUpScope);
        }
        */
    },
    validateFields:function(username,password,domain) {
        var messages = new Array();
        //Username validation
        if (username == "") {
            messages[messages.length] = "Username is blank.";
        }
        else if (username.length < 3) {
            messages[messages.length] = "Username is invalid; Should be longer than 3 characters";
        }
        if (password == "") {
            messages[messages.length] = "Password is blank.";
        }
        if (domain == "") {
            messages[messages.length] = "System error. Please contact the system administrator if this message persists.";
        }
        return messages;
    },
    proceedToDestination:function() {
        if (this.destination == null) {
            //Go home
            window.location = "/home";
        }
        else {
            window.location = this.destination;
        }
    }
}