function SendMailAjax(urlConfig, config){
    AjaxFn.apply(this,[urlConfig, config]);
    this.beforeSend = null;
    this.success    = function(data){
        if(data.error){
            AjaxFn.prototype.success.apply(this, ["¡Ocurrio un error, comunicate con el administrador!", 3000]);
            return;
        }
    };
};
SendMailAjax.prototype = new AjaxFn();

function GetCCAjax (urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    this.beforeSend = null;
    this.success    = function(data){
        var valuesData = [];

        if(data.length === 0){this.scope.select.jQueryObj.prop("disabled", false);return;}

        for(var key in data){valuesData.push(parseInt(data[key].employee_id));}

        this.scope.form.setValue("cc", valuesData);
        this.scope.select.jQueryObj.prop("disabled", false);
    };
    this.error      = function(jqXHR, textStatus){
        console.log("error");
        console.log(jqXHR);
        console.log(textStatus);
    };
};
GetCCAjax.prototype = new AjaxFn();

function GetFolioOutAjax(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    
    this.beforeSend = null;
    this.success    = function(data){
        
        if(!data.success){return;}
        
        this.scope.form.setValue("control_folio_out", data.control_folio_out);
        $(this.scope.button).prop("disabled", true);        
    };
};
GetFolioOutAjax.prototype = new AjaxFn();

function AntecedentsAjax (urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    this.beforeSend = function(){
        var $layer = $(".antecedent-panel").find(".layer-loading");
        $layer.find("p").css({"margin-top": "0.9%", "font-size" : "1.6em"});
        $layer.find("img").css({width: "50px"});
        $layer.css("display", "block");
    };
    this.success    = function(data){
        var $antecedent = $(".antecedent-panel"),
                $layer  = $antecedent.find(".layer-loading");
        
        setTimeout(function(){
            
            if(data.length === 0){
                $layer.css("display", "none");
                setTimeout(function(){
                    $collapse = $antecedent.find(".collapse-link i");
                    $content  = $antecedent.find(".x_content");

                    $collapse.removeClass("fa-chevron-down").addClass("fa-chevron-up");
                    $content.css("display", "none");
                }, 500);
            }else{
                for(var i = 0 ; i < data.length ; i++){
                    $antecedent.find(".wizard_steps").append(data[i]);
                }
                setTimeout(function(){
                    
                    $collapse = $antecedent.find(".collapse-link i");
                    $content  = $antecedent.find(".x_content");
                    
                    $layer.css("display", "none");
                    
                    $collapse.removeClass("fa-chevron-up").addClass("fa-chevron-down");
                    $content.css("display", "block");
                }, 500);
            }
            
        }, 1500);
    };
};
AntecedentsAjax.prototype = new AjaxFn();

function GetFilesDataAjax(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    this.beforeSend = null;
    this.success    = function(data){
        
        var iconFile = this.scope.getIconFile(data.extension);
        var fileDOM  = $("[data-key='fileType']");

        fileDOM.find("img").attr("src", iconFile);
        fileDOM.find("a").attr("href", __urlRootImg + data.path + "/" + data.fileName + data.extension + "?timestamp=" + Math.floor((Math.random() * 100000) + 1));
    };
};
GetFilesDataAjax.prototype = new AjaxFn();

function SetViewDocAjax(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    
    this.beforeSend = null;
    this.success    = function(data){
        if(data.error){
            AjaxFn.prototype.success.apply(this, ["¡Ocurrio un error, comunicate con el administrador!", 3000]);
            return;
        }
        this.scope.reloadTable();
    };
};
SetViewDocAjax.prototype = new AjaxFn();

function InitialDocAjax(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    this.beforeSend = null;
    this.success    = null;
    this.error      = null;
};
InitialDocAjax.prototype = new AjaxFn();

function AreaDocAjax(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    this.beforeSend = null;
    this.success    = null;
    this.error      = null;
};
AreaDocAjax.prototype = new AjaxFn();

function OnlyKnownledgeAjax(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    this.beforeSend = function(){AjaxFn.prototype.beforeSend.apply(this,["Procesando petición"]);},
    this.success    = function(data){
        if(data.error){
            AjaxFn.prototype.success.apply(this, ["¡Ocurrio un error, comunicate con el administrador!", 3000]);
            return;
        }else{
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>Documento contestado <br> folio de contestación:<br>" + data.folioResponse + "</p>");
            setTimeout((function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
                
                this.scope.table.reloadTable();
                this.scope.form.resetPanel();
                
            }).bind(this), 3000);
        }
    };
};
OnlyKnownledgeAjax.prototype = new AjaxFn();

function ConfigNewDocArea(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    
    this.beforeSend = function(){AjaxFn.prototype.beforeSend.apply(this,["Registrando Documento"]);},
    this.success    = function(data){
        
        if(data.error){
            AjaxFn.prototype.success.apply(this, ["¡Ocurrio un error, comunicate con el administrador!", 3000]);
            return;
        }else{
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>Documento nuevo creado.</p>");
            setTimeout((function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
                
                this.scope.tables.Thistory.parentObj.parentObj.jQueryObj.click();
            }).bind(this), 3000);
            
        }
        
        this.scope.modal.jQueryObj.find(".close").click();
        
        for(var key in this.scope.tables){
            if(typeof(this.scope.tables[key]) == "object"){this.scope.tables[key].reloadTable();}
        };
        this.scope.form.__reset();
        
    };
};
ConfigNewDocArea.prototype = new AjaxFn();

function ConfigActionInboxAjax(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    
    this.sendMailAjax = new SendMailAjax("systemctr/askAnswerMail", {method: "POST"});
    
    this.beforeSend = function(){AjaxFn.prototype.beforeSend.apply(this,["Procesando petición"]);},
    this.success    = function(data){
        if(data.error){
            AjaxFn.prototype.success.apply(this, ["¡Ocurrio un error, comunicate con el administrador!", 3000]);
            return;
        }else{
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>" + this.scope.message + "</p>");
            setTimeout((function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
                
                this.sendMailAjax.setUrl(this.scope.mailUri);
                this.sendMailAjax.setData({
                    control_folio: this.scope.form.dataMemory.numDocument, 
                    comment: this.scope.form.dataMemory.comments});
                
                this.sendMailAjax.sendAjax();
                
                this.scope.form.__reset();
                this.scope.modal.parentObj.resetPanel();
                this.scope.table.reloadTable();
                
                this.scope.message = null;
                
            }).bind(this), 3000);
                        
        }
        
        this.scope.modal.jQueryObj.find(".close").click();
    };
};
ConfigActionInboxAjax.prototype = new AjaxFn();

function ConfigActionCheckAjax(urlConfig, config){
    AjaxFn.apply(this, [urlConfig, config]);
    
    this.sendMailAjax = new SendMailAjax("systemctr/askAnswerMail", {method: "POST"});
    
    this.beforeSend = function(){AjaxFn.prototype.beforeSend.apply(this,["Procesando petición"]);},
    this.success    = function(data){
        if(data.error){
            AjaxFn.prototype.success.apply(this, ["¡Ocurrio un error, comunicate con el administrador!", 3000]);
            return;
        }else{
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>El documento fue aprovado correctamente.<br>Folio generado<br><b>" + data.folioResponse + "</b></p>");
            setTimeout((function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
                
                this.sendMailAjax.setUrl(this.scope.mailUri);
                this.sendMailAjax.setData({control_folio: this.scope.form.dataMemory.numDocument});
                
                this.sendMailAjax.sendAjax();
                
                this.scope.form.__reset();
                this.scope.modal.parentObj.resetPanel();
                this.scope.table.reloadTable();
                
                this.scope.message = null;
                
            }).bind(this), 3000);
                        
        }
        
        this.scope.modal.jQueryObj.find(".close").click();
    };
};
ConfigActionCheckAjax.prototype = new AjaxFn();

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