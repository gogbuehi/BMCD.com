var MessageBox = {
    TYPE_INFO:1,
    TYPE_ERROR:2,
    boxes:new Array(),
    activate:function() {
        var self = this;
        this.boxes = $.find("div.messageBox");
        var closeButtons = $(this.boxes).find("input.closeButton");
        $(closeButtons).click(function() {
            var messageBox = $(this).parents("div.messageBox");
            self.closeMessage($(messageBox));
            return false;
        });

        $(this.boxes).each(function(i) {
            self.setMessageType($(this),"default");
        });
    },
    openMessage:function(messageBoxId,message,messageType,delay) {
        if (messageType == null) {
            messageType = this.TYPE_INFO;
        }
        var jBox = $($(this.boxes).filter("#"+messageBoxId));
        //Set message type
        this.setMessageType(jBox, messageType);
        //Set message
        this.setMessageText(jBox, message);
        //Display message
        jBox.show("slow");

        //Does the message auto-disappear?
        if (delay !== null) {
            jBox.bind('closeMessage',
                function() {
                    $(this).hide("slow");
                });
            setTimeout("$.event.trigger('closeMessage')",delay);
        }

    },
    setMessageType:function(jMessageBox,messageType) {
        var jCloseButton = $(jMessageBox.find("input.closeButton"));
        switch(messageType) {
            case this.TYPE_ERROR:
                jMessageBox.css(this.getErrorMessageCss());

                jCloseButton.attr('src','http://' + gVars.HOSTNAME + '/assets/images/CloseButton_red.jpg');
                break;
            case this.TYPE_INFO:
                jMessageBox.css(this.getInfoMessageCss());
                jCloseButton.attr('src','http://' + gVars.HOSTNAME + '/assets/images/CloseButton_green.jpg');
                break;
            default:
                jMessageBox.css({
                    color:"blue",
                    fontWeight:"bold",
                    backgroundColor:"#A0A0F0",
                    border:"solid 1px blue",
                    padding:"2px"
                });
                jCloseButton.attr('src','http://' + gVars.HOSTNAME + '/assets/images/CloseButton_blue.jpg');
        }
    },
    setMessageText:function(jMessageBox,messageText) {
        var jMessageTextBox = $(jMessageBox.find("div.messageField"));
        jMessageTextBox.html(messageText);
    },
    getInfoMessageCss:function() {
        return {
            color:"green",
            fontWeight:"bold",
            backgroundColor:"#A0F0A0",
            border:"solid 1px green",
            padding:"2px"
        };
    },
    getErrorMessageCss:function() {
        return {
            color:"red",
            fontWeight:"bold",
            backgroundColor:"#F0A0A0",
            border:"solid 1px red",
            padding:"2px"
        };
    },
    closeAllMessages:function() {
        $(this.boxes).hide("fast");
    },
    closeMessage:function(jMessageBox) {
        jMessageBox.hide("slow");
    }
}