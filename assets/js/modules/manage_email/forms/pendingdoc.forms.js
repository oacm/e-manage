function Select2Ajax(url){
    return {
        url           : __urlRoot + url,
        dataType      : "json",
        delay         : 250,
        data          : function(params){return {term: params.term, page: params.page};},
        processResults: function(data, params){        
            params.page    = params.page || 1;
            return {results: data, pagination: {more: (params.page * 30) < data.total_count}};
        },
        cache         : true
    };
};

function FormActionInbox(querySelector, action, defaultStart, disableSubmit){
    FormObj.apply(this, [querySelector, disableSubmit]);
    
    this.configActionAjax = null;
        
    this.message  = null;
    this.typeForm = defaultStart;
    this.mailUri  = null;

    this.__startDefaults = function(){
        
        switch(this.typeForm){
            case "answered":            
                this.select.employees  = {
                    "jQueryObj" : $('#turned-employee').select2({
                        createTag: function (params) {return undefined;},
                        allowClear: true,
                        tags: true,
                        tokenSeparators: [';'],
                        ajax: new Select2Ajax("manage_email/pendingdoc/getEmployeeData"),
                        escapeMarkup: function (markup) {return markup;},
                        minimumInputLength: 0
                    })
                };
                this.select.cc         = {
                    "jQueryObj" : $('#cc-answered').select2({
                        createTag: function (params) {return undefined;},
                        tags: true,
                        tokenSeparators: [';'],
                        ajax: new Select2Ajax("manage_email/pendingdoc/getEmployeeData"),
                        escapeMarkup: function (markup) {return markup;},
                        minimumInputLength: 0
                    }),
                    "ajaxUri"   : "manage_email/pendingdoc/getEmployeeData"
                };
                this.mailUri           = "systemctr/askAnswerMail";
                this.configActionAjax  = new ConfigActionInboxAjax(action, {method: "POST"});
            break;
            case "returned":
                this.select.turnedOn   = {
                    "jQueryObj" : $('#turned-on').select2({
                        createTag: function (params) {return undefined;},
                        allowClear: true,
                        tags: true,
                        tokenSeparators: [';'],
                        ajax: new Select2Ajax("manage_email/pendingdoc/getEmailContact"),
                        escapeMarkup: function (markup) {
                            return markup;
                        },
                        minimumInputLength: 0
                    })
                };
                this.select.cc         = {
                    "jQueryObj" : $('#cc-returned').select2({
                        createTag: function (params) {return undefined;},
                        tags: true,
                        tokenSeparators: [';'],
                        ajax: new Select2Ajax("manage_email/pendingdoc/getEmployeeData"),
                        escapeMarkup: function (markup) {return markup;},
                        minimumInputLength: 0
                    }),
                    "ajaxUri"   : "manage_email/pendingdoc/getEmployeeData"
                };
                this.mailUri           = "inmail/sendMailToAgent";
                this.configActionAjax  = new ConfigActionInboxAjax(action, {method: "POST"});
            break;
            case "accept":
                this.mailUri = "systemctr/rejectAcceptMail";
                this.configActionAjax  = new ConfigActionCheckAjax(action, {method: "POST"});
            break;
            case "reject":
                this.mailUri = "systemctr/rejectAcceptMail";
                this.configActionAjax  = new ConfigActionInboxAjax(action, {method: "POST"});
            break;
            default:
                this.mailUri = "systemctr/sendMailComment";
                this.configActionAjax  = new ConfigActionInboxAjax(action, {method: "POST"});
        }
    };
    this.__submit        = function(_this, ev){
        FormObj.prototype.__submit.apply(this, [_this, ev]);
        
        var formData = new FormData(this);
        
        for( var pair of _this.dataMemory.entries()){formData.append(pair[0], pair[1]);}
        _this.dataMemory = {};
        
        for( var pair of formData.entries()){_this.dataMemory[pair[0]] = pair[1];}
        
        _this.configActionAjax.scope.message = _this.message;
        _this.configActionAjax.scope.form    = _this;
        _this.configActionAjax.scope.modal   = _this.parentObj;
        _this.configActionAjax.scope.mailUri = _this.mailUri;
        _this.configActionAjax.scope.table   = _this.parentObj.parentObj.parentObj.parentObj;
        
        _this.configActionAjax.setData(formData);
        _this.configActionAjax.sendAjax();
    };
};
FormActionInbox.prototype = new FormObj();

function FormInbox(querySelector, disableSubmit){
    FormObj.apply(this, [querySelector, disableSubmit]);
    
    var onlyKnownledgeAjax = new OnlyKnownledgeAjax("pendingdoc/setDocKnownledge", {method: "POST"});
    var getCCAjax          = new GetCCAjax("pendingdoc/getCC", {method: "POST"});
    
    this.modals = {
        "answeredModal": new ModalForm("modal-win-info-answered", {formObj :"FormActionInbox", action: "pendingdoc/answeredDoc", defaultStart: "answered"}),
        "returnedModal": new ModalForm("modal-win-info-returned", {formObj :"FormActionInbox", action: "pendingdoc/returnedDoc", defaultStart: "returned"}),
        "commentModal" : new ModalForm("modal-win-info-comment", {formObj :"FormActionInbox", action: "pendingdoc/setComment"})
    };
    
    this.saveKnowledge     = function(_this){
        
        var formData  = new FormData(_this.jQueryObj.get(0));
        var dataEmpty = [];

        formData.append("numDocument", _this.dataMemory.control_folio);

        for( var pair of formData.entries()){
            if(pair[1].length === 0){
                dataEmpty.push(pair[0]);
            };
        }

        for(var key in dataEmpty){formData.delete(dataEmpty[key]);}
        
        onlyKnownledgeAjax.scope.form      = _this;
        onlyKnownledgeAjax.scope.table     = _this.parentObj.parentObj;
        onlyKnownledgeAjax.scope.mainPanel = _this.parentObj.parentObj.parentObj.parentObj.parentObj;
        
        onlyKnownledgeAjax.setData(formData);
        onlyKnownledgeAjax.sendAjax();

    };
    
    this.showModal         = function(formData, modal, msg, selectDisabled){
        
        this.modals[modal].jQueryObj.find(".folio-doc").text(this.dataMemory.control_folio);
        
        if(!selectDisabled){
            getCCAjax.scope.form   = this.modals[modal].form;
            getCCAjax.scope.select = this.modals[modal].form.select.cc;
            getCCAjax.setData({control_folio : this.dataMemory.control_folio});
            getCCAjax.sendAjax();
        }
        
        this.modals[modal].form.dataMemory = formData;
        this.modals[modal].form.message    = msg;
        
        this.modals[modal].showModal();
    };
    
    this.showAnsweredModal = function (_this, modal){
        
        if(!_this.jQueryObj[0].checkValidity()){return;}
                
        var formData = new FormData(_this.jQueryObj.get(0));
        formData.append("numDocument", _this.dataMemory.control_folio);
        formData.delete("comments");
        
        _this.showModal(formData, modal, "Se envío el documento para respuesta.");
    };
    
    this.showReturnedModal = function (_this, modal){
        
        var formData = new FormData(_this.jQueryObj.get(0));
        formData.append("numDocument", _this.dataMemory.control_folio);
        formData.delete("comments");
        
        _this.showModal(formData, modal, "El documento fue turnado exitosamente.");
    };
    
    this.showCommentModal  = function (_this, modal){
        
        var formData = new FormData(_this.jQueryObj.get(0));
        formData.append("numDocument", _this.dataMemory.control_folio);
        formData.delete("comments");

        _this.showModal(formData, modal, "El comentario se guardo exitosamente.", true);
    };
    
    this.resetPanel        = function(_this){
        var alias = _this || this;
        $(".antecedent-panel").css("display", "none");
        alias.parentObj.parentObj.parentObj.parentObj.parentObj.closePanel();
        alias.parentObj.parentObj.clearAntecedent();
        alias.__reset();
    };
    
    this.__startDefaults   = function(){
        var buttons            = this.jQueryObj.find("[data-buttons='inbox']");

        this.select.theme_id    = {
            "jQueryObj" : this.jQueryObj.find("select[data-key='theme_id']").select2({
                tags: true,
                ajax: new Select2Ajax("manage_email/pendingdoc/getTheme"),
                escapeMarkup: function (markup) {return markup;},
                minimumInputLength: 0
            }),
            "ajaxUri"   : "manage_email/pendingdoc/getTheme"
        };
        this.select.priority_id = {
            "jQueryObj" : this.jQueryObj.find("select[data-key='priority_id']").select2({
            ajax: new Select2Ajax("manage_email/pendingdoc/getPriority"),
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 0,
            minimumResultsForSearch: -1
        }),
            "ajaxUri"   : "manage_email/pendingdoc/getPriority"
        };
        
        buttons.find("[data-action='knowledge']").click($.proxy(this.saveKnowledge, null, this));
        buttons.find("[data-action='answered']").click($.proxy(this.showAnsweredModal, null, this, "answeredModal"));
        buttons.find("[data-action='returned']").click($.proxy(this.showReturnedModal, null, this, "returnedModal"));
        buttons.find("[data-action='comment']").click($.proxy(this.showCommentModal, null, this, "commentModal"));
        buttons.find("[data-action='return']").click($.proxy(this.resetPanel, null, this));
        buttons.find("[data-action='return']").click($.proxy(this.parentObj.parentObj.clearAntecedent, null));

    };
    
    this.initModals        = function(){
        for(var key in this.modals){
            this.modals[key].init(this);
        }
    };
    
    this.init              = function(parentObj){
        this.initModals();
        FormObj.prototype.init.apply(this, [parentObj]);
    };
};
FormInbox.prototype = new FormObj();

function FormCheck(querySelector, disableSubmit){
    FormObj.apply(this, [querySelector, disableSubmit]);
    
    this.modals = {
        "modalAccept": new ModalForm("modal-win-info-accept", {formObj :"FormActionInbox", action: "pendingdoc/setAccepted", defaultStart: "accept"}),
        "modalReject": new ModalForm("modal-win-info-reject", {formObj :"FormActionInbox", action: "pendingdoc/setRejected", defaultStart: "reject"})
    };
    
    this.enableAccept    = function(_this){
        
        var buttons = _this.jQueryObj.find("[data-buttons='check']");

        if($(this).is(':checked')){
            buttons.find("[data-action='accept']").prop("disabled", false);
            return;
        }

        buttons.find("[data-action='accept']").prop("disabled", true);
    };
    
    this.showModal       = function(formData, modal, msg){
        
        this.modals[modal].jQueryObj.find(".folio-doc").text(this.dataMemory.control_folio);
        
        this.modals[modal].form.dataMemory = formData;
        this.modals[modal].form.message    = msg;
        
        this.modals[modal].showModal();
    };
    
    this.showAcceptModal = function(_this){
        var formData = new FormData(_this.jQueryObj.get(0));
        formData.append("numDocument", _this.dataMemory.control_folio);
        formData.delete("comments");

        _this.showModal(formData, "modalAccept");
    };
    
    this.showRejectModal = function(_this){
        var formData = new FormData(_this.jQueryObj.get(0));
        formData.append("numDocument", _this.dataMemory.control_folio);
        formData.delete("comments");

        _this.showModal(formData, "modalReject", "El documento se envío a corrección.");
    };
    
    this.resetPanel      = function(_this){
        var alias = _this || this;
        $(".antecedent-panel").css("display", "none");
        alias.parentObj.parentObj.parentObj.parentObj.parentObj.closePanel();
        alias.parentObj.parentObj.clearAntecedent();
        alias.__reset();
    };
    
    this.__startDefaults = function(){
        var buttons = this.jQueryObj.find("[data-buttons='check']");
        
        $('input').on('ifChecked', $.proxy(this.enableAccept, null, this));
        $('input').on('ifUnchecked', $.proxy(this.enableAccept, null, this));

        buttons.find("[data-action='accept']").click($.proxy(this.showAcceptModal, null, this));
        buttons.find("[data-action='reject']").click($.proxy(this.showRejectModal, null, this));
        buttons.find("[data-action='return']").click($.proxy(this.resetPanel, null, this));
        buttons.find("[data-action='return']").click($.proxy(this.parentObj.parentObj.clearAntecedent, null));

    };
    
    this.initModals      = function(){
        for(var key in this.modals){
            this.modals[key].init(this);
        }
    };
    
    this.init            = function(parentObj){
        this.initModals();
        FormObj.prototype.init.apply(this, [parentObj]);
    };
};
FormCheck.prototype = new FormObj();

function FormHistory(querySelector, disableSubmit){
    FormObj.apply(this, [querySelector, disableSubmit]);
    
    this.modals = {
        "commentModal" : new ModalForm("modal-win-info-comment-history", {formObj :"FormActionInbox", action: "pendingdoc/setComment"})
    };
    
    this.showModal         = function(formData, modal, msg){
        
        this.modals[modal].jQueryObj.find(".folio-doc").text(this.dataMemory.control_folio);
        
        this.modals[modal].form.dataMemory = formData;
        this.modals[modal].form.message    = msg;
        
        this.modals[modal].showModal();
    };
    
    this.showCommentModal  = function (_this, modal){
        
        var formData = new FormData(_this.jQueryObj.get(0));
        formData.append("numDocument", _this.dataMemory.control_folio_out);
        formData.delete("comments");

        _this.showModal(formData, modal, "El comentario se guardo exitosamente.", true);
    };
    
    this.resetPanel        = function(_this){
        var alias = _this || this;
        $(".antecedent-panel").css("display", "none");
        
        console.log(alias.parentObj.parentObj.parentObj.parentObj.parentObj);
        console.log(alias.parentObj.parentObj);
        
        alias.parentObj.parentObj.parentObj.parentObj.parentObj.closePanel();
        alias.parentObj.parentObj.clearAntecedent();
        alias.__reset();
    };
    
    this.__startDefaults   = function(){
        var buttons            = this.jQueryObj.find("[data-buttons='history']");

        this.select.theme_id    = {
            "jQueryObj" : this.jQueryObj.find("select[data-key='theme-history']").select2({
                tags: true,
                ajax: new Select2Ajax("manage_email/pendingdoc/getTheme"),
                escapeMarkup: function (markup) {return markup;},
                minimumInputLength: 0
            }),
            "ajaxUri"   : "manage_email/pendingdoc/getTheme"
        };
        this.select.priority_id = {
            "jQueryObj" : this.jQueryObj.find("select[data-key='priority-history']").select2({
            ajax: new Select2Ajax("manage_email/pendingdoc/getPriority"),
            escapeMarkup: function (markup) {
                return markup;
            },
            minimumInputLength: 0,
            minimumResultsForSearch: -1
        }),
            "ajaxUri"   : "manage_email/pendingdoc/getPriority"
        };
        
        buttons.find("[data-action='comment']").click($.proxy(this.showCommentModal, null, this, "commentModal"));
        buttons.find("[data-action='return']").click($.proxy(this.resetPanel, null, this));
        buttons.find("[data-action='return']").click($.proxy(this.parentObj.parentObj.clearAntecedent, null));

    };
    
    this.initModals        = function(){
        for(var key in this.modals){
            this.modals[key].init(this);
        }
    };
    
    this.init              = function(parentObj){
        this.initModals();
        FormObj.prototype.init.apply(this, [parentObj]);
    };
};
FormHistory.prototype = new FormObj();

function FormAddDoc(querySelector, disableSubmit){
    FormObj.apply(this, [querySelector, disableSubmit]);
    
    var getFolioOutAjax  = new GetFolioOutAjax("pendingdoc/getResponseFolio", {method: "POST"});
    var configNewDocArea = new ConfigNewDocArea("pendingdoc/setNewDocArea", {method: "POST"});
    
    this.attach = new AttachObj(this.jQueryObj.find("input[type='file']"), 
    {classContainer: this.jQueryObj.find(".attachment"), viewButton: true});
    
    this.generateFolioOut = function (_this){
        getFolioOutAjax.scope.form   = _this;
        getFolioOutAjax.scope.button = this;
        getFolioOutAjax.setData(_this.dataMemory);
        getFolioOutAjax.sendAjax();
    };
    this.__startDefaults  = function(){
        
        this.select.cc       = {
            "jQueryObj" : this.jQueryObj.find("select[data-key='cc']").select2({
                createTag: function (params) {return undefined;},
                tags: true,
                tokenSeparators: [';'],
                ajax: new Select2Ajax("manage_email/pendingdoc/getEmployeeData"),
                escapeMarkup: function (markup) {return markup;},
                minimumInputLength: 0
            }),
            "ajaxUri"   : "manage_email/pendingdoc/getEmployeeData"
        };
        this.select.theme_id = {
            "jQueryObj" : this.jQueryObj.find("select[data-key='theme_id']").select2({
                tags: true,
                ajax: new Select2Ajax("manage_email/pendingdoc/getTheme"),
                escapeMarkup: function (markup) {return markup;},
                minimumInputLength: 0
            }),
            "ajaxUri"   : "manage_email/pendingdoc/getTheme"
        };
        
        this.jQueryObj.find("[data-action='generate-folio-out']").click($.proxy(this.generateFolioOut, null, this));
    };
    this.__submit         = function (_this, ev){
        FormObj.prototype.__submit.apply(this, [_this, ev]);
        
        var formData = new FormData(this);
        formData.delete("file");

        for(var key in _this.attach.filesAttachment){
            formData.append("file[]", _this.attach.filesAttachment[key].fileData.file);
        };
        
        configNewDocArea.scope.form   = _this;
        configNewDocArea.scope.modal  = _this.parentObj;
        configNewDocArea.scope.tables = pendingDoc.tables;
        
        configNewDocArea.setData(formData);
        configNewDocArea.sendAjax();
    };
};
FormAddDoc.prototype = new FormObj();

function FormAddHistory(querySelector, disableSubmit){
    FormObj.apply(this, [querySelector, disableSubmit]);
    
    var addDocHistory = new AddDocHistory("systemctr/setDocHistoryConfig", {method: "POST"});
    
    this.attach = [new AttachObj("initial-doc-file", {attachContainer: "initial-doc-container", viewButton: true}), 
        new AttachObj("final-doc-file", {attachContainer: "final-doc-container", viewButton: true})];
    
    this.__startDefaults = function(){
        
        this.select.year_doc_out = {
            jQueryObj    : this.jQueryObj.find("select[data-key='year_doc_out']").yearselect({
                start: 2015,
                order: 'desc'
            }).select2({placeholder: ""}),
            reset        : true,
            hasSelection : false
        };
        this.select.num_doc_out  = {
            jQueryObj    : this.jQueryObj.find("select[data-key='num_doc_out']").select2({
                placeholder: "",
                tags       : true
            }).prop("disabled", true),
            ajaxUri      : "manage_email/systemctr/getNumAvailable"        
        };
        this.select.theme_id     = {
            jQueryObj    : this.jQueryObj.find("select[data-key='theme_id']").select2({
                tags       : true,
                placeholder: "Tema *",
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
        this.select.sender_id    = {
            "jQueryObj" : this.jQueryObj.find("select[data-key='sender_id']").select2({
                tags              : true,
                ajax              : {
                    url: __urlRoot + "manage_email/inmail/getSender",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term, // search term
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
                minimumInputLength: 0
            }),
            "ajaxUri"   : "manage_email/inmail/getSender"
        };
        this.select.contact_id   = {
            "jQueryObj" : this.jQueryObj.find("select[data-key='contact_id']").select2({
                tags: true,
                ajax: {
                    url: __urlRoot + "manage_email/inmail/getSignatoryContact",
                    dataType: 'json',
                    delay: 250,
                    data: function (params) {
                        return {
                            term: params.term, // search term
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
                minimumInputLength: 0
            }),
            "ajaxUri"   : "manage_email/inmail/getSignatoryContact"
        };

        this.datefield.date_document = this.jQueryObj.find("input[data-key='date_document']").daterangepicker({
            singleDatePicker: true,
            autoUpdateInput : false,
            locale          : {
                cancelLabel: 'Clear',
                daysOfWeek :["Do", "Lu", "Ma", "Mi", "Ju", "Vi", "Sa"],
                monthNames :["Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre"]
            }
        }).on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD'));
        }).on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
        });

        this.jQueryObj.find("input[data-check='input-activate']").on("change", (function(formObj){
            var checkBtn  = this.data("check");
            var container = formObj.jQueryObj.find("div[data-check='" + checkBtn + "-container']");

            if($(this).is(':checked')){
                container.css("display", "block");
                container.find("input, select").prop("disabled", false);
            }else{
                container.css("display", "none");
                container.find("input, select").prop("disabled", true);
            };
        }).bind(this.jQueryObj.find("input[data-check='input-activate']"), this));

        this.jQueryObj.find("select[data-key='corp']").on("select2:select", this.setValueSelect.bind(this, this.select.area, "corp_id"));
        
        this.select.year_doc_out.jQueryObj.on("select2:select", (function(){
            this.select.num_doc_out.jQueryObj.prop("disabled", false);
            this.setValueSelect(this.select.num_doc_out, ["code_out", "year_doc_out"], [this.jQueryObj.find("input[data-key='corp']").val() + "-" + this.jQueryObj.find("input[data-key='doc_code']").val(), this.select.year_doc_out.jQueryObj.val()]);
        }).bind(this));

        this.select.num_doc_out.jQueryObj.on("select2:select", (function(selectObj){

            var codeOut      = this.jQueryObj.find("input[data-key='corp']").val() + 
                "-" + this.jQueryObj.find("input[data-key='doc_code']").val();
            var yearDocOut   = this.select.year_doc_out.jQueryObj.val();
            var numDocOut    = selectObj.jQueryObj.val();

            function CheckNumDoc(urlConfig, config){
                AjaxFn.apply(this, [urlConfig, config]);
                this.beforeSend = function (){};
                this.success    = function(data){
                    if(data.error){
                        msg = "El número de documento que estas seleccionando ya esta ocupado busca en tu panel de historial";
                        AjaxFn.prototype.success.call(this, msg, 3000);
                        this.scope.jQueryObj.val(null).trigger('change');
                        return;
                    }
                };
            };
            CheckNumDoc.prototype = new AjaxFn();
            var checkNumDoc       = new CheckNumDoc(selectObj.ajaxUri.replace("manage_email/", ""), {method: "POST"});

            checkNumDoc.scope     = selectObj;
            checkNumDoc.setData({
                code_out    : codeOut,
                year_doc_out: yearDocOut,
                term        : numDocOut
            });
            checkNumDoc.sendAjax();

        }).bind(this, this.select.num_doc_out));
        
    };
    this.__submit        = function(_this, ev){
        var formData = new FormData(this);
        formData.append("folio_doc_out", _this.jQueryObj.find("input[data-key='corp']").val() + 
                "-" + _this.jQueryObj.find("input[data-key='doc_code']").val() + 
                "-" + _this.select.num_doc_out.jQueryObj.find(':selected').text() + 
                "/" + _this.select.year_doc_out.jQueryObj.find(':selected').text());
        formData.append("area_code", _this.jQueryObj.find("input[data-key='doc_code']").val());
        formData.delete("corp");
        formData.delete("doc_code");
        formData.delete("num_doc_out");
        formData.delete("year_doc_out");
        formData.append("code_out", _this.jQueryObj.find("input[data-key='corp']").val() + 
                "-" + _this.jQueryObj.find("input[data-key='doc_code']").val());
        formData.append("num_doc_out", _this.select.num_doc_out.jQueryObj.find(':selected').text());
        formData.append("year_doc_out", _this.select.year_doc_out.jQueryObj.find(':selected').text());
        
        addDocHistory.scope.form  = _this;
        addDocHistory.scope.modal = _this.parentObj;
        addDocHistory.scope.table = _this.parentObj.parentObj.tables.Thistory;
        
        addDocHistory.setData(formData);
        addDocHistory.sendAjax();
    };
    
};
FormAddHistory.prototype = new FormObj();