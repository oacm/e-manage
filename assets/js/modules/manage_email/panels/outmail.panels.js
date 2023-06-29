function PanelOut(querySelector){
    PanelObj.apply(this, [querySelector]);
    
    var tableObj = new TableDocOut("Toutdoc", {
        ajax   : {url: "outmail/getTableWaiting", method: "POST"},
        columns: [{"data": "docOut", "width": "30%"}, {"data": "theme", "width": "30%"}, {"data": "subject", "width": "30%"}, {"data": "download", "className": "center-data-cell cursor-pointer-none", "searchable": false, "orderable": false}]
    });
    
    this.active = true;
    
    this.init = function(parentObj){
        this.setTable(tableObj, tableObj.querySelector);
        
        PanelObj.prototype.init.apply(this, [parentObj]);
    };
};
PanelOut.prototype = new PanelObj();