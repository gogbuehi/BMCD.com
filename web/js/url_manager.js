/**
 * @author Developer
 */
function submitFormData(data){
    return BrowserManager.submitFormData(data);
}
function emailSent() {
    BrowserManager.emailSent();
}
function redirect_hash() {
   BrowserManager.redirectHash();
}

function getCurrentHash() {
	return BrowserManager.getCurrentHash();
}
function setHash(uri) {
    BrowserManager.setHash(uri);
}
function getPage(uri){
	BrowserManager.getPage(uri);
}
function setCurrentTitle(text) {
    document.title = text;
}
/**
 * This function is intended to be used by the admin to send the new page html to the server
 */
function setPage(uri,html,session_id,hasDynamicContent){
    BrowserManager.setPage(uri, html, session_id, hasDynamicContent);
}
function getQuerystrying(field) {
    return BrowserManager.getQuerystring(field);

}
$(document).ready(function() {
    try {
        BrowserManager.activate();
    }
    catch(e) {
        $.getScript("http://" + gVars.HOSTNAME + "/scripts/BrowserManager.js",
        	function () {
        		BrowserManager.activate();
        });
    }
    try {
        PermissionManager;
    }
    catch(e) {
        $.getScript("http://" + gVars.HOSTNAME + "/scripts/PermissionManager.js");
    }
    //redirect_hash();
});
