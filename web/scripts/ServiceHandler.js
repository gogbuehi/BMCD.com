var ServiceHandler = {
    SERVICE_ADDRESS:"/service",
    name:"",
    type:"xml",
    params:{},
    externalScope:{},
    external_callback:function() {},
    init:function() {
        this.name = "";
        this.type = "xml";
        this.params = {};
        this.externalScope = {};
        this.external_callback = function() {};
    },
    setServiceName:function(name) {
        this.name = name;
    },
    addParam:function(field,value) {
        this.params[field] = value;
    },
    setParams:function(paramsObj) {
        this.params = paramsObj;
    },
    setExternalCallback:function(scope,callbackFunction) {
        this.externalScope = scope;
        this.external_callback = callbackFunction;
    },
    sendRequest:function() {
        var self = this;
        var params = {
            request: {
                params:this.params
            }
        };
        var xmlParams = new XML.ObjTree();
        var requestParams = {
            service:this.name,
            type:this.type,
            params:xmlParams.writeXML(params)
        };
        var callbackFunction = function(data,status) {
            self.sendRequest_callback(data,status);
        };
        $.post(this.SERVICE_ADDRESS,requestParams,callbackFunction,this.type);
    },
    sendRequest_callback:function(data,status) {
        if (status === "success") {
            this.processResponse(data);
        }
        else {
            this.processError(data);
        }
    },
    processResponse:function(responseData) {
        var xmlObj = new XML.ObjTree();
        var dataObj = xmlObj.parseDOM(responseData);

        //Call the external callback. It should be expecting an object
        this.external_callback.call(this.externalScope,dataObj);
        

    },
    processError:function(responseData) {
        alert('There was an error sending the request. Please try again. If this issue persists, please contact: engineering@hphant.com.');
    },
    testRequest:function() {
        var serviceName="testService";
        var serviceType = "xml";
        var params = {
            request:{
                params:{
                    a:'First',
                    b:'Second'
                }
            }
        };
        var xmlParams = new XML.ObjTree();
        var request = {
            service:serviceName,
            type:serviceType,
            params:xmlParams.writeXML(params)
        };
        $.post("/service", request, ServiceHandler.testRequest_callback, serviceType);

    },
    testRequest_callback:function(arg1,arg2) {
        var message = "ameesage";
        //this.testMethod();
    },
    testMethod:function() {

    }
}