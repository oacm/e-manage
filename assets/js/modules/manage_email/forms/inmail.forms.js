function FormAssing(querySelector, disableSubmit){
    FormObj.apply(this, [querySelector, disableSubmit]);
    
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
    
    var assingDocumentAjax = new AssingDocumentAjax("inmail/saveNewDoc", {method: "POST"});
    
    this.__startDefaults   = function(){
        $.fn.select2.defaults.set('language', 'es');

        this.select.turnedOn         = {
            "jQueryObj" : $('#turned-on').select2({
                createTag: function (params) {
                    return undefined;
                },
                allowClear: true,
                tags: true,
                tokenSeparators: [';'],
                ajax: Select2Ajax("manage_email/inmail/getEmailContact"),
                escapeMarkup: function (markup) {
                    return markup;
                },
                minimumInputLength: 0
            }),
            "ajaxUri"   : "manage_email/inmail/getEmailContact"
        };

        this.select.ccAnswered       = {
            "jQueryObj" : $('#cc-answered').select2({
                createTag: function (params) {
                    return undefined;
                },
                tags: true,
                tokenSeparators: [';'],
                ajax: Select2Ajax("manage_email/pendingdoc/getEmployeeData"),
                escapeMarkup: function (markup) {
                    return markup;
                },
                minimumInputLength: 0
            }),
            "ajaxUri"   : "manage_email/pendingdoc/getEmployeeData"
        };

        this.select.sender           = {
            "jQueryObj" : $('#sender').select2({
                tags              : true,
                ajax              : Select2Ajax("manage_email/inmail/getSender"),
                minimumInputLength: 0
            }),
            "ajaxUri"   : "manage_email/inmail/getSender"
        };

        this.select.signatory        = {
            "jQueryObj" : $('#signatory').select2({
                tags: true,
                ajax: Select2Ajax("manage_email/inmail/getSignatoryContact"),
                minimumInputLength: 0
            }),
            "ajaxUri"   : "manage_email/inmail/getSignatoryContact"
        };

        this.datefield.date_document = $("#date_document").daterangepicker({
            singleDatePicker: true,
            locale: {
                format: 'YYYY-MM-DD'
            }
        });
    };    
    this.__submit          = function(_this, ev){
        FormObj.prototype.__submit.apply(this, [_this, ev]);
        
        var formData       = new FormData(this);
        
        assingDocumentAjax.scope.form  = _this;
        assingDocumentAjax.scope.modal = _this.parentObj;
        assingDocumentAjax.scope.table = _this.parentObj.parentObj;
        
        assingDocumentAjax.setData(formData);
        assingDocumentAjax.sendAjax();
    };
};
FormAssing.prototype = new FormObj();

function FormReplace(querySelector, disableSubmit){
    FormObj.apply(this, [querySelector, disableSubmit]);
    
    var replaceDocumentAjax = new ReplaceDocumentAjax("inmail/replaceDocument", {method: "POST"});
    
    this.attach = new AttachObj(this.jQueryObj.find("input[type='file']"), 
    {attachContainer: "replaceContainerAttach", viewButton: true});
    this.__submit = function(_this, ev){
        FormObj.prototype.__submit.apply(this, [_this, ev]);
        
        var formData = new FormData(this);
        formData.delete("file");

        for(var key in _this.attach.filesAttachment){
            formData.append("file[]", _this.attach.filesAttachment[key].fileData.file);
        };
        
        replaceDocumentAjax.scope.form  = _this;
        replaceDocumentAjax.scope.modal = _this.parentObj;
        
        replaceDocumentAjax.setData(formData);
        replaceDocumentAjax.sendAjax();
    };
};
FormReplace.prototype = new FormObj();

function FormLoadDocument(querySelector){
    FormObj.apply(this, [querySelector]);
    
    var addDocumentAjax = new AddDocumentAjax("inmail/addNewDoc", {method: "POST"});
    
    this.attach = new AttachObj(this.jQueryObj.find("input[type='file']"), {submitTrigger: true});
    this.__submit = function(_this, ev){
        FormObj.prototype.__submit.apply(this, [_this, ev]);
        
        var formData = new FormData(this);
        formData.delete("file");
        
        for(var key in _this.attach.filesAttachment){
            formData.append("file[]", _this.attach.filesAttachment[key].fileData.file);
        };
        
        addDocumentAjax.scope.form  = _this;
        addDocumentAjax.scope.table = _this.parentObj.tables.TdocStart;
        
        addDocumentAjax.setData(formData);
        addDocumentAjax.sendAjax();
        
    };
};
FormLoadDocument.prototype= new FormObj();

function FormAcknowledgment(querySelector, disableSubmit){
    FormObj.apply(this, [querySelector, disableSubmit]);
    
    var acknowledgmentDocumentAjax = new AcknowledgmentDocumentAjax("inmail/addAcknowledgment", {method: "POST"});
    
    this.attach = new AttachObj(this.jQueryObj.find("input[type='file']"), 
    {attachContainer: "acknowledgmentContainerAttach", viewButton: true});
    this.__submit = function(_this, ev){
        FormObj.prototype.__submit.apply(this, [_this, ev]);
        
        var formData = new FormData(this);
        formData.delete("file");

        for(var key in _this.attach.filesAttachment){
            formData.append("file[]", _this.attach.filesAttachment[key].fileData.file);
        };    

        acknowledgmentDocumentAjax.scope.form  = _this;
        acknowledgmentDocumentAjax.scope.modal = _this.parentObj;
        acknowledgmentDocumentAjax.scope.table = _this.parentObj.parentObj;
        
        acknowledgmentDocumentAjax.setData(formData);
        acknowledgmentDocumentAjax.sendAjax();
    };
};
FormAcknowledgment.prototype = new FormObj();

function FormAddHistory(querySelector, disableSubmit){
    FormObj.apply(this, [querySelector, disableSubmit]);
    
    var addDocHistory = new AddDocHistory("systemctr/setDocHistoryConfig", {method: "POST"});
    
    this.attach = [new AttachObj("initial-doc-file", {attachContainer: "initial-doc-container", viewButton: true}), 
        new AttachObj("final-doc-file", {attachContainer: "final-doc-container", viewButton: true})];
    
    this.__startDefaults = function(){
        
        this.select.corp         = {
            jQueryObj    : this.jQueryObj.find("select[data-key='corp']").select2({placeholder: "Inc."}),
            reset        : true,
            hasSelection : false
        };
        this.select.area         = {
            jQueryObj    : this.jQueryObj.find("select[data-key='area']").select2({placeholder: ""}),
            ajaxUri      : "manage_email/systemctr/getAreas",
            hasSelection : false
        };    
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
            })
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
        for(var key in activateIf = ["corp", "area", "year_doc_out"]){
            this.select[activateIf[key]].jQueryObj.on("select2:select", (function(selectObj){
                selectObj.hasSelection = true;
                for(var x in this.select){
                    if(this.select[x].hasSelection !== undefined){if(!this.select[x].hasSelection){
                        this.select.num_doc_out.jQueryObj.prop("disabled", true);
                        return;
                    }}
                }
                this.select.num_doc_out.jQueryObj.prop("disabled", false);
                this.setValueSelect(this.select.num_doc_out, ["code_out", "year_doc_out"], [this.select.corp.jQueryObj.find(':selected').text() + "-" + this.select.area.jQueryObj.find(':selected').text(), this.select.year_doc_out.jQueryObj.val()]);
            }).bind(this, this.select[activateIf[key]]));
        }

        this.select.num_doc_out.jQueryObj.on("select2:select", (function(selectObj){

            var codeOut      = this.select.corp.jQueryObj.find(':selected').text() + 
                    "-" + this.select.area.jQueryObj.find(':selected').text();
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
        formData.append("folio_doc_out", _this.select.corp.jQueryObj.find(':selected').text() + 
                "-" + _this.select.area.jQueryObj.find(':selected').text() + 
                "-" + _this.select.num_doc_out.jQueryObj.find(':selected').text() + 
                "/" + _this.select.year_doc_out.jQueryObj.find(':selected').text());
        formData.append("area_code", _this.select.area.jQueryObj.find(':selected').text());
        formData.delete("corp");
        formData.delete("num_doc_out");
        formData.delete("year_doc_out");
        formData.append("code_out", _this.select.corp.jQueryObj.find(':selected').text() + 
                "-" + _this.select.area.jQueryObj.find(':selected').text());
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