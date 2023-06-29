var defaultObj           = new DefaultFn();

function transitionPanel(obj){
            
    if($(this).hasClass("btn-active") || obj.disableTransition){
        return;
    }

    var panelToView  = $(this).data("panel");
    var panelToHide  = $(".btn-go-to.btn-active").data("panel");
    obj.currentPanel = $("#" + panelToView);

    $(".btn-go-to.btn-active").removeClass("btn-active");
    $(this).addClass("btn-active");
    $("#" + panelToHide).hide(500, function(){
        $("#" + panelToView).show(500);        
    });
};
function initPageWeb(){
    this.currentPanel = $("#" + $(".btn-go-to.btn-active").data("panel"));
    this.checkTransition();
    
    $(".btn-go-to").click($.proxy(this.transitionPanel, null, this));
};

$(document).ready(function(){
    
    defaultObj.init            = initPageWeb;
    defaultObj.transitionPanel = transitionPanel;
        
    defaultObj.init();
});