function SendMailAjax(urlConfig, config){
    AjaxFn.apply(this,[urlConfig, config]);
    this.beforeSend = function(){AjaxFn.prototype.beforeSend.apply(this,["Enviando Mail"]);};
    this.success    = function(data){
        if(data.error){
            AjaxFn.prototype.success.apply(this, ["¡Ocurrio un error, comunicate con el administrador!", 3000]);
            return;
        }else{
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>El mail fue enviado exitosamente.</p>");
            setTimeout(function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");                
            }, 3000);
        }
    };
};
SendMailAjax.prototype = new AjaxFn();

function ViewerAjax(urlConfig, config) {
    AjaxFn.apply(this,[urlConfig, config]);
    this.beforeSend = function(){};
    this.success    = function(data){window.open( __urlRootImg + data.path + "/" + data.fileName + data.extension + "?timestamp=" + Math.floor((Math.random() * 100000) + 1));};
    this.error      = function(jqXHR, textStatus){console.log("error");console.log(jqXHR);console.log(textStatus);};
};
ViewerAjax.prototype = new AjaxFn();

function AddDocumentAjax(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    this.beforeSend = function(){AjaxFn.prototype.beforeSend.apply(this,["Creando Nuevo documento"]);};
    this.success    = function(data){
        if(data.error){
            AjaxFn.prototype.success.apply(this, ["¡Ocurrio un error, comunicate con el administrador!", 3000]);
            return;
        }else if(data.wait){
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>El documento fue creado exitosamente.</p>");
            setTimeout(function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");                
            }, 3000);
        }
        
        this.scope.form.__reset();
        this.scope.table.reloadTable();
    };
};
AddDocumentAjax.prototype = new AjaxFn();

function ReplaceDocumentAjax(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    this.beforeSend = function(){AjaxFn.prototype.beforeSend.apply(this,["Reemplazado Archivo"]);};
    this.success    = function(data){
        if(data.error){
            AjaxFn.prototype.success.apply(this, ["¡Ocurrio un error, comunicate con el administrador!", 3000]);
            return;
        }else{
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>El documento fue creado exitosamente.</p>");
            setTimeout(function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");                
            }, 3000);
        }
        
        this.scope.form.__reset();
        this.scope.modal.closeModal();
    };
};
ReplaceDocumentAjax.prototype = new AjaxFn();

function AssingDocumentAjax(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    
    this.sendMailAjax = new SendMailAjax("inmail/sendMailToAgent", {method: "POST"});
    
    this.beforeSend   = function(){AjaxFn.prototype.beforeSend.apply(this,["Asignando Documento"]);};
    this.success      = function(data){
        if(data.error){
            AjaxFn.prototype.success.apply(this, ["¡Ocurrio un error, comunicate con el administrador!", 3000]);
            return;
        }else{
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>El documento fue turnado exitosamente.</p>");
            setTimeout(function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");                
            }, 3000);
        }
        
        this.sendMailAjax.setData({control_folio: data.folioInDoc});
        this.sendMailAjax.sendAjax();
        
        this.scope.form.__reset(this.scope.form);
        this.scope.modal.closeModal(this.scope.modal);
        this.scope.table.reloadTable();
    };
}
AssingDocumentAjax.prototype = new AjaxFn();

function AcknowledgmentDocumentAjax(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    this.beforeSend = function(){AjaxFn.prototype.beforeSend.apply(this,["Asignando Acuse"]);};
    this.success    = function(data){
        if(data.error){
            AjaxFn.prototype.success.apply(this, ["¡Ocurrio un error, comunicate con el administrador!", 3000]);
            return;
        }else{
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>El acuse fue agregado exitosamente.</p>");
            setTimeout(function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");                
            }, 3000);
        }
        
        this.scope.form.__reset();
        this.scope.modal.closeModal();
        this.scope.table.reloadTable();
    };
};
AcknowledgmentDocumentAjax.prototype = new AjaxFn();

function InitialDocAjax(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    this.beforeSend = null;
    this.success    = null;
    this.error      = null;
};
InitialDocAjax.prototype = new AjaxFn();

function AddDocHistory(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    this.beforeSend = function(){AjaxFn.prototype.beforeSend.apply(this,["Registrando Documento"]);};
    this.success    = function(data){
        if(data.error){
            AjaxFn.prototype.success.apply(this, ["¡Ocurrio un error, comunicate con el administrador!", 3000]);
            this.scope.form.parentObj.jQueryObj.find(".close").click();
            return;
        }else{
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>Documento agregado al historial.</p>");
            setTimeout(function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
            }, 3000);
        }
        
        this.scope.form.__reset();
        this.scope.modal.closeModal();
        this.scope.table.reloadTable();
    };
};
AddDocHistory.prototype = new AjaxFn();