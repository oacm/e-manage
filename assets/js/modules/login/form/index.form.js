function FormChangePass(querySelector, disableSubmit){
    FormObj.apply(this, [querySelector, disableSubmit]);
    
    var updatePass = new UpdatePass("module/session/loginctr/updatepass", {method: "POST"});
    
    this.__startDefaults = function(){
        
        validator.message.empty           = "campo requerido";
        validator.message.password_repeat = "los password no coinciden";
        
        this.jQueryObj
            .on('blur', 'input[required], input.optional, select.required', validator.checkField)
            .on('change', 'select.required', validator.checkField)
            .on('keypress', 'input[required][pattern]', validator.keypress);
    
        $('.multi.required').on('keyup blur', 'input', function() {
            validator.checkField.apply($(this).siblings().last()[0]);
        });
        
    };
    
    this.__submit        = function(_this, ev){
        FormObj.prototype.__submit.apply(this, [_this, ev]);
        
        if (!validator.checkAll(_this.jQueryObj)) {return false;}        
        
        var formData = new FormData(this);
        
        updatePass.scope.form  = _this;
        updatePass.scope.modal = _this.parentObj;

        updatePass.setData(formData);
        updatePass.sendAjax();
    };
    
};
FormChangePass.prototype = new FormObj();