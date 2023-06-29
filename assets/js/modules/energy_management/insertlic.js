function InsertLicPage(){
    DefaultFn.apply(this);
};
InsertLicPage.prototype = new DefaultFn();

var insertLic   = new InsertLicPage();
var modalPreView = new ModalObj("file-viewer");

//var bIndex   = new ButtonObj("Binbox", true ,{panel: new PanelInbox("Pinbox")});
//var bCheck   = new ButtonObj("Bcheck", {panel: new PanelCheck("Pcheck")});
//var bHistory = new ButtonObj("Bhistory", {panel: new PanelHistory("Phistory")});

$(document).ready(function(){
    
    //insertLic.setButton(bIndex, "Bindex");
    //insertLic.setButton(bCheck, "Bcheck");
    //insertLic.setButton(bHistory, "Bhistory");
    
    modalPreView.init(window);
    insertLic.init();
});