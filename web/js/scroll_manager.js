function setVScrollPosition (value) {
	window.scrollTo(scrollX(), value);
}
function setHScrollPosition (value) {
	window.scrollTo(value, scrollY());
}
function onScrollEvent(){
	var flsh = getFlexRef();
	var ws =  getWindowSize();
    flsh.setScrollPositionCallback(scrollX(),scrollY(),ws.width,ws.height);
}
window.onscroll = onScrollEvent;

function windowW(){return window.innerWidth ? window.innerWidth : document.body.clientWidth ? document.body.clientWidth : document.documentElement.clientWidth;}
function windowH(){return window.innerHeight ? window.innerHeight : document.body.clientHeight ? document.body.clientHeight : document.documentElement.clientHeight;} 

function scrollX() {return window.pageXOffset ? window.pageXOffset : document.body.scrollLeft ? document.body.scrollLeft : document.documentElement.scrollLeft;}
function scrollY() {return window.pageYOffset ? window.pageYOffset : document.body.scrollTop ? document.body.scrollTop : document.documentElement.scrollTop;}