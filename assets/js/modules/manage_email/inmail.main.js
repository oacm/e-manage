function InMailPage(){
    DefaultFn.apply(this);
};
InMailPage.prototype = new DefaultFn();

var inMail       = new InMailPage();
var modalPreView = new ModalObj("file-viewer");

var pDocStart = new PanelDocStart("PdocStart", new TableDocStart("TdocStart", {ajax: {url: "inmail/getTable", method: "POST"}, 
    columns: [{"data": "control_folio"},{"data": "nameStatus"},{"data": "viewDocs","orderable": false, "searchable": false}]}));
var bDocStart = new ButtonObj("BdocStart", true ,{panel: pDocStart});

var pHistory  = new PanelHistory("Phistory", new TableHistory("Thistory", {ajax: {url: "outmail/getTableHistoryTurned", method: "POST"}, 
    columns: [{"data": "control_folio_out", "responsivePriority": 1},{"data": "control_folio","responsivePriority": 10},{"data": "folio_doc","responsivePriority": 9},{"data": "subject","responsivePriority": 5},{"data": "nameSender","responsivePriority": 8},{"data": "nameAreas","responsivePriority": 6},{"data": "employee","responsivePriority": 7},{"data": "dateReception","responsivePriority": 3},{"data": "nameStatus","responsivePriority": 4},{"data": "alert_doc","orderable": false,"searchable": false,"responsivePriority": 2}]}));
var bHistory  = new ButtonObj("Bhistory", {panel: pHistory});

$(document).ready(function(){
    
    inMail.setButton(bDocStart, "BdocStart");
    inMail.setButton(bHistory, "Bhistory");
    
    modalPreView.init(window);
    inMail.init();
});