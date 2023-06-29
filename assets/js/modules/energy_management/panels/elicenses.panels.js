function PanelInbox(querySelector){
    PanelObj.apply(this, [querySelector]);
    
var modalNewDoc = new ModalForm("modal-win-info-add-licenses", "FormAddDoc", this.jQueryObj.find("[data-action='new-doc']"),
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
        this.setModal(modalNewDoc, modalNewDoc.querySelector);
        
        PanelObj.prototype.init.apply(this, [parentObj]);
    };
};
PanelInbox.prototype = new PanelObj();

