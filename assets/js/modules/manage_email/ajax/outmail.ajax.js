var SetOutMailAjax = function(urlConfig, config) {
    AjaxFn.apply(this, [urlConfig, config]);
    
    this.beforeSend = function(){AjaxFn.prototype.beforeSend.apply(this,["Registrando Documento"]);};
    this.success    = function(data){
        if(data.error){
            AjaxFn.prototype.success.apply(this, ["¡Ocurrio un error, comunicate con el administrador!", 3000]);
            return;
        }else{
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>El documento fue contestado.</p>");
            setTimeout(function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
            }, 3000);
            
            this.scope.form.__reset();
            this.scope.modal.jQueryObj.find(".close").click();
            this.scope.table.reloadTable();
        }
    };
};
SetOutMailAjax.prototype = new AjaxFn();