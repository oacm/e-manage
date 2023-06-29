function PendingDocPage(){
    DefaultFn.apply(this);
    
    this.startTables = function(){};
};
PendingDocPage.prototype = new DefaultFn();

var pendingDoc   = new PendingDocPage();
var modalPreView = new ModalObj("file-viewer");

var bIndex   = new ButtonObj("Binbox", true ,{panel: new PanelInbox("Pinbox")});
var bCheck   = new ButtonObj("Bcheck", {panel: new PanelCheck("Pcheck")});
var bHistory = new ButtonObj("Bhistory", {panel: new PanelHistory("Phistory")});

$(document).ready(function(){
    
    pendingDoc.setButton(bIndex, "Bindex");
    pendingDoc.setButton(bCheck, "Bcheck");
    pendingDoc.setButton(bHistory, "Bhistory");
    
    modalPreView.init(window);
    pendingDoc.init();
});