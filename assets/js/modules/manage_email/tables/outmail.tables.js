function TableDocOut(querySelector, extraConfig){
    DataTableObj.apply(this, [querySelector, extraConfig]);
    
    var __viewerAjax = new ViewerAjax("pendingdoc/getFilesData", {method: "POST"});
    this.modals = {outdoc : new ModalForm("modal-win-info-response", "FormOut")};
    
    this.setFilesData = function(){
    
        var data = {control_folio : $(this).data("document")};
        
        __viewerAjax.setData(data);
        __viewerAjax.sendAjax();
    };
    
    this.viewer       = function(_this){        
        var data = _this.startPanelFn.apply(this, arguments);    
        if(!data)return;

        var formData = new FormData();

        formData.append("docOut", data.docOut);
        
        _this.modals.outdoc.form.dataMemory = formData;

        _this.modals.outdoc.setTitle("Documento de salida");
        _this.modals.outdoc.jQueryObj.find("ol b").text(data.docOut);
        _this.modals.outdoc.showModal();
    };
    this.infoCallBack = function(){        
        this.jQueryObj.children("tbody").off("click", "td", $.proxy(this.viewer));
        $("a[data-document]").off("click", $.proxy(this.setFilesData));
        this.jQueryObj.children("tbody").on("click", "td", $.proxy(this.viewer, null, this));
        $("a[data-document]").on("click", $.proxy(this.setFilesData, null, this));
    };
    this.init         = function(parentObj){
        for(var key in this.modals){this.modals[key].init(this);}
        DataTableObj.prototype.init.apply(this, [parentObj]);
    };
};
TableDocOut.prototype = new DataTableObj();