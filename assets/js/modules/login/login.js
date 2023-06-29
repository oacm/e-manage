function LoginDefault(){
    DefaultFn.call(this);
    
    this.init = function(){
        this.startForms();
        this.startModal();
    };
};
LoginDefault.prototype = new DefaultFn();

function FormLogin(querySelectorDom, disableSubmit){
    FormObj.call(this, querySelectorDom, disableSubmit);

    function AjaxLogin(){
        AjaxFn.call(this);
        this.url = "session/loginctr/login";
        
        this.beforeSend = function(){AjaxFn.prototype.beforeSend.call(this, "Accesando");};
        this.success    = function(data){

            if(data.success){
                setTimeout(function(){location.reload();}, 3000);
                return;
            }else{
                $("#modal-win-alert .modal-header h2").html("Aviso");
                $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
                $("#modal-win-alert .modal-body").html("<p>El login o el password son incorrectos.</p><p>Intentalo de nuevo.</p>");
                setTimeout(function(){
                    $("#modal-win-alert").css("display", "none");
                    $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                    $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
                }, 3000);
            }

            this.scope.formObj.__reset();
        };
    };
    AjaxLogin.prototype = new AjaxFn();

    this.ajaxSubmit = new AjaxLogin();

    this.__submit = function(_this, ev){
        FormObj.prototype.__submit(_this, ev);

        var formData = new FormData(this);

        var configAjax           = ajaxJqueryFormObject(_this.ajaxSubmit.url, formData, _this.ajaxSubmit, "POST");
        configAjax.scope.formObj = _this;

        $.ajax(configAjax);
    };
};
FormLogin.prototype = new FormObj();

var loginDefault = new LoginDefault();

loginDefault.setForm("login", new FormLogin("login-form", true));

$(document).ready(function(){
    loginDefault.init();
});