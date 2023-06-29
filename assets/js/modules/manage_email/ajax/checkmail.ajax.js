function ConfigResponseDocAjax(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    
    this.sendMailAjax = new SendMailAjax("systemctr/answerDocMail", {method: "POST"});
    
    this.beforeSend = function(){AjaxFn.prototype.beforeSend.apply(this,["Procesando petición"]);},
    this.success    = function(data){
        if(data.error){
            AjaxFn.prototype.success.apply(this, ["¡Ocurrio un error, comunicate con el administrador!", 3000]);
            return;
        }else{
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>El documento esta en espera de aprobación</p>");
            setTimeout((function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
                
                this.sendMailAjax.setData({
                    control_folio: this.scope.form.dataMemory.numDocument, 
                    comment      : this.scope.form.dataMemory.comments});
                
                this.sendMailAjax.sendAjax();
                
                this.scope.form.__reset();
                this.scope.modal.parentObj.resetPanel();
                this.scope.table.reloadTable();
                
            }).bind(this), 3000);
                        
        }
        
        this.scope.modal.jQueryObj.find(".close").click();
    };
};
ConfigResponseDocAjax.prototype = new AjaxFn();