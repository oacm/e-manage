var outMailPage  = new DefaultFn();
var modalPreView = new ModalObj("file-viewer");
var pAnswered    = new PanelOut("Poutdoc");

$(document).ready(function(){
    
    outMailPage.setPanel(pAnswered, "Panswered");
    
    modalPreView.init(window);
    outMailPage.init();
});
