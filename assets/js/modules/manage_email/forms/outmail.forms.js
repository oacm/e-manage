function FormOut(querySelector, disableSubmit){
    FormObj.apply(this, [querySelector, disableSubmit]);
    
    var setOutMailAjax = new SetOutMailAjax("outmail/setResponseDocument", {method: "POST"});
    
    this.attach = new AttachObj(this.jQueryObj.find("input[type='file']"), 
                  {classContainer: this.jQueryObj.find(".attachment"), viewButton: true});
    
    this.__submit = function(_this, ev){        
        FormObj.prototype.__submit.apply(this, [_this, ev]);
    
        var formData = new FormData(this);
        formData.delete("file");

        for(var key in _this.attach.filesAttachment){
            formData.append("file[]", _this.attach.filesAttachment[key].fileData.file);
        };

        for( var pair of _this.dataMemory.entries()){
            formData.append(pair[0], pair[1]);
        }
        
        setOutMailAjax.scope.form    = _this;
        setOutMailAjax.scope.modal   = _this.parentObj;
        setOutMailAjax.scope.table   = _this.parentObj.parentObj;
        
        setOutMailAjax.setData(formData);
        setOutMailAjax.sendAjax();
    };
}
FormOut.prototype = new FormObj();