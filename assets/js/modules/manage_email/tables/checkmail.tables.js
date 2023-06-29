function TableCheck(querySelector, extraConfig){
    DataTableObj.apply(this, [querySelector, extraConfig]);
    
    var antecedentsAjax  = new AntecedentsAjax("checkmail/getAntecedents", {method: "POST"});
    var getFilesDataAjax = new GetFilesDataAjax("pendingdoc/getFilesData", {method: "POST"});
    var setViewDocAjax   = new SetViewDocAjax("pendingdoc/setViewDocument", {method: "POST"});
    
    this.viewerPanel = new PanelForm("view-doc", "FormInbox");
    
    this.loadAntecedents = function(_this){    
        var data = _this.startPanelFn.apply(this, arguments);
        if(!data || data.antecedent.length === 0)return;

        $(".antecedent-panel").css("display", "inline-block");
        $(".antecedent-panel").find(".x_content").css("display", "block");
        
        antecedentsAjax.setData({documentId: data.control_folio});
        antecedentsAjax.sendAjax();
    };
    this.clearAntecedent = function(){
        var $antecedent = $(".antecedent-panel");
        $collapse       = $antecedent.find(".collapse-link i");
        $content        = $antecedent.find(".x_content");

        $antecedent.find(".wizard_steps").empty();
        $collapse.removeClass("fa-chevron-down").addClass("fa-chevron-up");
        $content.css("display", "none");
    };
    this.setView         = function(controlFolio){
        setViewDocAjax.scope = this;
        setViewDocAjax.setData({control_folio : controlFolio});
        setViewDocAjax.sendAjax();
    };
    this.setFilesData    = function (controlFolio){
        getFilesDataAjax.scope = this.parentObj.parentObj;
        getFilesDataAjax.setData({control_folio : controlFolio});
        getFilesDataAjax.sendAjax();
    };
    this.openViewer      = function (_this){
        var data = _this.startPanelFn.apply(this, arguments);
        if(!data){ _this.responsiveView = true; return;}
        
        _this.parentObj.parentObj.showPanel(_this.viewerPanel.jQueryObj);
        _this.setView(data.control_folio);
        _this.setFilesData(data.control_folio);
        
        _this.viewerPanel.jQueryObj.find("[data-buttons]").css("display", "block");        
        
        _this.viewerPanel.forms["view-doc"].dataMemory = data;
        _this.viewerPanel.forms["view-doc"].setValue(data);
    };
    this.infoCallBack    = function(){
        this.jQueryObj.children("tbody").off("click", "td", $.proxy(this.openViewer));
        this.jQueryObj.children("tbody").off("click", "td", $.proxy(this.loadAntecedents));
        this.jQueryObj.children("tbody").on("click", "td", $.proxy(this.openViewer, null, this));
        this.jQueryObj.children("tbody").on("click", "td", $.proxy(this.loadAntecedents, null, this));
    };
    this.init            = function(parentObj){
        this.viewerPanel.init(this);
        DataTableObj.prototype.init.apply(this, [parentObj]);
    };
};
TableCheck.prototype = new DataTableObj();