/*
//Testing page cache updating
ServiceHandler.init();
ServiceHandler.setServiceName('SavePageService');
var paramsObj = {
    uri:'/test/flash/cache',
    pageContent:'<html><head><title>Test Page 2</title></head><body>This is a test page, part 2.</body></html>',
    hasDynamicContent:'false'
};
ServiceHandler.setParams(paramsObj);
var scope = {
    result:null,
    displayResult:function(dataObj) {
        this.result = dataObj;
    }
}
ServiceHandler.setExternalCallback(scope, scope.displayResult);

ServiceHandler.sendRequest();
/*
ServiceHandler.init();
ServiceHandler.setServiceName('LoginService');
var paramsObj = {
    username:'test',
    password:'PASSWORD',
    domain:'901.bmcd.loc'
};
ServiceHandler.setParams(paramsObj);
var scope = {
    result:null,
    displayResult:function(dataObj) {
        this.result = dataObj;
    }
}
ServiceHandler.setExternalCallback(scope, scope.displayResult);

ServiceHandler.sendRequest();
*/
/*
//Test encryption
var FieldManager = {
    listenField:null,
    literalField:null,
    encryptedField:null,
    setListenField:function(listenFieldId) {
        this.listenField = this.retrieveField(listenFieldId);
    },
    setLiteralField:function(literalFieldId) {
        this.literalField = this.retrieveField(literalFieldId);
    },
    setEncryptedField:function(encryptedFieldId) {
        this.encryptedField = this.retrieveField(encryptedFieldId);
    },
    retrieveField:function(fieldId) {
        var results = $.find("input#" + fieldId);
        return $(results);
    },
    activate:function() {
        var self = this;
        var field1 = $(this.listenField);
        field1.keyup(function() {
            self.processInput();
        });
    },
    processInput:function() {
        var input = this.listenField.val();
        if (input == "") {
            this.setLiteralFieldText("");
            this.setEncryptedFieldText("");
        }
        else {
            this.setLiteralFieldText(input);
            this.setEncryptedFieldText(Encryption.encryptString(input));
        }
    },
    setLiteralFieldText:function(text) {
        this.literalField.val(text);
    },
    setEncryptedFieldText:function(text) {
        this.encryptedField.val(text);
    }

}
Encryption.retrieveAlphaMap();
Encryption.retrieveCharacterMap();

$(document).ready(function(){

    FieldManager.setListenField("password");
    FieldManager.setLiteralField("literalField");
    FieldManager.setEncryptedField("encryptedField");
    FieldManager.activate();
});
*/
/*
//Test message box
$(document).ready(function() {
    MessageBox.activate();

    MessageBox.openMessage("login", "Testing message box", MessageBox.TYPE_INFO);
});
*/