/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function PanelObj(querySelector, extraConfig){
    this.querySelector = querySelector;
    this.jQueryObj     = $("#" + querySelector);
    this.title         = extraConfig ? extraConfig.title || null : null;
    this.forms         = {length: 0};
    this.tables        = {length: 0};
    this.buttons       = {length: 0};
    this.modal         = {length: 0};
    this.parentObj     = null;
};
PanelObj.prototype.setForm        = function(formObj, alias){
    this.forms[alias] = formObj;
    this.forms.length++;
};
PanelObj.prototype.setTable       = function(tableObj, alias){
    this.tables[alias] = tableObj;
    this.tables.length++;
};
PanelObj.prototype.setButton      = function(buttonObj, alias){
    this.buttons[alias] = buttonObj;
    this.buttons.length++;
};
PanelObj.prototype.setModal       = function (modalObj, alias){
    this.modal[alias] = modalObj;
    this.modal.length++;
};
PanelObj.prototype.__initExtraObj = function(){
    for( var key in this.forms){
        if(key == "length"){continue;}
        this.forms[key].init(this);        
    }
    for( var key in this.tables){if(key == "length"){continue;}this.tables[key].init(this);}
    for( var key in this.buttons){if(key == "length"){continue;}this.buttons[key].init(this);}
    for( var key in this.modal){if(key == "length"){continue;}this.modal[key].init(this);}
};
PanelObj.prototype.init           = function(parentObj){
    if(this.active){this.jQueryObj.addClass("");}
    if(parentObj){this.parentObj = parentObj;}
    
    this.__initExtraObj();
};