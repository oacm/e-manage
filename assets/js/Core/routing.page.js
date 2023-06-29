function ajaxJquery(url, formData, objectFunctions, method, typeResponse, async) {
    
    return {
        type       : method || "GET",
        url        : __urlRoot + url,
        async      : async === undefined ? true : async ? true : false,
        data       : formData,
        beforeSend : objectFunctions.beforeSend || null,
        success    : objectFunctions.success || null,
        error      : objectFunctions.error  || null,
        complete   : objectFunctions.complete || null,
        dataType   : typeResponse || "json",
        scope      : {}
    };
};

function ajaxJqueryFormObject(url, formData, objectFunctions, method, typeResponse, async){
    
    return {
        type       : method || "GET",
        url        : __urlRoot + url,
        async      : async === undefined ? true : async ? true : false,
        data       : formData,
        processData: false,
        contentType: false,
        beforeSend : objectFunctions.beforeSend || null,
        success    : objectFunctions.success,
        error      : objectFunctions.error,
        complete   : objectFunctions.complete || null,
        dataType   : typeResponse || "json",
        scope      : {}
    };
};

function getIconFile(ext){
        
    icon = "";

    switch(ext){
        case "xls": case "xlsx":
            icon = "fa fa-file-excel-o";
            break;
        case "doc": case "docx":
            icon = "fa fa-file-word-o";
            break;
        case "pdf":
            icon = "fa fa-file-pdf-o";
            break;
        default:
            icon = "fa fa-file-image-o";
    };

    return icon;

};

function sendMail(folio, url, config, formObj){
    
    var data       = folio;
    var dataConfig = config || {
        success    : function(data){
            if(data.status === "error"){
                $("#modal-win-alert .modal-header").addClass("modal-header-alert");
                $("#modal-win-alert .modal-header h2").html("Error");
                $("#modal-win-alert .close").html("<i class='fa fa-exclamation-circle'></i>");
                $("#modal-win-alert .modal-body").html("<p>¡Ocurrio un error, comunicate con el administrador!</p>");
                $("#modal-win-alert").css("display", "block");
                setTimeout(function(){
                    $("#modal-win-alert").css("display", "none");
                    $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                    $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
                }, 3000);
                return;
            }
        },
        error      : function(jqXHR, textStatus){
            console.log("error");
            console.log(jqXHR);
            console.log(textStatus);
        }
    };
    var configAjax = formObj === true ? 
    ajaxJqueryFormObject(url || "manage_email/inmail/sendMailToAgent", data, dataConfig, "POST") 
    : ajaxJquery(url || "manage_email/inmail/sendMailToAgent", data, dataConfig, "POST");
    
    $.ajax(configAjax);
};