function TableDocStart(querySelector, extraConfig){
    DataTableObj.apply(this, [querySelector, extraConfig]);
    
    var __viewerAjax = new ViewerAjax("pendingdoc/getFilesData", {method: "POST"});
    this.modals      = {assing : new ModalForm("modal-win-info-assing", "FormAssing"), 
                        replace: new ModalForm("modal-win-info-replace", "FormReplace")};
    
    this.viewer         = function(){        
        var data = {control_folio : $(this).data("document")};
        
        __viewerAjax.setData(data);
        __viewerAjax.sendAjax();
    };
    this.assingForm     = function(_this){
        var data = _this.startPanelFn.apply(this, arguments);
        if(!data)return;

        _this.modals.assing.setTitle(data.control_folio);
        _this.modals.assing.form.setValue("numDocument", data.control_folio);
        _this.modals.assing.showModal();
    };
    this.replaceReceipt = function(_this){
        var data = $(this).data("document");
        
        _this.modals.replace.jQueryObj.find(".folio-doc").text(data);
        _this.modals.replace.setTitle(data);
        _this.modals.replace.form.setValue("numDocument", data);
        _this.modals.replace.showModal();
    };
    this.infoCallBack   = function(){        
        this.jQueryObj.children("tbody").off("click", "td", $.proxy(this.assingForm));
        this.jQueryObj.children("tbody").on("click", "td", $.proxy(this.assingForm, null, this));
        $("a[data-preview]").off("click", $.proxy(this.viewer));
        $("a[data-preview]").on("click", $.proxy(this.viewer, null, this));
        $("a[data-delete]").off("click", $.proxy(this.replaceReceipt));
        $("a[data-delete]").on("click", $.proxy(this.replaceReceipt, null, this));
    };
    this.init           = function(parentObj){
        for(var key in this.modals){this.modals[key].init(this);}
        DataTableObj.prototype.init.apply(this, [parentObj]);
    };
};
TableDocStart.prototype = new DataTableObj();

function TableHistory(querySelector, extraConfig){
    DataTableObj.apply(this, [querySelector, extraConfig]);
    
    var __viewerAjax = new ViewerAjax("inmail/getFileToView", {method: "POST"});
    var __sendMail   = new SendMailAjax("inmail/sendMailDefeated", {method: "POST", async: false});
    this.modals      = {acknowledgment: new ModalForm("modal-win-info-acknowledgment", "FormAcknowledgment")};
    
    this.viewer                = function(acknowledgment){
        
        var data = {"control_folio" : $(this).data("document")};

        if(acknowledgment === 1){
            data["acknowledgment_document"] = acknowledgment;
        }else{
            data["check_document"]          = 0;
            data["acknowledgment_document"] = 0;
            data["final_document"]          = typeof acknowledgment === 'object' ? 0 : 1;
        }
        
        __viewerAjax.setData(data);
        __viewerAjax.sendAjax();
    };
    this.acknowledgmentReceipt = function (_this){
    
        var data = $(this).data("document");

        _this.modals.acknowledgment.jQueryObj.find(".folio-doc").text(data);

        _this.modals.acknowledgment.setTitle(data);
        _this.modals.acknowledgment.form.setValue("numDocument", data);
        _this.modals.acknowledgment.showModal();
    };
    this.defeatedReminder      = function (){
        
        var data = {"folioInDoc" : $(this).data("document")};
        
        __sendMail.setData(data);
        __sendMail.sendAjax();    };
    this.infoCallBack          = function(){
        $("a[data-initial]").off("click", $.proxy(this.viewer));
        $("a[data-initial]").on("click", $.proxy(this.viewer, null));
        $("a[data-download]").off("click", $.proxy(this.acknowledgmentReceipt));
        $("a[data-download]").on("click", $.proxy(this.acknowledgmentReceipt, null, this));
        $("a[data-response]").off("click", $.proxy(this.viewer));
        $("a[data-response]").on("click", $.proxy(this.viewer, null, 0));
        $("a[data-acknowledgment]").off("click", $.proxy(this.viewer));
        $("a[data-acknowledgment]").on("click", $.proxy(this.viewer, null, 1));
        $("a[data-defeated]").off("click", $.proxy(this.defeatedReminder));
        $("a[data-defeated]").on("click", $.proxy(this.defeatedReminder, null));
    };
    this.init                  = function(parentObj){
        for(var key in this.modals){this.modals[key].init(this);}
        DataTableObj.prototype.init.apply(this, [parentObj]);
    };
};
TableHistory.prototype = new DataTableObj();