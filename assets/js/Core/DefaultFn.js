function DefaultFn (){
    this.tables            = {length: 0};
    this.modals            = {length: 0};
    this.forms             = {length: 0};
    this.panels            = {length: 0};
    this.buttons           = {length: 0};
    this.disableTransition = false;
    this.currentPanel      = null;
    this.panelBack         = null;
};

DefaultFn.prototype.setTable    = function(name, tableObj){
    this.tables[name] = tableObj;
    this.tables.length++;
};
DefaultFn.prototype.startTables = function(){
    
    for( var key in this.tables){
        if(key == "length"){continue;}
        this.tables[key].init();
    }
    
//    $(".panel-go-to").removeAttr("style").css("display", "none");
};
DefaultFn.prototype.setModal    = function(name, modalObj){
    this.modals[name] = modalObj;
    this.modals.length++;
};
DefaultFn.prototype.startModal  = function(){
    
    for( var key in this.modals){
        if(key == "length"){continue;}
        this.modals[key].init();
    }
};
DefaultFn.prototype.setForm     = function(name, form, submit, attachObj){
    if(attachObj){
        form.setAttach(attachObj);
    }
    
    form.__submit    = submit || form.__submit;
    this.forms[name] = form;
    this.forms.length++;
};
DefaultFn.prototype.startForms  = function(){
    for( var key in this.forms ){
        if(key == "length"){continue;}
        this.forms[key].init(this);
    }
};
DefaultFn.prototype.setPanel    = function(panelObj, alias){
    this.panels[alias] = panelObj;
    this.panels.length++;
};
DefaultFn.prototype.startPanel  = function(){
    for( var key in this.panels ){
        if(key == "length"){continue;}
        if(this.panels[key].active){this.currentPanel = this.panels[key].jQueryObj;}
        this.panels[key].init(this);
    }
};
DefaultFn.prototype.setButton   = function(buttonObj, alias){
    this.buttons[alias] = buttonObj;
    this.buttons.length++;
};
DefaultFn.prototype.startButton = function(){
    for( var key in this.buttons ){
        if(key == "length"){continue;}
        if(this.buttons[key].panel !== null){
            if(this.buttons[key].active){this.currentPanel = this.buttons[key].panel.jQueryObj;}
            this.buttons[key].init(this);
            this.buttons[key].jQueryObj.off("click", this.buttons[key].clickFn);
            this.buttons[key].jQueryObj.click($.proxy(this.transitionPanel, null, this));
        }else{
            this.buttons[key].init(this);
        }
    }
};

DefaultFn.prototype.getIconFile = function(extension){
    
    var ext = extension.substr(1),
            icon = "";
    
    switch(ext.toLowerCase()){
        case "xls":
        case "xlsx":
            icon = "assets/images/excel_icon_128.png";
            break;
        case "doc":
        case "docx":
            icon = "assets/images/word_icon_128.png";
            break;
        case "ppt":
        case "pptx":
            icon = "assets/images/powerpoint_icon_128.png";
            break;
        case "zip":
        case "rar":
            icon = "assets/images/zip_icon_128.png";
            break;
        default :
            icon = "assets/images/pdf_icon_128.png";
    }
    
    return __urlRootImg + icon;
    
};

DefaultFn.prototype.transitionPanel = function(_this){
    if($(this).hasClass("btn-active") || _this.disableTransition){
        return;
    }

    var panelToView    = $(this).data("panel");
    var panelToHide    = $(".btn-go-to.btn-active").data("panel");
    _this.currentPanel = $("#" + panelToView);

    $(".btn-go-to.btn-active").removeClass("btn-active");
    $(this).addClass("btn-active");
    $("#" + panelToHide).hide(500, function(){
        $("#" + panelToView).show(500);
    });
};

DefaultFn.prototype.showPanel   = function(panelJquery){
//    console.log(this);
//    return;
    var panelBack = this.currentPanel;
    var panelShow = panelJquery;
    
    this.disableTransition = true;
    
    this.currentPanel.fadeOut("fast", (function(panelShow, panelBack){
        panelShow.fadeIn("fast");
        this.panelBack    = panelBack;
        this.currentPanel = panelShow;
    }).bind(this, panelShow, panelBack));
};

DefaultFn.prototype.closePanel  = function(){
    this.disableTransition = false;
    this.currentPanel.fadeOut("fast", (function(){
        this.panelBack.fadeIn("fast");
        this.currentPanel = this.panelBack;
        delete this.panelBack;
    }).bind(this));
};

DefaultFn.prototype.checkTransition = function(){
//    if(this.tables.length > 0){
//        return;
//    }
    
//    $(".panel-go-to").css("display", "none").removeClass("panel-go-to");
};

DefaultFn.prototype.init        = function(){
    this.startButton();
    this.startTables();
    this.startForms();
    this.startModal();
    this.startPanel();
};