/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
function AjaxFn(urlConfig, config){
    if(!urlConfig){return;}
    
    this.url      = urlConfig instanceof Object ? urlConfig.url : urlConfig;
    this.type     = config ? config.method   || "GET"  : "GET";
    this.async    = config ? !(config.async === false) : true;
    this.dataType = config ? config.dataType || "json" : "json";
    this.data     = config ? config.data     || null   : null;
    this.scope    = {};
    
    if(this.data instanceof FormData){
        this.processData = false;
        this.contentType = false;
    }
    
};
AjaxFn.prototype.setUrl     = function(url){
    this.url = url;
};
AjaxFn.prototype.setData    = function(data){
    if(data instanceof FormData){
        this.processData = false;
        this.contentType = false;
    }
    this.data = data;
};
AjaxFn.prototype.sendAjax   = function(){
    if(!this.async){
        return JSON.parse($.ajax(this).responseText);
    }
    
    $.ajax(this);
};
AjaxFn.prototype.beforeSend = function(msg){
    
    var msgNew = msg ? "<p>" + msg + "</p>" : "";
    
    $("#modal-win-alert .modal-header h2").html("Procesando");
    $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
    $("#modal-win-alert .modal-body").html( msgNew + "<img src='" + __urlRootImg + "/assets/images/load.gif' />");

    $("#modal-win-alert").css({
        "display" : "block",
        "z-index" : 10001
    });
};
AjaxFn.prototype.success    = function(msgError, timeOut){
    $("#modal-win-alert").css({"display" : "block","z-index" : 10001});
    $("#modal-win-alert .modal-header").addClass("modal-header-alert");
    $("#modal-win-alert .modal-header h2").html("Error");
    $("#modal-win-alert .close").html("<i class='fa fa-exclamation-circle'></i>");
    $("#modal-win-alert .modal-body").html("<p>" + msgError + "</p>");
    setTimeout(function(){
        $("#modal-win-alert").css("display", "none");
        $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
        $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
    }, timeOut);
};
AjaxFn.prototype.error      = function(jqXHR, textStatus){
    $("#modal-win-alert .modal-header").addClass("modal-header-alert");
    $("#modal-win-alert .modal-header h2").html("Error");
    $("#modal-win-alert .close").html("<i class='fa fa-exclamation-circle'></i>");
    $("#modal-win-alert .modal-body").html("<p>¡Ocurrio un error comunicate con el administrador!</p>");
    setTimeout(function(){
        $("#modal-win-alert").css("display", "none");
        $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
        $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
    }, 1000);
    console.log("error");
    console.log(jqXHR);
    console.log(textStatus);
};