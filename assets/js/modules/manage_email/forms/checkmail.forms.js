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

function FormAction(querySelector, disableSubmit){
    FormObj.apply(this, [querySelector, disableSubmit]);
    
    var configResponseDocAjax = new ConfigResponseDocAjax("checkmail/addAnsweredDocument", {method: "POST"});
    
    this.attach = new AttachObj(this.jQueryObj.find("input[type='file']"), 
    {classContainer: this.jQueryObj.find(".attachment"), viewButton: true});

    this.__submit        = function(_this, ev){
        
        FormObj.prototype.__submit.apply(this, [_this, ev]);
        
        var formData = new FormData(this);
        
        for( var pair of _this.dataMemory.entries()){formData.append(pair[0], pair[1]);}
        _this.dataMemory = {};
        
        formData.delete("file");
        
        for(var key in _this.attach.filesAttachment){
            formData.append("file[]", _this.attach.filesAttachment[key].fileData.file);
        };

        for( var pair of formData.entries()){_this.dataMemory[pair[0]] = pair[1];}
        
        configResponseDocAjax.scope.form    = _this;
        configResponseDocAjax.scope.modal   = _this.parentObj;
        configResponseDocAjax.scope.table   = _this.parentObj.parentObj.parentObj.parentObj;
        
        configResponseDocAjax.setData(formData);
        configResponseDocAjax.sendAjax();
    };
};
FormAction.prototype = new FormObj();

function FormInbox(querySelector, disableSubmit){
    FormObj.apply(this, [querySelector, disableSubmit]);
    
    this.modals = {
        "answeredModal": new ModalForm("modal-win-info-answered", "FormAction")
    };
    
    this.showModal         = function(formData, modal, msg){
        
        this.modals[modal].jQueryObj.find(".folio-doc").text(this.dataMemory.control_folio);
        
        this.modals[modal].form.dataMemory = formData;
        this.modals[modal].form.message    = msg;
        
        this.modals[modal].showModal();
        
        this.modals[modal].jQueryObj.find(".folio-doc").text(this.dataMemory.control_folio);
    };
    
    this.showAnsweredModal = function (_this, modal){
        
        if(!_this.jQueryObj[0].checkValidity()){return;}
                
        var formData = new FormData(_this.jQueryObj.get(0));
        formData.append("numDocument", _this.dataMemory.control_folio);
        formData.append("areaCode", _this.dataMemory.areaCode);
        formData.delete("comments");
        
        _this.showModal(formData, modal, "Se envío el documento para respuesta.");
    };
    
    this.resetPanel        = function(_this){
        var alias = _this || this;
        $(".antecedent-panel").css("display", "none");
        alias.parentObj.parentObj.parentObj.parentObj.closePanel();
        alias.__reset();
    };
    
    this.__startDefaults   = function(){
        var buttons            = this.jQueryObj.find("[data-buttons='answered']");
                
        buttons.find("[data-action='answered']").click($.proxy(this.showAnsweredModal, null, this, "answeredModal"));
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