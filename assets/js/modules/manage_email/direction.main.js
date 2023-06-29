var configCommentDoc     = {
    url        : "manage_email/pendingdoc/setComment",
    beforeSend : function(){
        $("#modal-win-alert .modal-header h2").html("Procesando");
        $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
        $("#modal-win-alert .modal-body").html("<p>Procesando</p>\
                                                <img src='../../assets/images/load.gif' />");
        $("#modal-win-alert").css("display", "block");
    },
    success    : function(data){
        
        if(data.error){
            $("#modal-win-alert .modal-header").addClass("modal-header-alert");
            $("#modal-win-alert .modal-header h2").html("Error");
            $("#modal-win-alert .close").html("<i class='fa fa-exclamation-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>¡Ocurrio un error, comunicate con el administrador!</p>");
            setTimeout(function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
            }, 1000);
            
            this.scope.parentObj.modals.reject.modal.find(".close").click();
            return;
        }else{
            $("#modal-win-alert .modal-header h2").html("Aviso");
            $("#modal-win-alert .close").html("<i class='fa fa-info-circle'></i>");
            $("#modal-win-alert .modal-body").html("<p>Se ha guardado el Documento.</p>");
            setTimeout(function(){
                $("#modal-win-alert").css("display", "none");
                $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
                $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
            }, 1000);
            
            this.scope.parentObj.modals.comment.modal.find(".close").click();
        }
        console.log(this.scope);
        delete this.scope.dataToSend;
        delete this.scope.parentObj.forms.history.currentDoc;
        delete this.scope.parentObj.forms.history.valueData;
        
        this.scope.parentObj.disableTransition = false;
        this.scope.table.reloadTable();
        this.scope.__reset();
        this.scope.parentObj.forms.history.resetPanel();
    },
    error      : function(jqXHR, textStatus){
        $("#modal-win-alert .modal-header").addClass("modal-header-alert");
        $("#modal-win-alert .modal-header h2").html("Error");
        $("#modal-win-alert .close").html("<i class='fa fa-exclamation-circle'></i>");
        $("#modal-win-alert .modal-body").html("<p>¡Ocurrio un error, comunicate con el administrador!</p>");
        setTimeout(function(){
            $("#modal-win-alert").css("display", "none");
            $("#modal-win-alert .modal-header").removeClass("modal-header-alert");
            $("#modal-win-alert .modal-header").removeClass("modal-header-warning");
        }, 1000);
        console.log("error");
        console.log(jqXHR);
        console.log(textStatus);
    }
};
var getAntecedentsConfig = {
    url        : "manage_email/checkmail/getAntecedents",
    beforeSend : function(){        
        
        var $layer = $(".antecedent-panel").find(".layer-loading");
        
        $layer.find("p").css({
            "margin-top": "0.9%",
            "font-size" : "1.6em"
        });        
        $layer.find("img").css({
            width: "50px"
        });
        $layer.css("display", "block");
        
    },
    success    : function(data){
        
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

    },
    error      : function(jqXHR, textStatus){
        console.log("error");
        console.log(jqXHR);
        console.log(textStatus);
    }
};

var columnsHistory       = [
    {"data": "control_folio"},
    {"data": "folio_doc"},
    {"data": "subject"},
    {"data": "nameSender"},
    {"data": "theme"},
    {"data": "nameStatus"}
];

var defaultObj      = new DefaultFn();

var tableHistory    = new DataTableObj("history", true);

var formHistory     = new FormObj($("#view-doc").find("form"), true);

var modalComment    = new ModalObj("modal-win-info-comment");
var formComment     = new FormObj(modalComment.modal.find("form"));
modalComment.setForm(formComment);

// Funciones para setear comentarios
function showCommentModal(formObj, table){
    var formData = new FormData(formObj.form.get(0));
    formData.append("table", table);
    formData.append("numDocument", formObj.currentDoc);
    formData.delete("comments");
    
    formObj.parentObj.modals.comment.modal.find(".folio-doc").text(formObj.currentDoc);
    
    formObj.parentObj.forms.comment.dataToSend = formData;
    formObj.parentObj.modals.comment.showModal();
};
function setComment(formObj, ev){
    ev.preventDefault();
    var formData = new FormData(this);
    var table    = formObj.dataToSend.get("table");
    formObj.dataToSend.delete("table");
    
    for( var pair of formObj.dataToSend.entries()){
        if(pair[1].length === 0){continue;};
        formData.append(pair[0], pair[1]);
    }
    
    var configAjax         = ajaxJqueryFormObject(configCommentDoc.url, formData, configCommentDoc, "POST");
    configAjax.scope       = formObj;
    configAjax.scope.table = formObj.parentObj.tables[table];
        
    $.ajax(configAjax);
    sendMail(formData, "manage_email/systemctr/sendMailComment", undefined, true);
};
// Funciones para setear comentarios

/* Funcion para recoger todo los archivos de un documento */
function setFilesData(controlFolio){
    
    var config       = {
        url        : "manage_email/pendingdoc/getFilesData",
        success    : function(data){

            var iconFile = this.scope.getIconFile(data.extension);
            var fileDOM  = $("[data-key='fileType']");

            fileDOM.find("img").attr("src", iconFile);
            fileDOM.find("a").attr("href", __urlRootImg + data.path + "/" + data.fileName + data.extension);

        },
        error      : function(jqXHR, textStatus){
            console.log("error");
            console.log(jqXHR);
            console.log(textStatus);
        }
    };
    
    var configAjax   = ajaxJquery(config.url, {control_folio : controlFolio}, config, "POST");
    configAjax.scope = this;
    $.ajax(configAjax);

};
/* Funcion para recoger todo los archivos de un documento */

function resetComplete(formObj){
    
    var alias = formObj || this;
    
    $(".antecedent-panel").css("display", "none");
    
    delete alias.currentDoc;
    alias.parentObj.closePanel();
    alias.__reset();
};
function clearAntecedent(){
    var $antecedent = $(".antecedent-panel");
    $collapse       = $antecedent.find(".collapse-link i");
    $content        = $antecedent.find(".x_content");

    $antecedent.find(".wizard_steps").empty();
    $collapse.removeClass("fa-chevron-down").addClass("fa-chevron-up");
    $content.css("display", "none");
}
function loadAntecedents(objTables){
    
    var data = objTables.startPanelFn.apply(this, arguments);
    if(!data)return;
    
    $(".antecedent-panel").css("display", "inline-block");
    $(".antecedent-panel").find(".x_content").css("display", "block");
    
    var configAjax = ajaxJquery(getAntecedentsConfig.url, {documentId : data.control_folio_out || data.control_folio}, getAntecedentsConfig, "POST");
    $.ajax(configAjax);
};
function openViewer(obj){
    var data = obj.startPanelFn.apply(this, arguments);
    if(!data){ obj.responsiveView = true; return;}
    
    var formObj  = obj.extraPanel.forms[obj.parentPanel.attr("id")];
    
    obj.extraPanel.showPanel("panelViewer");
    obj.extraPanel.forms[obj.parentPanel.attr("id")].currentDoc = data.control_folio_out || data.control_folio;
    
    obj.extraPanel.setFilesData(data.control_folio_out || data.control_folio);
    
    formObj.form.find("[data-buttons]").css("display", "none");
    formObj.form.find("[data-buttons='" + obj.parentPanel.attr("id") + "']").css("display", "block");
    
    formObj.valueData = data;
    formObj.setValue(data);
};

function historyDefault(){
    
    var buttons           = this.form.find("[data-buttons='history']");
    this.resetPanel       = resetComplete;
    this.clearAntecedent  = clearAntecedent;
    this.showCommentModal = showCommentModal;
    
    this.select.theme_id    = {
        "jQueryObj" : this.form.find("select[data-key='theme-history']").select2({
            tags: true,
            ajax: {
                url: __urlRoot + "manage_email/pendingdoc/getTheme",
                dataType: 'json',
                delay: 250,
                data: function (params) {
                    return {
                        term: params.term,
                        page: params.page
                    };
                },
                processResults: function (data, params) {

                    params.page = params.page || 1;

                    return {
                        results: data,
                        pagination: {
                            more: (params.page * 30) < data.total_count
                        }
                    };
                },
                cache: true
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 0
        }),
        "ajaxUri"   : "manage_email/pendingdoc/getTheme"
    };
    this.select.priority_id = {
        "jQueryObj" : this.form.find("select[data-key='priority-history']").select2({
        ajax: {
            url: __urlRoot + "manage_email/pendingdoc/getPriority",
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    term: params.term,
                    page: params.page
                };
            },
            processResults: function (data, params) {

                params.page = params.page || 1;

                return {
                    results: data,
                    pagination: {
                        more: (params.page * 30) < data.total_count
                    }
                };
            },
            cache: true
        },
        escapeMarkup: function (markup) {
            return markup;
        },
        minimumInputLength: 0,
        minimumResultsForSearch: -1
    }),
        "ajaxUri"   : "manage_email/pendingdoc/getPriority"
    };
    
    buttons.find("[data-action='return']").click($.proxy(this.resetPanel, null, this));
    buttons.find("[data-action='return']").click($.proxy(this.clearAntecedent, null, this));
    buttons.find("[data-action='comment']").click($.proxy(this.showCommentModal, null, this, "tableHistory"));
};

function transitionPanel(obj){
            
    if($(this).hasClass("btn-active") || obj.disableTransition){
        return;
    }

    var panelToView  = $(this).data("panel");
    var panelToHide  = $(".btn-go-to.btn-active").data("panel");
    obj.currentPanel = $("#" + panelToView)

    $(".btn-go-to.btn-active").removeClass("btn-active");
    $(this).addClass("btn-active");
    $("#" + panelToHide).hide(500, function(){
        $("#" + panelToView).show(500);
    });
};
function viewDocumentHistory(obj){
    obj.objJquery.children("tbody").off("click", "td", $.proxy(openViewer));
    obj.objJquery.children("tbody").off("click", "td", $.proxy(loadAntecedents));
    obj.objJquery.children("tbody").on("click", "td", $.proxy(openViewer, null, obj));
    obj.objJquery.children("tbody").on("click", "td", $.proxy(loadAntecedents, null, obj));
};
function initPageWeb(){
    this.currentPanel = $("#history");
    
    this.setPanel($("#view-doc"), "panelViewer");
    
    this.tables.tableHistory.setColumns(columnsHistory);
    this.tables.tableHistory.setAjaxTable("manage_email/outmail/getTableHistory", "POST");
    this.tables.tableHistory.infoCallBack = viewDocumentHistory;
        
    this.startTables();
    this.startForms();
    this.startModal();
};

$(document).ready(function(){
    
    defaultObj.init             = initPageWeb;
    defaultObj.setFilesData     = setFilesData;
    
    formHistory.__startDefaults = historyDefault;    
    formComment.__submit        = setComment;
    
    tableHistory.setExtraPanel(defaultObj);
    
    defaultObj.setTable("tableHistory", tableHistory);    
    defaultObj.setForm("history", formHistory);
    
    defaultObj.setForm("comment", formComment);    
    defaultObj.setModal("comment", modalComment);
    
    defaultObj.init();
});