function UpdatePass(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    this.beforeSend = function(){AjaxFn.prototype.beforeSend.apply(this,["Actualizando Contraseña"]);};
    this.success    = function(data){
        if(data.error){
            AjaxFn.prototype.success.apply(this, ["¡Ocurrio un error, comunicate con el administrador!", 3000]);
            this.scope.form.parentObj.jQueryObj.find(".close").click();
            return;
        }else{
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>Contraseña Cambiada</p>");
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
UpdatePass.prototype = new AjaxFn();