var checkMailPage = new DefaultFn();
var modalPreView  = new ModalObj("file-viewer");

var pAnswered = new PanelCheck("Panswered");

$(document).ready(function(){
    
    checkMailPage.setPanel(pAnswered, "Panswered");
    
    modalPreView.init(window);
    checkMailPage.init();
});