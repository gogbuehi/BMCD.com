function getModuleTemplateCallback(html){
    var flsh = getFlexRef();
    flsh.getModuleTemplateCallback(html);
}
function getModuleTemplateCallbackError(){
    var flsh = getFlexRef();
    flsh.getModuleTemplateCallbackError();
}
function getModuleTemplate(classname){
    var ajaxObj = {
        type:"POST",
        url:"/templates/"+classname+".html",
        //url:"http://" + gVars.HOSTNAME + "/templates/"+classname+".html",
        data:"",
        error:getModuleTemplateCallbackError,
        success:getModuleTemplateCallback,
        dataType:"text"
    }
    $.ajax(ajaxObj);	
}
function startAdmin(){
    var flsh = getFlexRef();
    flsh.startAdmin();
}

function endAdmin(){
	
	/* TODO: call the logout service */
	
    var flsh = getFlexRef();
    flsh.endAdmin();
}