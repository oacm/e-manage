function PanelInbox(querySelector){
    PanelObj.apply(this, [querySelector]);
    
    var tableObj    = new TableInbox("Tinbox", {
        ajax       : {url: "pendingdoc/getTable", method: "POST"},
        columns    : [{"data": "control_folio"},{"data": "folio_doc"},{"data": "subject"},{"data": "nameSender"},{"data": "contactName"},{"data": "nameStatus"},{"data": "view"}],
        formObj    : "FormInbox",
        formButtons: "inbox"
    });
    var getCCAjax   = new GetCCAjax("pendingdoc/getCC", {method: "POST"});
    var modalNewDoc = new ModalForm("modal-win-info-add-document", "FormAddDoc", this.jQueryObj.find("[data-action='new-doc']"),
    function(_this){
        
        var initDocAjax = new InitialDocAjax("inmail/initDocumentArea", {method: "POST", async: false});
        var dataDoc     = initDocAjax.sendAjax();
        
        getCCAjax.scope.form   = _this.form;
        getCCAjax.scope.select = _this.form.select.cc;
        getCCAjax.setData({control_folio : dataDoc.docData.control_folio});
        getCCAjax.sendAjax();
        
        _this.form.dataMemory["control_folio"] = dataDoc.docData.control_folio;
        _this.form.jQueryObj.find("[data-action='generate-folio-out']").prop("disabled", dataDoc.docData.control_folio_out === undefined ? false : dataDoc.docData.control_folio_out !== "-/" ? true : false);
        _this.form.setValue(dataDoc.docData);
        
        ModalObj.prototype.showModal.apply(_this);
    });
    
    this.init = function(parentObj){
        this.setTable(tableObj, tableObj.querySelector);
        this.setModal(modalNewDoc, modalNewDoc.querySelector);
        pendingDoc.setTable(tableObj.querySelector, tableObj);
        
        PanelObj.prototype.init.apply(this, [parentObj]);
    };
};
PanelInbox.prototype = new PanelObj();

function PanelCheck(querySelector){
    PanelObj.apply(this, [querySelector]);
    
    var tableObj = new TableInbox("Tcheck", {
        ajax       : {url: "pendingdoc/getTableReview", method: "POST"},
        columns    : [{"data": "control_folio"},{"data": "folio_doc"},{"data": "subject"},{"data": "nameSender"},{"data": "contactName"},{"data": "nameStatus"},{"data": "view"}],
        formObj    : "FormCheck",
        formButtons: "check"
    });
    
    this.init = function(parentObj){
        this.setTable(tableObj, tableObj.querySelector);
        pendingDoc.setTable(tableObj.querySelector, tableObj);
        
        PanelObj.prototype.init.apply(this, [parentObj]);
    };
};
PanelCheck.prototype = new PanelObj();

function PanelHistory(querySelector){
    PanelObj.apply(this, [querySelector]);
    
    var tableObj = new TableInbox("Thistory", {
        ajax        : {url: "outmail/getTableHistory", method: "POST"},
        columns     : [{"data": "control_folio_out"},{"data": "control_folio"},{"data": "folio_doc"},{"data": "subject"},{"data": "nameSender"},{"data": "theme"},{"data": "nameAreas"},{"data": "employee"},{"data": "nameStatus"}],
        formObj     : "FormHistory",
        formButtons : "history",
        historyFolio: true
    });
    var modalHistory = new ModalForm("modal-win-info-add-history", "FormAddHistory", this.jQueryObj.find("[data-action='add-history']"), 
    function(_this){
        var initDocAjax = new InitialDocAjax("inmail/initDocumentArea", {method: "POST", async: false});
        initDocAjax.setData({status_id: 10});
        var dataDoc = initDocAjax.sendAjax();
        
        var areaDocAjax = new AreaDocAjax("systemctr/getCodeArea", {method: "POST", async: false});
        var areaDoc = areaDocAjax.sendAjax();
        
        for(var key in areaDoc){dataDoc.docData[key] = areaDoc[key];}
        
        _this.form.setValue(dataDoc.docData);
        ModalObj.prototype.showModal.apply(_this);
    });
    
    this.init = function(parentObj){
        this.setTable(tableObj, tableObj.querySelector);
        this.setModal(modalHistory, modalHistory.querySelector);
        
        pendingDoc.setTable(tableObj.querySelector, tableObj);
        
        PanelObj.prototype.init.apply(this, [parentObj]);
    };
};
PanelHistory.prototype = new PanelObj();

function PanelForm(querySelector, formNameObj, manualSubmit){
    PanelObj.apply(this, [querySelector]);
    
    var formNameObj  = formNameObj;
    var manualSubmit = manualSubmit;
    
    this.init = function(parentObj){
        
        var form = eval("new " + formNameObj + "(this.jQueryObj.find(\"form\"), " + manualSubmit + ")");
        this.setForm(form, this.querySelector);
        
        PanelObj.prototype.init.apply(this, [parentObj]);
    };
};
PanelForm.prototype = new PanelObj();