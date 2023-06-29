/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function ButtonObj(querySelector, active, extraConfig){
    
    if(active instanceof Object){
        extraConfig = active;
    }
    
    this.querySelector  = querySelector;
    this.jQueryObj      = $("#" + querySelector);
    this.icon           = extraConfig ? extraConfig.icon   || null : null;
    this.label          = extraConfig ? extraConfig.label  || null : null;
    this.panel          = extraConfig ? extraConfig.panel  || null : null;
    this.modal          = extraConfig ? extraConfig.modal  || null : null;
    this.ajaxFn         = extraConfig ? extraConfig.ajaxFn || null : null;
    this.parentObj      = null;
    this.active         = active instanceof Object ? active.active || false : active;
};
ButtonObj.prototype.setPanel  = function(panelObj){
    this.panel = panelObj;
};
ButtonObj.prototype.setModal  = function(modalObj){
    this.modal = modalObj;
};
ButtonObj.prototype.clickFn   = function(ev){
    ev.preventDefault();
    if(!$(this).hasClass("btn-active") && $(this).hasClass("btn-app")){$(this).addClass("btn-active");}    
};
ButtonObj.prototype.sendAjax  = function(_this){
    var alias = _this || this;
    $.ajax(alias.ajaxFn);
};
ButtonObj.prototype.transitionPanel = function(_this){
    var alias = _this || this;
};
ButtonObj.prototype.showModal = function(_this){
    var alias = _this || this;
    alias.modal.showModal();
};
ButtonObj.prototype.init      = function(parentObj){
    
    if(this.active){this.jQueryObj.addClass("btn-active");}    
    if(parentObj){this.parentObj = parentObj;}
    
    this.jQueryObj.click($.proxy(this.clickFn, null));
    if(this.panel){this.panel.init(this);this.jQueryObj.click($.proxy(this.transitionPanel, null, this));}
    if(this.modal){this.modal.init(this);this.jQueryObj.click($.proxy(this.showModal, null, this));}
    if(this.ajaxFn){this.jQueryObj.click($.proxy(this.clickFn, null, this));}
};