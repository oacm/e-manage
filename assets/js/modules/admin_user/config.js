function ConfigJS(){
    DefaultFn.call(this);
    this.init = function(){
        DefaultFn.prototype.init.call(this);        
    };
}

function FormConfig(DomObj){
    FormObj.call(this, DomObj);
    
    function SubmitForm(){
        AjaxFn.call(this);
        this.beforeSend = function(){
            AjaxFn.prototype.beforeSend.call(this, "Guardando Configuración");
        };
        this.success    = function(data){
            
            var timerSet = 3000;
            
            if(data.error){
                var msg = "Ocurrio un error comunicate con el Administrador";
                AjaxFn.prototype.success.call(this, msg, timerSet);
                return;
            }
            
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>La configuración fue guardada exitosamente.</p>");
            setTimeout(function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
                
                location.reload();
                
            }, timerSet);
            
        };
    };
    SubmitForm.prototype = new AjaxFn();
    this.submitForm      = new SubmitForm();
    
    this.enableSubmit    = function(){
        if(this.jQueryObj.find("button[type='submit']").prop("disabled")){
            console.log("EnableSubmit");
            this.jQueryObj.find("button[type='submit']").prop("disabled", false);
        }
    };
    this.__startDefaults = function(){
        this.jQueryObj.find("a[data-key='edit-name']").click((function(){
            this.jQueryObj.find("input[data-key='name']").prop("readonly", false);
        }).bind(this));
        this.jQueryObj.find("input[data-key='name']").change((function(){
            console.log("cambio en campo de nombre");
            this.enableSubmit();
        }).bind(this));
        this.jQueryObj.find("input[data-key='file']").change((function(){
            console.log("cambio en campo de archivo");
            this.enableSubmit();
        }).bind(this));
    };
    this.__reset = function(objForm){
        FormObj.prototype.__reset.call(objForm);
        
        var img = $("#profile-img-user"),
                defaultImg = img.data("default");
        
        objForm.form.find("input[data-key='name']").prop("readonly", true);
        objForm.form.find("button[type='submit']").prop("disabled", true);
        img.css("background-image", "url(" + defaultImg + ")");
        
    };
    this.__submit = function(objForm, ev){
        FormObj.prototype.__submit.apply(this, [objForm, ev]);
        
        var formData     = new FormData(this);
        
        for(var pair of formData.entries()) {
            
            if (pair[1] instanceof File){
                if(pair[1].size === 0){
                    formData.delete("file[]");
                }
            }
            
         }
        
        var configAjax   = ajaxJqueryFormObject("admin_user/config/saveConfig", formData, objForm.submitForm, "POST");
        
        configAjax.scope = objForm;

        $.ajax(configAjax);
        
    };
}

function AttachConfigImg(ObjConfig){
    AttachObj.call(this, ObjConfig);
    
    this.loadFiles = function(){
        
        var files      = this.files,
                reader = new FileReader();
        
        reader.onload  = function(){
            var dataURL = this.result;            
            var img     = $("#profile-img-user");
            
            img.css("background-image", "url(" + dataURL + ")");
        };
        reader.readAsDataURL(files[0]);        
    };
    this.init      = function(parentObj){
        AttachObj.prototype.init.apply(this, [parentObj]);
        this.jQueryObj.change($.proxy(this.loadFiles, null, this));
    };
}

ConfigJS.prototype        = new DefaultFn();
FormConfig.prototype      = new FormObj();
AttachConfigImg.prototype = new AttachObj();

var formConfig      = new FormConfig("user-data");
var attachConfigImg = new AttachConfigImg(formConfig.jQueryObj.find("input[type=file]"));

$(document).ready(function(){
    var configJS = new ConfigJS();
    
    configJS.setForm("formConfig", formConfig, null, attachConfigImg);
    
    configJS.init();
});