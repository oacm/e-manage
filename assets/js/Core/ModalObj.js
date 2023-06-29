function ModalObj(querySelector, triggerJqueryDOM){
    this.querySelector = querySelector;
    this.jQueryObj     = $("#" + querySelector);
    this.button        = triggerJqueryDOM || null;
    this.parentObj     = null;
};
ModalObj.prototype.showModal  = function(_this){
    var alias = _this || this;
    alias.jQueryObj.css("display", "block");
};
ModalObj.prototype.closeModal = function(_this){
    var alias = _this || this;
    alias.jQueryObj.css("display", "none");
};
ModalObj.prototype.setTitle   = function(title){
    this.jQueryObj.find(".modal-header>h2").text(title);
};
ModalObj.prototype.setForm    = function(form){
    this.jQueryObj.find(".close").click($.proxy(form.__reset, null, form));
};
ModalObj.prototype.init       = function(parentObj){
    
    if(parentObj){this.parentObj = parentObj;}
    if(this.button){this.button.click($.proxy(this.showModal, null, this));}
    
    this.jQueryObj.find(".close").click($.proxy(this.closeModal, null, this));
    this.jQueryObj.find("button[type='reset']").click($.proxy(this.closeModal, null, this));
};
