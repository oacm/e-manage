function IndexPage(){
    DefaultFn.apply(this);
    
    this.init = function(){
        DefaultFn.prototype.init.apply(this);
    };
};
IndexPage.prototype = new DefaultFn();

var indexPage    = new IndexPage();
var modalPreView = new ModalObj("file-viewer");

var modalFirstLogging = new ModalForm("modal-win-info-first-loggin", "FormChangePass");

$(document).ready(function(){
    
    modalPreView.init(window);
    
    indexPage.setModal("modalFirstLogging", modalFirstLogging);
    indexPage.init();
});