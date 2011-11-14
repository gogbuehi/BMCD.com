function getJavascriptVersion(){
	var ver = {major:0,
			   minor:1,
			   revision:16};
	return ver;
}
/**
 * These funcitons are used to buld interaction with the Flash Container via ExternalInterface.
 * This Includes functions required to resize the SWF.
 */
function getWindow(){
	if(navigator.appName.indexOf("Microsoft") != -1){
        return window;
    }
    else{
        return document;
    }
}

function setWindowResizeListener(){
	if(navigator.appName.indexOf("Microsoft") != -1){
        window.onresize = windowResizeListener;
    }
    else{
        window.onresize = windowResizeListener;
    }
    //*/
}
function getWindowSize(){
	var obj;
	if(navigator.appName.indexOf("Microsoft") != -1){
        obj = {width:document.body.offsetWidth,height:document.body.offsetHeight}
    }
    else{
        obj = {width:window.innerWidth,height:window.innerHeight}
    }
    return obj;
}
function swfResizeEvent(obj){
	var flsh = getFlexRef();
	var wind = getWindowSize();
	if(wind.height <= obj.height){
		flsh.height = obj.height;
	} else {
		flsh.height = "100%";
	}
	if(wind.width <= obj.width){
		flsh.width = obj.width;
	} else {
		flsh.width = "100%";
	}
}
function windowResizeListener(){
	var sz = getWindowSize();
	if(sz.width!="100%" || sz.height!="100%"){
		var flx = getFlexRef();
		flx.reportWindowSize(sz);
	}
}