function PanelCheck(querySelector){
    PanelObj.apply(this, [querySelector]);
    
    var tableObj = new TableCheck("Tanswered", {
        ajax   : {url: "checkmail/getTableAnswered", method: "POST"},
        columns: [{"data": "control_folio"}, {"data": "folio_doc"}, {"data": "subject"}, {"data": "theme"}, {"data": "nameSender"}, {"data": "priority"}, {"data": "expiration"}]
    });
    
    this.active = true;
    
    this.init = function(parentObj){
        this.setTable(tableObj, tableObj.querySelector);
        
        PanelObj.prototype.init.apply(this, [parentObj]);
    };
};
PanelCheck.prototype = new PanelObj();

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