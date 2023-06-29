function PanelDocStart(querySelector, DataTableObj, extraConfig){
    PanelObj.apply(this, [querySelector, extraConfig]);
    
    var loadDoc  = new FormLoadDocument("FdocStart");
    var tableObj = DataTableObj;
    
    this.init = function(parentObj){
        this.setForm(loadDoc, loadDoc.querySelector);
        this.setTable(tableObj, tableObj.querySelector);
        
        PanelObj.prototype.init.apply(this, [parentObj]);
    };
};
PanelDocStart.prototype = new PanelObj();

function PanelHistory(querySelector, DataTableObj, extraConfig){
    PanelObj.apply(this, [querySelector, extraConfig]);
    
    var tableObj     = DataTableObj;
    var modalHistory = new ModalForm("modal-win-info-add-history", "FormAddHistory", this.jQueryObj.find("[data-action='add-history']"), 
    function(_this){
        
        var initDocAjax = new InitialDocAjax("inmail/initDocumentArea", {method: "POST", async: false});
        initDocAjax.setData({status_id: 10});
        var dataDoc = initDocAjax.sendAjax();
                
        _this.form.setValue(dataDoc.docData);
        ModalObj.prototype.showModal.apply(_this);
    });
    
    this.init = function(parentObj){        
        this.setTable(tableObj, tableObj.querySelector);
        this.setModal(modalHistory, modalHistory.querySelector);
        
        PanelObj.prototype.init.apply(this, [parentObj]);
    };
};
PanelHistory.prototype = new PanelObj();