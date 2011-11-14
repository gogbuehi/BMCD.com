/**
 * @author Goodwin Ogbuehi
 * September 20, 2008
 */
/*
 * Requires:
 *  - jQuery
 */

var nodeQuery = "div,h1,p,a,img,ul,li,h2,h3";
var idCounter = 1;
function assignId() {
	var aTitle = "temp" + (idCounter++);
	$(this).attr("title",aTitle);
}
/**
 * Create an associative array for a querystring
 * @param {String} querystring
 * @return (Array)
 */
function getAssocQuerystring(querystring) {
	var qArray = querystring.split(/&/g);
	var keyValuePair;
	var assocArray = new Array();
	for (var i = 0; i < qArray.length; i++) {
		keyValuePair = qArray[i].split(/=/);
		assocArray[keyValuePair[0]] = keyValuePair.length == 2 ? keyValuePair[1] : null;
	}
	return assocArray;
}
function processNode(aNode) {
	var actualNode = $(aNode);
	var nodeId = processAttribute(actualNode,'id');
	var nodeClass = processAttribute(actualNode,'class');
	var innerNodes = actualNode.find(nodeQuery);
	var content = innerNodes.length == 0 ? actualNode.html() : null;
	var parentNode = actualNode.parent().not("body");
	var parentNodeId,nextNodeId,childNodeId;
	if (parentNode.length == 0) {
		parentNodeId = null;
	}
	else {
		parentNodeId = parentNode.attr("id") == "" ? null : parentNode.attr("id");
	}
	var nextNode = actualNode.next();
	if (nextNode.length == 0) {
		nextNodeId = null;
	}
	else {
		nextNodeId = nextNode.attr("id") == "" ? null : nextNode.attr("id");
	}
	var childNode = actualNode.children(":first");
	if (childNode.length == 0) {
		childNodeId = null;
	}
	else {
		childNodeId = childNode.attr("id") == "" ? null : childNode.attr("id");
	}
	var attributes = {
		src:processAttribute(actualNode,"src"),
		href:processAttribute(actualNode,"href"),
		width:processAttribute(actualNode,"width"),
		height:processAttribute(actualNode,"height"),
		selected:processAttribute(actualNode,"selected")
	}
	
	var d = new Date();
	nodeServiceData = {
		tempId:actualNode.attr('title'),
		dt:parseInt(d.getTime()/1000),
		blnvalid:1,
		nclass:nodeClass,
		next:nextNodeId,
		inner:childNodeId,
		content:content,
		parent:parentNodeId,
		attributes:attributes
	};
	return nodeServiceData;
}
function processAttribute(node,attributeName) {
	return (node.attr(attributeName)=="") ? null : node.attr(attributeName);
}
var PAGE_URL = 'http://dev.local/thispage';
var PAGE_SERVICE_TEST_URL = 'http://dev.local/test/page'
var pageCalled = false;
var callbackCalled = false;
function getPage() {
	pageCalled = true;
	var data = {
		session_key:SESSION_KEY
	}
	$.post(PAGE_URL,data,getPage_callback,"html");
}
var pageData = null;
var pageNodes = null;
var requestData = {
	contentNodes:{},
	page_id:1,
	session_key:SESSION_KEY
};
function getPage_callback(data) {
	pageData = $(data);
	pageNodes = pageData.find(nodeQuery);
	pageNodes.each(assignId);
	pageNodes.each(saveNode);
	window.console.info(tostring(requestData));
}
/**
 * Prototype for making JS objects into JSON strings
 * Note: This does not work with arrays, currently
 */
var tostring = function(anObject) {
	var string = '';
	var comma = '';
	for (items in anObject) {
		if (items == 'tostring' || anObject[items] == null)
			continue;
		if (anObject[items].toString() == '[object Object]') {
			string += comma + items + ':' + tostring(anObject[items]);
		}
		else {
			string += comma + items + ':"' + anObject[items] + '"';
		}
		comma = ',';
	}
	return '{' + string + '}';
}
/**
 * Save the node data to a JSON object that will eventually get sent
 * to content_node_services.
 */
function saveNode() {
	
	var temp = processNode(this);
	requestData.contentNodes[temp.tempId] = temp;
	
	//$.post(PAGE_SERVICE_TEST_URL+'?do=addContentNodes',requestData,addContentNode_callback,"text"); //Use XML so that we can use jQuery to traverse the response
}
var nodeId=null;
var addedNodeCount = 0;
function addContentNode_callback(data) {
	//Need to determine response format
	var response = $(data);
	nodeId = response.find("id").text();
	var qArray = getAssocQuerystring(this.data);
	pageNodes.find("[title="+qArray['tempId']+"]").attr('id',nodeId);
	addedNodeCount++;
	if (addedNodeCount == pageNodes.length) {
		//All done... Time to update all the nodes
	}
}

//$(document).ready(getPage);

